<?php

// English description: Redirects guests away from customer-only package purchase pages.

namespace Botble\PackagePurchase\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth('package-customer')->check()) {
            return redirect()->guest(route('public.package-purchase.login'));
        }

        return $next($request);
    }
}
