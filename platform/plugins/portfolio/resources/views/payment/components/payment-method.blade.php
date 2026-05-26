@props([
    'name',
    'paymentName',
    'logo' => null,
])

<div class="form-check payment-method-item border rounded-3 p-3 mb-2 d-flex align-items-center">
    <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="payment_{{ $name }}" value="{{ $name }}" {{ $name === 'sepay' ? 'checked' : '' }}>
    <label class="form-check-label w-100 d-flex align-items-center justify-content-between cursor-pointer mb-0" for="payment_{{ $name }}">
        <span class="fw-bold fs-6">{{ $paymentName }}</span>
        @if($logo)
            <img src="{{ $logo }}" alt="{{ $paymentName }}" style="max-height: 25px;">
        @elseif($name === 'sepay')
            <img src="{{ asset('vendor/core/plugins/fob-sepay/images/sepay.png') }}" alt="SePay" style="max-height: 25px;">
        @endif
    </label>
</div>
