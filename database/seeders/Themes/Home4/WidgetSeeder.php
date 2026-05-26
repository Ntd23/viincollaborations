<?php

namespace Database\Seeders\Themes\Home4;

use AppDownloadsWidget;
use Botble\Widget\Widgets\CoreSimpleMenu;
use NewsletterWidget;
use SiteInformationWidget;

class WidgetSeeder extends \Database\Seeders\Themes\Main\WidgetSeeder
{
    public function getFooterTopSidebarData(): array
    {
        return [
            [
                'widget_id' => NewsletterWidget::class,
                'sidebar_id' => 'footer_top_sidebar',
                'position' => 1,
                'data' => [
                    'style' => 3,
                    'title' => 'Subscribe to our Newsletter!',
                    'subtitle' => 'Stay updated',
                    'description' => 'Join 52,000+ people on our newsletter',
                ],
            ],
        ];
    }

    public function getFooterPrimarySidebarData(): array
    {
        return [
            [
                'widget_id' => SiteInformationWidget::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 1,
                'data' => [
                    'show_logo' => true,
                    'about' => 'You may also realize cost savings from your energy efficient choices in your custom home. Federal tax credits for some green materials can allow you to deduct as much.',
                    'show_social_links' => true,
                ],
            ],
            [
                'widget_id' => CoreSimpleMenu::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 2,
                'data' => [
                    'name' => 'Company',
                    'items' => collect(['Mission & Vision', 'Our Team', 'Careers', 'Press & Media', 'Advertising', 'Testimonials'])
                        ->map(fn ($item) => [
                            ['key' => 'label', 'value' => $item],
                            ['key' => 'url', 'value' => '/example'],
                        ])
                        ->all(),
                ],
            ],
            [
                'widget_id' => CoreSimpleMenu::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 3,
                'data' => [
                    'name' => 'Guides',
                    'items' => collect(['Our Journeys', 'Solutions', 'Customers', 'News & Events', 'Project management', 'Help Center'])
                        ->map(fn ($item) => [
                            ['key' => 'label', 'value' => $item],
                            ['key' => 'url', 'value' => '/example'],
                        ])
                        ->all(),
                ],
            ],
            [
                'widget_id' => AppDownloadsWidget::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 4,
                'data' => [
                    'title' => 'App & Payment',
                    'description' => 'Download our Apps and get extra 15% discount on your first order…!',
                    'platforms' => [
                        [
                            [
                                'key' => 'name',
                                'value' => 'App Store',
                            ],
                            [
                                'key' => 'image',
                                'value' => $this->filePath('general/app-payment-1.png'),
                            ],
                            [
                                'key' => 'url',
                                'value' => 'https://www.apple.com/',
                            ],
                        ],
                        [
                            [
                                'key' => 'name',
                                'value' => 'Google Play',
                            ],
                            [
                                'key' => 'image',
                                'value' => $this->filePath('general/app-payment-2.png'),
                            ],
                            [
                                'key' => 'url',
                                'value' => 'https://play.google.com/',
                            ],
                        ],
                        [
                            [
                                'key' => 'name',
                                'value' => 'Microsoft',
                            ],
                            [
                                'key' => 'image',
                                'value' => $this->filePath('general/app-payment-3.png'),
                            ],
                            [
                                'key' => 'url',
                                'value' => 'https://www.microsoft.com/',
                            ],
                        ],
                        [
                            [
                                'key' => 'name',
                                'value' => 'Amazon',
                            ],
                            [
                                'key' => 'image',
                                'value' => $this->filePath('general/app-payment-4.png'),
                            ],
                            [
                                'key' => 'url',
                                'value' => 'https://www.amazon.com/',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
