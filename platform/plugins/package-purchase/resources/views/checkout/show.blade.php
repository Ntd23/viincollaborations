{{-- English description: Displays the checkout confirmation page for a selected package. --}}
@php
    $packageAmount = package_purchase_parse_price($package->price);
    $consultationLanguages = package_purchase_consultation_languages();
@endphp

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="mb-4">
                    <span class="text-primary fw-semibold">{{ trans('plugins/package-purchase::package-purchase.name') }}</span>
                    <h1 class="ds-5 mt-2 mb-0">{{ __('Confirm Package') }}</h1>
                </div>

                @include('plugins/package-purchase::partials.alerts')

                <div class="border rounded-4 p-4 p-md-5 bg-white shadow-sm">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-4 mb-4">
                        <div>
                            <h2 class="h3 mb-2">{{ $package->name }}</h2>

                            @if ($package->description)
                                <p class="text-muted mb-0">{{ $package->description }}</p>
                            @endif
                        </div>

                        <div class="text-md-end">
                            <strong class="h2 text-primary mb-0 d-block">{{ $packageAmount <= 0 ? __('Free') : package_purchase_format_price($package->price) }}</strong>
                            @if ($packageAmount > 0)
                                <span class="text-muted">/{{ $package->duration->label() }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-3 bg-light p-3 mb-4">
                        <span class="text-muted">{{ trans('plugins/package-purchase::package-purchase.order.consultation_language') }}</span>
                        <strong class="d-block fs-5">{{ $consultationLanguages[$consultationLanguage] ?? $consultationLanguage }}</strong>
                    </div>

                    <form method="POST" action="{{ route('public.package-purchase.checkout.store', $package) }}">
                        @csrf
                        <input type="hidden" name="consultation_language" value="{{ $consultationLanguage }}">

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="customer_whatsapp_phone">
                                {{ trans('plugins/package-purchase::package-purchase.account.customer_whatsapp_phone') }}
                            </label>
                            <input
                                @class(['form-control form-control-lg', 'is-invalid' => $errors->has('customer_whatsapp_phone')])
                                id="customer_whatsapp_phone"
                                type="text"
                                name="customer_whatsapp_phone"
                                value="{{ old('customer_whatsapp_phone') }}"
                                placeholder="+84901234567"
                                required
                            >
                            @error('customer_whatsapp_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <small class="text-muted">{{ trans('plugins/package-purchase::package-purchase.account.customer_whatsapp_phone_helper') }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-gradient w-100 py-3 fw-semibold">{{ __('Create Order') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
