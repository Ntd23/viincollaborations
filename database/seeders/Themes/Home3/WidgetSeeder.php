<?php

namespace Database\Seeders\Themes\Home3;

use Botble\Widget\Widgets\CoreSimpleMenu;
use NewsletterWidget;
use SiteContactWidget;
use SiteInformationWidget;

class WidgetSeeder extends \Database\Seeders\Themes\Main\WidgetSeeder
{
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
                    ],
                ],
            ],
        ];
    }

    public function getFooterTopSidebarData(): array
    {
        return [
            [
                'widget_id' => NewsletterWidget::class,
                'sidebar_id' => 'footer_top_sidebar',
                'position' => 1,
                'data' => [
                    'style' => 2,
                    'title' => 'Subscribe to our Newsletter!',
                    'subtitle' => 'Stay updated',
                    'description' => 'Join 52,000+ people on our newsletter',
                    'background_image' => $this->filePath('general/newsletter-bg.png'),
                    'background_color' => '#6d4df2',
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
                    'logo' => $this->filePath('general/logo-dark.png'),
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
                'widget_id' => 'GalleriesWidget',
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 3,
                'data' => [
                    'id' => 'GalleriesWidget',
                    'title' => 'Instagram Posts',
                    'limit' => 6,
                ],
            ],
        ];
    }
}
