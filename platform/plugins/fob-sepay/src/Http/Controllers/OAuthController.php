<?php

namespace FriendsOfBotble\SePay\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use FriendsOfBotble\SePay\Actions\VerifySignatureAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OAuthController extends BaseController
{
    public function connect()
    {
        $state = bin2hex(random_bytes(16));

        session()->put('sepay_oauth_state', $state);

        $queryParams = http_build_query([
            'callback_url' => route('sepay.oauth.callback'),
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

    public function getCallback()
    {
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
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $token = $validated['token'];

        try {
            // Kiểm tra token bằng cách gọi thử API "me"
            $response = \Illuminate\Support\Facades\Http::baseUrl('https://my.sepay.vn/api/v1')
                ->withToken($token)
                ->get('me');

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token không hợp lệ hoặc đã hết hạn (Mã lỗi: ' . $response->status() . ')'
                ], 400);
            }

            $data = $response->json();
            if (isset($data['status']) && $data['status'] !== 'success') {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Token không hợp lệ.'
                ], 400);
            }

            // Xoá cache profile & bank-accounts cũ nếu có
            \Illuminate\Support\Facades\Cache::forget('sepay.profile');
            \Illuminate\Support\Facades\Cache::forget('sepay.bank-accounts');

            // Lưu cài đặt
            setting()->set([
                'sepay_access_token' => $token,
                'sepay_refresh_token' => 'manual_token',
                'sepay_expired_at' => now()->addYears(100),
                'sepay_connected_at' => now(),
            ])->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể kết nối đến SePay: ' . $e->getMessage()
            ], 500);
        }
    }
}
