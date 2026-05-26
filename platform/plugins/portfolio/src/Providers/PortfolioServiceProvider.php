<?php

namespace Botble\Portfolio\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Facades\EmailHandler;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Portfolio\Forms\Fronts\QuotationForm;
use Botble\Portfolio\Http\Requests\QuoteRequest;
use Botble\Portfolio\Models\CustomField;
use Botble\Portfolio\Models\CustomFieldOption;
use Botble\Portfolio\Models\Package;
use Botble\Portfolio\Models\Project;
use Botble\Portfolio\Models\Service;
use Botble\Portfolio\Models\ServiceCategory;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Events\ThemeRoutingBeforeEvent;
use Botble\Theme\Facades\SiteMapManager;
use Botble\Theme\FormFrontManager;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Events\RouteMatched;

class PortfolioServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        // PSR-4, constants và singleton cho Botble\Payment\ được quản lý bởi payment plugin
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/portfolio')
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->loadHelpers()
            ->loadMigrations()
            ->publishAssets()
            ->registerSlugHelper()
            ->registerSeoHelper()
            ->registerLanguage();

        // Nạp bản dịch và view cho mock payment
        $this->loadTranslationsFrom(platform_path('plugins/portfolio/resources/lang/payment'), 'plugins/payment');
        $this->loadViewsFrom(platform_path('plugins/portfolio/resources/views/payment'), 'plugins/payment');

        // Đăng ký anonymous component cho <x-plugins-payment::payment-method>
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(platform_path('plugins/portfolio/resources/views/payment/components'), 'plugins-payment');
        \Illuminate\Support\Facades\Blade::componentNamespace('Botble\\Payment\\Views\\Components', 'plugins-payment');

        $this->app->register(EventServiceProvider::class);

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-portfolio',
                    'priority' => 10,
                    'name' => 'plugins/portfolio::portfolio.name',
                    'icon' => 'ti ti-briefcase',
                    'permissions' => ['plugins.portfolio'],
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-projects',
                    'priority' => 1,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'plugins/portfolio::portfolio.project.name',
                    'icon' => 'ti ti-folder',
                    'permissions' => ['portfolio.projects.index'],
                    'url' => route('portfolio.projects.index'),
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-service-categories',
                    'priority' => 2,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'plugins/portfolio::portfolio.service_category.name',
                    'icon' => 'ti ti-tags',
                    'permissions' => ['portfolio.service-categories.index'],
                    'url' => route('portfolio.service-categories.index'),
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-services',
                    'priority' => 3,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'plugins/portfolio::portfolio.service.name',
                    'icon' => 'ti ti-tools',
                    'permissions' => ['portfolio.services.index'],
                    'url' => route('portfolio.services.index'),
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-packages',
                    'priority' => 4,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'plugins/portfolio::portfolio.package.name',
                    'icon' => 'ti ti-package',
                    'permissions' => ['portfolio.packages.index'],
                    'url' => route('portfolio.packages.index'),
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-package-orders',
                    'priority' => 4.5,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'Đơn hàng',
                    'icon' => 'ti ti-shopping-cart',
                    'permissions' => ['portfolio.package-orders.index'],
                    'url' => route('portfolio.package-orders.index'),
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-payment-settings',
                    'priority' => 4.6,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'Cấu hình Thanh toán',
                    'icon' => 'ti ti-credit-card',
                    'permissions' => ['portfolio.settings.payments'],
                    'url' => route('portfolio.settings.payments'),
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-quotation-requests',
                    'priority' => 5,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'plugins/portfolio::portfolio.quotation_request.name',
                    'icon' => 'ti ti-clipboard-text',
                    'url' => route('portfolio.quotation-requests.index'),
                    'permissions' => ['portfolio.quotation-requests.index'],
                ])
                ->registerItem([
                    'id' => 'cms-core-portfolio-custom-fields',
                    'priority' => 5,
                    'parent_id' => 'cms-core-portfolio',
                    'name' => 'plugins/portfolio::portfolio.custom_field.name',
                    'icon' => 'ti ti-adjustments',
                    'url' => route('portfolio.custom-fields.index'),
                    'permissions' => ['portfolio.custom-fields.index'],
                ]);
        });

        $this->app['events']->listen(RouteMatched::class, function (): void {
            EmailHandler::addTemplateSettings('portfolio', config('plugins.portfolio.email', []));
        });

        $this->app->booted(function (Application $app): void {
            $app->register(HookServiceProvider::class);
        });

        $this->app['events']->listen(ThemeRoutingBeforeEvent::class, function (): void {
            SiteMapManager::registerKey([
                'service-categories',
                'services',
                'projects',
                'packages',
            ]);
        });

        FormFrontManager::register(QuotationForm::class, QuoteRequest::class);

        // Đăng ký lắng nghe sự kiện xử lý thanh toán thành công từ Mock Payment
        $this->app->booted(function () {
            if (defined('PAYMENT_ACTION_PAYMENT_PROCESSED')) {
                add_action(PAYMENT_ACTION_PAYMENT_PROCESSED, function (array $paymentData) {
                    $orderId = data_get($paymentData, 'order_id');
                    
                    $order = \Botble\Portfolio\Models\PackageOrder::query()->find($orderId);
                    if ($order && $order->status !== 'completed') {
                        $order->update([
                            'status' => 'completed',
                        ]);

                        // Gửi email thông báo cho Admin và khách hàng
                        try {
                            \Botble\Base\Facades\EmailHandler::setModule('portfolio')
                                ->setVariableValues([
                                    'site_name' => config('app.name'),
                                    'contact_name' => $order->name,
                                    'contact_email' => $order->email,
                                    'contact_message' => "Khách hàng {$order->name} đã thanh toán thành công gói dịch vụ: {$order->package_name} (Số tiền: " . number_format($order->amount) . " VND, Mã giao dịch: {$order->payment_code}).",
                                ])
                                ->sendUsingTemplate('quote-request-notice');
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error('Portfolio Payment Success Webhook Send Email Error: ' . $e->getMessage());
                        }
                    }
                });
            }
        });
    }

    protected function registerSlugHelper(): self
    {
        SlugHelper::registering(function (): void {
            SlugHelper::registerModule(ServiceCategory::class, fn () => trans('plugins/portfolio::portfolio.service_categories'));
            SlugHelper::registerModule(Service::class, fn () => trans('plugins/portfolio::portfolio.services'));
            SlugHelper::registerModule(Package::class, fn () => trans('plugins/portfolio::portfolio.packages'));
            SlugHelper::registerModule(Project::class, fn () => trans('plugins/portfolio::portfolio.projects'));

            SlugHelper::setPrefix(ServiceCategory::class, 'service-categories', true);
            SlugHelper::setPrefix(Service::class, 'services', true);
            SlugHelper::setPrefix(Package::class, 'packages', true);
            SlugHelper::setPrefix(Project::class, 'projects', true);
        });

        return $this;
    }

    protected function registerSeoHelper(): self
    {
        SeoHelper::registerModule(ServiceCategory::class);
        SeoHelper::registerModule(Service::class);
        SeoHelper::registerModule(Package::class);
        SeoHelper::registerModule(Project::class);

        return $this;
    }

    protected function registerLanguage(): self
    {
        if (! defined('LANGUAGE_MODULE_SCREEN_NAME') || ! defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            return $this;
        }

        LanguageAdvancedManager::registerModule(Project::class, [
            'name',
            'description',
            'content',
        ]);

        LanguageAdvancedManager::registerModule(ServiceCategory::class, [
            'name',
            'description',
        ]);

        LanguageAdvancedManager::registerModule(Service::class, [
            'name',
            'description',
            'content',
        ]);

        LanguageAdvancedManager::registerModule(Package::class, [
            'name',
            'description',
            'content',
            'price',
            'annual_price',
            'features',
            'action_label',
            'action_url',
        ]);

        LanguageAdvancedManager::registerModule(CustomField::class, [
            'name',
            'placeholder',
        ]);

        LanguageAdvancedManager::registerModule(CustomFieldOption::class, [
            'label',
            'value',
        ]);

        LanguageAdvancedManager::addTranslatableMetaBox('custom_fields_box');

        add_action(LANGUAGE_ADVANCED_ACTION_SAVED, function ($data, $request): void {
            if ($data instanceof CustomField) {
                $options = $request->input('options', []);

                if (! $options) {
                    return;
                }

                $newRequest = new Request();

                $newRequest->replace([
                    'language' => $request->input('language'),
                    'ref_lang' => $request->input('ref_lang'),
                ]);

                foreach ($options as $value) {
                    if (! isset($value['id'])) {
                        continue;
                    }

                    $option = CustomFieldOption::query()->find($value['id']);

                    $newRequest->merge([
                        'label' => $value['label'],
                        'value' => $value['value'],
                    ]);

                    if ($option) {
                        LanguageAdvancedManager::save($option, $newRequest);
                    }
                }
            }
        }, 1234, 2);

        return $this;
    }
}
