<?php

namespace Database\Seeders\Themes\Home5;

use AppDownloadsWidget;
use Botble\Widget\Widgets\CoreSimpleMenu;
use SiteContactWidget;
use SiteInformationWidget;

class WidgetSeeder extends \Database\Seeders\Themes\Main\WidgetSeeder
{
    public function getFooterTopSidebarData(): array
    {
        return [
            [
                'widget_id' => SiteContactWidget::class,
                'sidebar_id' => 'footer_top_sidebar',
                'position' => 1,
                'data' => [
                    'quantity' => '2',
                    'action_icon_2' => 'ti ti-phone',
                    'items' => [
                        [
                            [
                                'key' => 'action_label',
                                'value' => ' 0811 Erdman Prairie, Joaville CA',
                            ],
                            [
                                'key' => 'action_url',
                                'value' => 'https://www.google.com/maps/search/0811%20Erdman%20Prairie,%20Joaville%20CA',
                            ],
                            [
                                'key' => 'action_icon',
                                'value' => 'ti ti-map-2',
                            ],
                        ],
                        [
                            [
                                'key' => 'action_label',
                                'value' => '+01 (24) 568 900',
                            ],
                            [
                                'key' => 'action_url',
                                'value' => 'tel:01234345456',
                            ],
                            [
                                'key' => 'action_icon',
                                'value' => 'ti ti-phone',
                            ],
                        ],
                    ],
                    'description' => 'Our website uses cookies to improve your experience.',
                    'action_label' => 'Check cookies policy',
                    'action_url' => '/contact',
                ],
            ],
        ];
    }

    public function getHeaderTopStartSidebar(): array
    {
        return [
            [
                'widget_id' => SiteContactWidget::class,
                'sidebar_id' => 'header_top_start_sidebar',
                'position' => 1,
                'data' => [
                    'style' => 2,
                    'items' => [
                        [
                            [
                                'key' => 'action_label',
                                'value' => 'contact@infinia.com',
                            ],
                            [
                                'key' => 'action_url',
                                'value' => 'mailto:contact@infinia.com',
                            ],
                            [
                                'key' => 'action_icon',
                                'value' => 'ti ti-mail',
                            ],
                        ],
                        [
                            [
                                'key' => 'action_label',
                                'value' => '0811 Erdman Prairie, Joaville CA',
                            ],
                            [
                                'key' => 'action_url',
                                'value' => 'https://www.google.com/maps/search/0811%20Erdman%20Prairie,%20Joaville%20CA',
                            ],
                            [
                                'key' => 'action_icon',
                                'value' => 'ti ti-map-pin',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getHeaderTopEndSidebar(): array
    {
        return [
            [
                'widget_id' => SiteContactWidget::class,
                'sidebar_id' => 'header_top_end_sidebar',
                'position' => 1,
                'data' => [
                    'style' => 2,
                    'items' => [
                        [
                            [
                                'key' => 'action_label',
                                'value' => 'Mon-Fri: 10:00am - 09:00pm',
                            ],
                            [
                                'key' => 'action_url',
                                'value' => '',
                            ],
                            [
                                'key' => 'action_icon',
                                'value' => 'ti ti-clock-hour-12',
                            ],
                        ],
                    ],
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
