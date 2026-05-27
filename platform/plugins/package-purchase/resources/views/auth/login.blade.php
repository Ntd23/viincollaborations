{{-- English description: Displays the frontend login form for package customers. --}}

@php
    $lang = 'plugins/package-purchase::package-purchase.account.';
@endphp

<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <h3 class="h3 mb-4">{{ trans($lang . 'customer_login') }}</h3>

            @include('plugins/package-purchase::partials.alerts')

            <form method="POST" action="{{ route('public.package-purchase.login.post') }}" class="border rounded-4 p-5 bg-white">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="email">{{ trans($lang . 'email') }}</label>
                    <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">{{ trans($lang . 'password') }}</label>
                    <input class="form-control" id="password" type="password" name="password">
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" id="remember" type="checkbox" name="remember" value="1">
                    <label class="form-check-label" for="remember">{{ trans($lang . 'remember_me') }}</label>
                </div>

                <button type="submit" class="btn btn-gradient w-100">{{ trans($lang . 'login') }}</button>
            </form>

            <p class="mt-4 mb-0">
                {{ trans($lang . 'no_account_yet') }}
                <a href="{{ route('public.package-purchase.register') }}">{{ trans($lang . 'create_one') }}</a>
            </p>
        </div>
    </div>
</div>
