<?php

// English description: Defines admin permissions for package customer and order management.

return [
    [
        'name' => 'Package Purchase',
        'flag' => 'plugins.package-purchase',
    ],
    [
        'name' => 'Customers',
        'flag' => 'package-purchase.customers.index',
        'parent_id' => 'plugins.package-purchase',
    ],
    [
        'name' => 'Edit',
        'flag' => 'package-purchase.customers.edit',
        'parent_flag' => 'package-purchase.customers.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'package-purchase.customers.destroy',
        'parent_flag' => 'package-purchase.customers.index',
    ],
    [
        'name' => 'Orders',
        'flag' => 'package-purchase.orders.index',
        'parent_id' => 'plugins.package-purchase',
    ],
    [
        'name' => 'Edit',
        'flag' => 'package-purchase.orders.edit',
        'parent_flag' => 'package-purchase.orders.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'package-purchase.orders.destroy',
        'parent_flag' => 'package-purchase.orders.index',
    ],
    [
        'name' => 'Settings',
        'flag' => 'package-purchase.settings.edit',
        'parent_flag' => 'settings.others',
    ],
];
