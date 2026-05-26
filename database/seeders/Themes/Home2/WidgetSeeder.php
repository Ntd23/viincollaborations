<?php

namespace Database\Seeders\Themes\Home2;

use SiteContactWidget;

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
}
