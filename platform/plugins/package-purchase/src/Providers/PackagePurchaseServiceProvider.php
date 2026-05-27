<?php

// English description: Registers the package purchase plugin services, routes, admin menu, and settings panel entry.

namespace Botble\PackagePurchase\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\PackagePurchase\Http\Middleware\AuthenticateCustomer;
use Botble\PackagePurchase\Http\Middleware\RedirectIfCustomerAuthenticated;
use Botble\PackagePurchase\Models\Customer;
use Botble\Setting\PanelSections\SettingOthersPanelSection;

class PackagePurchaseServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        config()->set('auth.guards.package-customer', [
            'driver' => 'session',
            'provider' => 'package-customers',
        ]);

        config()->set('auth.providers.package-customers', [
            'driver' => 'eloquent',
            'model' => Customer::class,
        ]);
    }

    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('package-customer', AuthenticateCustomer::class);
        $this->app['router']->aliasMiddleware('package-customer.guest', RedirectIfCustomerAuthenticated::class);

        $this
            ->setNamespace('plugins/package-purchase')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->loadMigrations();

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-package-purchase',
                    'priority' => 11,
                    'name' => 'plugins/package-purchase::package-purchase.name',
                    'icon' => 'ti ti-shopping-bag',
                    'permissions' => ['plugins.package-purchase'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-package-purchase-customers',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-package-purchase',
                    'name' => 'plugins/package-purchase::package-purchase.customers',
                    'icon' => 'ti ti-users',
                    'url' => route('package-purchase.customers.index'),
                    'permissions' => ['package-purchase.customers.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-package-purchase-orders',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-package-purchase',
                    'name' => 'plugins/package-purchase::package-purchase.orders',
                    'icon' => 'ti ti-receipt',
                    'url' => route('package-purchase.orders.index'),
                    'permissions' => ['package-purchase.orders.index'],
                ]);
        });

        PanelSectionManager::default()->beforeRendering(function (): void {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('package-purchase')
                    ->setTitle(trans('plugins/package-purchase::package-purchase.settings.currencies'))
                    ->withIcon('ti ti-file-dollar')
                    ->withPriority(145)
                    ->withDescription(trans('plugins/package-purchase::package-purchase.settings.description'))
                    ->withRoute('package-purchase.settings.edit')
                    ->withPermission('package-purchase.settings.edit')
            );
        });
    }
}
