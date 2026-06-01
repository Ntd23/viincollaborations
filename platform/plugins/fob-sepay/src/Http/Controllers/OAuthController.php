<?php

// English description: Handles SePay OAuth connection, callback, and disconnection flows.

namespace FriendsOfBotble\SePay\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use FriendsOfBotble\SePay\Actions\VerifySignatureAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OAuthController extends BaseController
{
    protected function scopes(): string
    {
        return 'profile bank-account:read transaction:read webhook:read webhook:write';
    }

    public function connect()
    {
        $state = bin2hex(random_bytes(16));

        session()->put('sepay_oauth_state', $state);

        $clientId = get_payment_setting('client_id', SEPAY_PAYMENT_METHOD_NAME);
        $clientSecret = get_payment_setting('client_secret', SEPAY_PAYMENT_METHOD_NAME);

        if ($clientId && $clientSecret) {
            $redirectUri = route('sepay.oauth.callback');
            if (str_contains($redirectUri, 'test') || str_contains($redirectUri, 'localhost') || str_contains($redirectUri, '127.0.0.1')) {
                $redirectUri = 'https://viincollaborations.com/sepay/oauth/callback';
            }

            $queryParams = http_build_query([
                'response_type' => 'code',
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'scope' => $this->scopes(),
                'state' => $state,
            ]);

            return redirect()->away("https://my.sepay.vn/oauth/authorize?$queryParams");
        }

        $queryParams = http_build_query([
            'callback_url' => route('sepay.oauth.callback'),
            'scope' => $this->scopes(),
            'state' => $state,
        ]);

        return redirect()->away(SEPAY_FOB_URL . "/oauth/sepay/init?$queryParams");
    }

    public function callback(Request $request, VerifySignatureAction $verifySignatureAction)
    {
        $validated = $request->validate([
            'access_token' => 'required|string',
            'refresh_token' => 'required|string',
            'expires_in' => 'required|integer',
            'state' => 'required|string',
            'signature' => 'required|string',
        ]);

        if (! $verifySignatureAction($validated)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        setting()->set([
            'sepay_access_token' => $validated['access_token'],
            'sepay_refresh_token' => $validated['refresh_token'],
            'sepay_expired_at' => now()->addSeconds($validated['expires_in']),
            'sepay_connected_at' => now(),
        ])->save();

        return response()->json(['success' => true]);
    }

    public function getCallback(Request $request)
    {
        $clientId = get_payment_setting('client_id', SEPAY_PAYMENT_METHOD_NAME);
        $clientSecret = get_payment_setting('client_secret', SEPAY_PAYMENT_METHOD_NAME);

        if ($clientId && $clientSecret && $request->has('code')) {
            $state = session()->pull('sepay_oauth_state');
            if ($request->input('state') !== $state) {
                return response('Mã xác thực không hợp lệ. Vui lòng thử lại.', 400);
            }

            try {
                $response = \Illuminate\Support\Facades\Http::asForm()->post('https://my.sepay.vn/oauth/token', [
                    'grant_type' => 'authorization_code',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'redirect_uri' => route('sepay.oauth.callback'),
                    'code' => $request->input('code'),
                ]);

                $data = $response->json();

                if (! isset($data['access_token']) || ! isset($data['refresh_token'])) {
                    $errorMsg = $data['message'] ?? ($data['error_description'] ?? ($data['error'] ?? json_encode($data)));
                    throw new \Exception('Xác thực thất bại từ SePay: ' . $errorMsg);
                }

                setting()->set([
                    'sepay_access_token' => $data['access_token'],
                    'sepay_refresh_token' => $data['refresh_token'],
                    'sepay_expired_at' => now()->addSeconds($data['expires_in']),
                    'sepay_connected_at' => now(),
                ])->save();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('SePay OAuth Exchange Error: ' . $e->getMessage());
                return '<h3>Lỗi kết nối SePay</h3><p>' . e($e->getMessage()) . '</p><button onclick="window.close()">Đóng cửa sổ</button>';
            }
        }

        return <<<HTML
            <script>
                window.opener.location.reload();
                window.close();
            </script>
        HTML;
    }

    public function disconnect()
    {
        setting()->set([
            'sepay_access_token' => null,
            'sepay_refresh_token' => null,
            'sepay_expired_at' => null,
            'sepay_connected_at' => null,
            'sepay_webhook_id' => null,
        ])->save();

        Cache::forget('sepay.profile');
        Cache::forget('sepay.bank-accounts');

        return $this
            ->httpResponse()
            ->setMessage('Ngắt kết nối với SePay thành công')
            ->setData(['success' => true]);
    }

    public function manualConnect(Request $request)
    {
        $clientId = get_payment_setting('client_id', SEPAY_PAYMENT_METHOD_NAME);
        $clientSecret = get_payment_setting('client_secret', SEPAY_PAYMENT_METHOD_NAME);

        if (! $clientId || ! $clientSecret) {
            return $this->httpResponse()
                ->setError()
                ->setMessage('Vui lòng cấu hình Client ID và Client Secret trước.');
        }

        $callbackUrl = $request->input('callback_url');
        if (! $callbackUrl) {
            return $this->httpResponse()
                ->setError()
                ->setMessage('Vui lòng nhập URL Callback.');
        }

        // Parse code từ URL
        $parsedUrl = parse_url($callbackUrl);
        parse_str($parsedUrl['query'] ?? '', $queryParams);

        $code = $queryParams['code'] ?? null;
        if (! $code) {
            return $this->httpResponse()
                ->setError()
                ->setMessage('Không tìm thấy mã xác thực (code) trong URL.');
        }

        try {
            // Khi gửi yêu cầu post token, redirect_uri phải khớp với redirect_uri đã dùng để xin authorize code
            $redirectUri = 'https://viincollaborations.com/sepay/oauth/callback';

            $response = \Illuminate\Support\Facades\Http::asForm()->post('https://my.sepay.vn/oauth/token', [
                'grant_type' => 'authorization_code',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]);

            $data = $response->json();

            if (! isset($data['access_token']) || ! isset($data['refresh_token'])) {
                $errorMsg = $data['message'] ?? ($data['error_description'] ?? ($data['error'] ?? json_encode($data)));
                throw new \Exception('Xác thực thất bại từ SePay: ' . $errorMsg);
            }

            setting()->set([
                'sepay_access_token' => $data['access_token'],
                'sepay_refresh_token' => $data['refresh_token'],
                'sepay_expired_at' => now()->addSeconds($data['expires_in']),
                'sepay_connected_at' => now(),
            ])->save();

            // Clear cache để load profile mới
            Cache::forget('sepay.profile');
            Cache::forget('sepay.bank-accounts');

            return $this->httpResponse()
                ->setMessage('Kết nối thủ công với SePay thành công!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('SePay Manual Connect OAuth Exchange Error: ' . $e->getMessage());
            return $this->httpResponse()
                ->setError()
                ->setMessage('Lỗi kết nối SePay: ' . $e->getMessage());
        }
    }
}
