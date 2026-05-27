<?php

// English description: Redirects logged-in package customers away from guest-only pages.

namespace Botble\PackagePurchase\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfCustomerAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('package-customer')->check()) {
            return redirect()->route('public.package-purchase.account');
        }

        return $next($request);
    }
}
