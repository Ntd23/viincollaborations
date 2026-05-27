{{-- English description: Displays the checkout confirmation page for a selected package. --}}
@php
    $packageAmount = package_purchase_parse_price($package->price);
@endphp

    <div class="py-4">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <h1 class="h3 mb-4">{{ __('Confirm Package') }}</h1>

                @include('plugins/package-purchase::partials.alerts')

                <div class="border rounded-4 p-5 bg-white">
                    <h2 class="h4">{{ $package->name }}</h2>

                    @if ($package->description)
                        <p>{{ $package->description }}</p>
                    @endif

                    <div class="d-flex align-items-end mb-4">
                        <strong class="h3 text-primary mb-0">{{ $packageAmount <= 0 ? __('Free') : package_purchase_format_price($package->price) }}</strong>
                        @if ($packageAmount > 0)
                            <span class="ms-2">/{{ $package->duration->label() }}</span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('public.package-purchase.checkout.store', $package) }}">
                        @csrf
                        <input type="hidden" name="payment_method" value="manual_transfer">

                        <button type="submit" class="btn btn-gradient w-100">{{ __('Create Order') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
