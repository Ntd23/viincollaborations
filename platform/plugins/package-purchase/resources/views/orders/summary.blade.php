{{-- English description: Shows a read-only summary for a package order in the admin form. --}}

<x-core::datagrid class="mb-4">
    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.customer') }}</x-slot:title>
        {{ $order->customer->name }} &lt;{{ $order->customer->email }}&gt;
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.package') }}</x-slot:title>
        {{ $order->package_name }}
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.amount') }}</x-slot:title>
        {{ package_purchase_format_price($order->amount, $order->currency) }}
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.payment_amount') }}</x-slot:title>
        {{ package_purchase_format_price($order->payment_amount, $order->payment_currency) }}
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.consultation_language') }}</x-slot:title>
        {{ package_purchase_consultation_language_label($order->consultation_language) }}
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.customer_whatsapp_phone') }}</x-slot:title>
        {{ $order->customer_whatsapp_phone ?: '...' }}
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.whatsapp_notification_status') }}</x-slot:title>
        {{ $order->whatsapp_notification_status ?: '...' }}
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/package-purchase::package-purchase.order.payment_reference') }}</x-slot:title>
        {{ $order->payment_reference ?: '...' }}
    </x-core::datagrid.item>
</x-core::datagrid>
