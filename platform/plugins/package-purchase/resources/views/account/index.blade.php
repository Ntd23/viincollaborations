{{-- English description: Displays the package customer account dashboard with overview, wallet, orders, and settings tabs. --}}

@php
    $lang = 'plugins/package-purchase::package-purchase.account.';
    $navItems = [
        'overview' => ['label' => trans($lang . 'overview'), 'icon' => 'ti ti-home'],
        'wallet' => ['label' => trans($lang . 'wallet'), 'icon' => 'ti ti-wallet'],
        'orders' => ['label' => trans($lang . 'orders'), 'icon' => 'ti ti-shopping-bag'],
        'settings' => ['label' => trans($lang . 'settings'), 'icon' => 'ti ti-settings'],
    ];

    $initials = collect(explode(' ', $customer->name))
        ->filter()
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<div class="py-4">
    @include('plugins/package-purchase::partials.alerts')

    <div class="row g-5">
        <aside class="col-lg-3">
            <div class="border rounded-4 overflow-hidden bg-white">
                <div class="d-flex align-items-center gap-3 p-4 bg-light">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 58px; height: 58px;">
                        {{ $initials ?: 'U' }}
                    </div>
                    <div>
                        <strong class="d-block">{{ $customer->name }}</strong>
                        <span class="text-muted small">{{ $customer->email }}</span>
                    </div>
                </div>

                <nav class="p-3">
                    @foreach ($navItems as $key => $item)
                        <a
                            href="{{ route('public.package-purchase.account', ['tab' => $key]) }}"
                            @class([
                                'd-flex align-items-center gap-3 px-3 py-3 rounded-3 fw-semibold text-decoration-none mb-2',
                                'bg-primary text-white' => $tab === $key,
                                'text-900' => $tab !== $key,
                            ])
                        >
                            <x-core::icon :name="$item['icon']" />
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    <form method="POST" action="{{ route('public.package-purchase.logout') }}">
                        @csrf
                        <button type="submit" class="btn w-100 d-flex align-items-center gap-3 px-3 py-3 fw-semibold text-start">
                            <x-core::icon name="ti ti-logout" />
                            {{ trans($lang . 'logout') }}
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <div class="col-lg-9">
            @if ($tab === 'overview')
                <h1 class="h2 mb-4">{{ trans($lang . 'overview') }}</h1>

                <div class="border-top pt-4">
                    <div class="border rounded-4 p-5 bg-white text-center mb-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-bold mb-3" style="width: 96px; height: 96px; font-size: 34px;">
                            {{ $initials ?: 'U' }}
                        </div>
                        <h2 class="h4">{{ trans($lang . 'welcome_back', ['name' => $customer->name]) }}</h2>
                        <p class="mb-0 text-muted">{{ trans($lang . 'dashboard_intro') }}</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="rounded-4 p-4 text-center h-100" style="background: #e8f1ff;">
                                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                    <x-core::icon name="ti ti-shopping-bag" />
                                </div>
                                <h3 class="h5">{{ trans($lang . 'view_orders') }}</h3>
                                <p class="text-muted">{{ trans($lang . 'orders_intro') }}</p>
                                <a href="{{ route('public.package-purchase.account', ['tab' => 'orders']) }}" class="btn btn-primary">{{ trans($lang . 'view_orders') }}</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded-4 p-4 text-center h-100" style="background: #e8f5ef;">
                                <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                    <x-core::icon name="ti ti-wallet" />
                                </div>
                                <h3 class="h5">{{ trans($lang . 'wallet') }}</h3>
                                <p class="text-muted">{{ trans($lang . 'wallet_intro') }}</p>
                                <a href="{{ route('public.package-purchase.account', ['tab' => 'wallet']) }}" class="btn btn-success">{{ trans($lang . 'view_wallet') }}</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded-4 p-4 text-center h-100" style="background: #fff7df;">
                                <div class="rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                    <x-core::icon name="ti ti-settings" />
                                </div>
                                <h3 class="h5">{{ trans($lang . 'settings') }}</h3>
                                <p class="text-muted">{{ trans($lang . 'settings_intro') }}</p>
                                <a href="{{ route('public.package-purchase.account', ['tab' => 'settings']) }}" class="btn btn-warning">{{ trans($lang . 'edit_account') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($tab === 'wallet')
                <h1 class="h2 mb-4">{{ trans($lang . 'wallet') }}</h1>

                <div class="border rounded-4 p-5 bg-white">
                    <span class="text-muted">{{ trans($lang . 'available_balance') }}</span>
                    <h2 class="display-6 mt-2">{{ package_purchase_format_price(0) }}</h2>
                    <p class="mb-0 text-muted">{{ trans($lang . 'wallet_display_only') }}</p>
                </div>
            @elseif ($tab === 'orders')
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 mb-0">{{ trans($lang . 'orders') }}</h1>
                    <span class="badge bg-primary">{{ trans_choice($lang . 'orders_count', $orderCount, ['count' => $orderCount]) }}</span>
                </div>

                @if ($orders->isNotEmpty())
                    <div class="vstack gap-4">
                        @foreach ($orders as $order)
                            <div class="border rounded-4 bg-white overflow-hidden">
                                <div class="p-4 border-bottom">
                                    <h2 class="h5 mb-2">{{ trans($lang . 'order_code', ['code' => package_purchase_order_code($order->getKey())]) }}</h2>
                                    <div class="d-flex align-items-center gap-2">
                                        {!! $order->status->toHtml() !!}
                                        <span class="text-muted">•</span>
                                        <span class="text-muted">{{ $order->created_at->translatedFormat('M d, Y') }}</span>
                                    </div>
                                </div>

                                <div class="row g-0 p-4">
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <span class="text-muted text-uppercase small">{{ trans($lang . 'total') }}</span>
                                        <strong class="d-block fs-5">{{ package_purchase_format_price($order->amount, $order->currency) }}</strong>
                                    </div>
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <span class="text-muted text-uppercase small">{{ trans('plugins/package-purchase::package-purchase.order.package') }}</span>
                                        <strong class="d-block fs-5">{{ $order->package_name }}</strong>
                                    </div>
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <span class="text-muted text-uppercase small">{{ trans('plugins/package-purchase::package-purchase.order.consultation_language') }}</span>
                                        <strong class="d-block fs-5">{{ package_purchase_consultation_language_label($order->consultation_language) }}</strong>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="text-muted text-uppercase small">{{ trans($lang . 'payment') }}</span>
                                        <strong class="d-block fs-5">{{ $order->payment_method ?: trans($lang . 'not_selected') }}</strong>
                                        <span class="text-muted small">
                                            {{ trans($lang . 'sepay_payable') }}:
                                            {{ package_purchase_format_price($order->payment_amount, $order->payment_currency) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4 border-top text-end">
                                    <a href="{{ route('public.package-purchase.orders.show', $order) }}" class="btn btn-primary">
                                        <x-core::icon name="ti ti-eye" />
                                        {{ trans($lang . 'view_detail') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="border rounded-4 p-5 bg-white text-center">
                        <p class="mb-0">{{ trans($lang . 'no_orders') }}</p>
                    </div>
                @endif
            @else
                <h1 class="h2 mb-4">{{ trans($lang . 'settings') }}</h1>

                <div class="vstack gap-4">
                    <form method="POST" action="{{ route('public.package-purchase.profile.update') }}" class="border rounded-4 p-5 bg-white">
                        @csrf

                        <h2 class="h5 mb-1">{{ trans($lang . 'profile_info') }}</h2>
                        <p class="text-muted mb-4">{{ trans($lang . 'profile_intro') }}</p>

                        <div class="mb-3">
                            <label class="form-label" for="name">{{ trans($lang . 'full_name') }}</label>
                            <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $customer->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="dob">{{ trans($lang . 'dob') }}</label>
                            <input class="form-control" id="dob" type="date" name="dob" value="{{ old('dob', $customer->dob?->format('Y-m-d')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">{{ trans($lang . 'email') }}</label>
                            <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $customer->email) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="phone">{{ trans($lang . 'phone') }}</label>
                            <input class="form-control" id="phone" type="text" name="phone" value="{{ old('phone', $customer->phone) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ trans($lang . 'update') }}</button>
                    </form>

                    <form method="POST" action="{{ route('public.package-purchase.password.update') }}" class="border rounded-4 p-5 bg-white">
                        @csrf

                        <h2 class="h5 mb-4">{{ trans($lang . 'change_password') }}</h2>

                        <div class="mb-3">
                            <label class="form-label" for="current_password">{{ trans($lang . 'current_password') }}</label>
                            <input class="form-control" id="current_password" type="password" name="current_password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">{{ trans($lang . 'new_password') }}</label>
                            <input class="form-control" id="password" type="password" name="password" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="password_confirmation">{{ trans($lang . 'confirm_new_password') }}</label>
                            <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ trans($lang . 'change_password') }}</button>
                    </form>

                    <form method="POST" action="{{ route('public.package-purchase.account.destroy') }}" class="border rounded-4 p-5 bg-white">
                        @csrf
                        @method('DELETE')

                        <h2 class="h5 mb-1 text-danger">{{ trans($lang . 'delete_account') }}</h2>
                        <p class="text-muted mb-4">{{ trans($lang . 'delete_account_intro') }}</p>

                        <div class="mb-4">
                            <label class="form-label" for="delete_current_password">{{ trans($lang . 'delete_password_confirmation') }}</label>
                            <input class="form-control" id="delete_current_password" type="password" name="current_password" required>
                        </div>

                        <button type="submit" class="btn btn-danger">{{ trans($lang . 'delete_account') }}</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
