<?php

// English description: Handles frontend customer authentication for package purchases.

namespace Botble\PackagePurchase\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\PackagePurchase\Enums\CustomerStatusEnum;
use Botble\PackagePurchase\Http\Requests\LoginRequest;
use Botble\PackagePurchase\Http\Requests\RegisterRequest;
use Botble\PackagePurchase\Models\Customer;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        return Theme::of('plugins/package-purchase::auth.login')->render();
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::guard('package-customer')->attempt($credentials, $remember)) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => trans('plugins/package-purchase::package-purchase.account.invalid_credentials'),
            ]);
        }

        $customer = Auth::guard('package-customer')->user();

        if (! $customer->isActivated()) {
            Auth::guard('package-customer')->logout();

            return back()->withInput($request->only('email'))->withErrors([
                'email' => trans('plugins/package-purchase::package-purchase.account.account_not_active'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('public.package-purchase.account'));
    }

    public function showRegistrationForm()
    {
        return Theme::of('plugins/package-purchase::auth.register')->render();
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $customer = Customer::query()->create([
            ...$request->validated(),
            'status' => CustomerStatusEnum::ACTIVATED,
        ]);

        Auth::guard('package-customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->intended(route('public.package-purchase.account'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('package-customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}
