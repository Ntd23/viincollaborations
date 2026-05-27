<?php

// English description: Defines admin and frontend routes for package purchase accounts and orders.

use Botble\Base\Facades\AdminHelper;
use Botble\PackagePurchase\Http\Controllers\AccountController;
use Botble\PackagePurchase\Http\Controllers\AuthController;
use Botble\PackagePurchase\Http\Controllers\CheckoutController;
use Botble\PackagePurchase\Http\Controllers\CustomerController;
use Botble\PackagePurchase\Http\Controllers\OrderController;
use Botble\PackagePurchase\Http\Controllers\SettingsController;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::prefix('package-purchase')->name('package-purchase.')->group(function (): void {
        Route::resource('customers', CustomerController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::resource('orders', OrderController::class)->only(['index', 'edit', 'update', 'destroy']);
    });

    Route::prefix('settings')->name('package-purchase.')->group(function (): void {
        Route::get('package-purchase', [
            'as' => 'settings.edit',
            'uses' => SettingsController::class . '@edit',
            'permission' => 'package-purchase.settings.edit',
        ]);

        Route::put('package-purchase', [
            'as' => 'settings.update',
            'uses' => SettingsController::class . '@update',
            'permission' => 'package-purchase.settings.edit',
        ]);
    });
});

Theme::registerRoutes(function (): void {
    Route::prefix('account')->name('public.package-purchase.')->group(function (): void {
        Route::middleware('package-customer.guest')->group(function (): void {
            Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
            Route::post('login', [AuthController::class, 'login'])->name('login.post');
            Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
            Route::post('register', [AuthController::class, 'register'])->name('register.post');
        });

        Route::middleware('package-customer')->group(function (): void {
            Route::get('/', [AccountController::class, 'index'])->name('account');
            Route::get('orders/{order}', [AccountController::class, 'showOrder'])->name('orders.show');
            Route::post('profile', [AccountController::class, 'updateProfile'])->name('profile.update');
            Route::post('password', [AccountController::class, 'updatePassword'])->name('password.update');
            Route::delete('/', [AccountController::class, 'destroy'])->name('account.destroy');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });
    });

    Route::middleware('package-customer')->prefix('account/packages')->name('public.package-purchase.')->group(function (): void {
        Route::get('{package}/consultation/{consultationLanguage}', [CheckoutController::class, 'selectConsultationLanguage'])->name('consultation-language');
        Route::get('{package}/checkout', [CheckoutController::class, 'show'])->name('checkout');
        Route::post('{package}/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });
});
