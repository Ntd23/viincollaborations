<?php

// English description: Handles frontend package customer account pages.

namespace Botble\PackagePurchase\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\PackagePurchase\Http\Requests\DeleteAccountRequest;
use Botble\PackagePurchase\Http\Requests\ProfileRequest;
use Botble\PackagePurchase\Http\Requests\UpdatePasswordRequest;
use Botble\PackagePurchase\Models\Order;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends BaseController
{
    public function index()
    {
        $customer = auth('package-customer')->user();
        $tab = request()->query('tab', 'overview');
        $availableTabs = ['overview', 'wallet', 'orders', 'settings'];

        if (! in_array($tab, $availableTabs, true)) {
            $tab = 'overview';
        }

        $orders = $customer
            ->orders()
            ->latest()
            ->paginate(10);
        $orders->appends(['tab' => 'orders']);

        $orderCount = $customer->orders()->count();

        return Theme::of('plugins/package-purchase::account.index', compact(
            'customer',
            'tab',
            'orders',
            'orderCount'
        ))->render();
    }

    public function showOrder(Order $order)
    {
        abort_if($order->customer_id !== auth('package-customer')->id(), 404);

        return Theme::of('plugins/package-purchase::account.order-detail', compact('order'))->render();
    }

    public function updateProfile(ProfileRequest $request): RedirectResponse
    {
        auth('package-customer')->user()->update($request->validated());

        return redirect()
            ->route('public.package-purchase.account', ['tab' => 'settings'])
            ->with('success', trans('plugins/package-purchase::package-purchase.account.profile_updated'));
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $customer = auth('package-customer')->user();

        if (! Hash::check($request->input('current_password'), $customer->getAuthPassword())) {
            return back()
                ->withErrors(['current_password' => trans('plugins/package-purchase::package-purchase.account.current_password_incorrect')])
                ->withInput();
        }

        $customer->update(['password' => $request->input('password')]);

        return redirect()
            ->route('public.package-purchase.account', ['tab' => 'settings'])
            ->with('success', trans('plugins/package-purchase::package-purchase.account.password_updated'));
    }

    public function destroy(DeleteAccountRequest $request): RedirectResponse
    {
        $customer = auth('package-customer')->user();

        if (! Hash::check($request->input('current_password'), $customer->getAuthPassword())) {
            return back()
                ->withErrors(['current_password' => trans('plugins/package-purchase::package-purchase.account.current_password_incorrect')])
                ->withInput();
        }

        Auth::guard('package-customer')->logout();
        $customer->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', trans('plugins/package-purchase::package-purchase.account.account_deleted'));
    }
}
