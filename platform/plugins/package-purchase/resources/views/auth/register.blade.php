{{-- English description: Displays the frontend registration form for package customers. --}}

@php
    $lang = 'plugins/package-purchase::package-purchase.account.';
@endphp

<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h3 class="h3 mb-4">{{ trans($lang . 'create_customer_account') }}</h3>

            @include('plugins/package-purchase::partials.alerts')

            <form method="POST" action="{{ route('public.package-purchase.register.post') }}" class="border rounded-4 p-5 bg-white">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="name">{{ trans($lang . 'name') }}</label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">{{ trans($lang . 'email') }}</label>
                    <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="phone">{{ trans($lang . 'phone') }}</label>
                    <input class="form-control" id="phone" type="text" name="phone" value="{{ old('phone') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">{{ trans($lang . 'password') }}</label>
                    <input class="form-control" id="password" type="password" name="password" required>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">{{ trans($lang . 'confirm_password') }}</label>
                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" id="agree_terms" type="checkbox" name="agree_terms" value="1" required @checked(old('agree_terms'))>
                    <label class="form-check-label" for="agree_terms">
                        {{ trans($lang . 'agree_terms_prefix') }}
                        <a href="{{ url('/terms-and-conditions') }}" target="_blank">{{ trans($lang . 'terms') }}</a>
                        {{ trans($lang . 'and') }}
                        <a href="{{ url('/privacy-policy') }}" target="_blank">{{ trans($lang . 'privacy_policy') }}</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-gradient w-100">{{ trans($lang . 'register') }}</button>
            </form>

            <p class="mt-4 mb-0">
                {{ trans($lang . 'already_have_account') }}
                <a href="{{ route('public.package-purchase.login') }}">{{ trans($lang . 'login') }}</a>
            </p>
        </div>
    </div>
</div>
