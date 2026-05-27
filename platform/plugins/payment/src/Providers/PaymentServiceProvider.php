<?php

namespace Botble\Payment\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;

class PaymentServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        // Đăng ký PSR-4 namespace Botble\Payment\ trỏ vào thư mục mock trong portfolio
        $loader = new \Composer\Autoload\ClassLoader();
        $loader->addPsr4('Botble\\Payment\\', platform_path('plugins/portfolio/src/Payment/'));
        $loader->register(true);

        // Đăng ký PaymentMethods singleton
        $this->app->singleton(\Botble\Payment\Supports\PaymentMethods::class, function () {
            return new \Botble\Payment\Supports\PaymentMethods();
        });

        // Định nghĩa các hằng số payment
        $constants = [
            'PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS' => 'payment_filter_additional_payment_methods',
            'PAYMENT_METHODS_SETTINGS_PAGE'             => 'payment_methods_settings_page',
            'PAYMENT_FILTER_PAYMENT_INFO_DETAIL'        => 'payment_filter_payment_info_detail',
            'PAYMENT_FILTER_AFTER_POST_CHECKOUT'        => 'payment_filter_after_post_checkout',
            'PAYMENT_FILTER_PAYMENT_DATA'               => 'payment_filter_payment_data',
            'PAYMENT_ACTION_PAYMENT_PROCESSED'          => 'payment_action_payment_processed',
            'PAYMENT_METHOD_SETTINGS_CONTENT'           => 'payment_method_settings_content',
        ];

        foreach ($constants as $key => $value) {
            if (! defined($key)) {
                define($key, $value);
            }
        }
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/payment')
            ->loadAndPublishTranslations();

        // Load helper functions
        if (file_exists(platform_path('plugins/payment/helpers/payment.php'))) {
            require_once platform_path('plugins/payment/helpers/payment.php');
        }

        // Load payment toggle JS trong trang admin via Botble hook
        add_action(BASE_ACTION_ENQUEUE_SCRIPTS, function () {
            \Botble\Base\Facades\Assets::addScriptsDirectly('vendor/core/plugins/payment/js/payment.js');
        });
    }
}
