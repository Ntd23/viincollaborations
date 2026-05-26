<?php

namespace Database\Seeders\Themes\Main;

use BlogPostsWidget;
use Botble\Base\Supports\BaseSeeder;
use Botble\Page\Database\Traits\HasPageSeeder;
use Botble\Widget\Database\Traits\HasWidgetSeeder;
use Botble\Widget\Widgets\CoreSimpleMenu;
use BrochureDownloadsWidget;
use CallToActionWidget;
use ContactFormWidget;
use CustomerSupportWidget;
use FeaturesWidget;
use HeaderControlsWidget;
use Illuminate\Support\Str;
use MainMenuWidget;
use NewsletterWidget;
use ServicesWidget;
use SiteContactWidget;
use SiteCopyrightWidget;
use SiteInformationWidget;
use SiteLogoWidget;

class WidgetSeeder extends BaseSeeder
{
    use HasWidgetSeeder;
    use HasPageSeeder;

    public function run(): void
    {
        $this->uploadFiles('docs');

        $this->createWidgets([
            ...$this->getProjectSidebarData(),
            ...$this->getServiceSidebarData(),
            ...$this->getHeaderSidebarData(),
            ...$this->getFooterTopSidebarData(),
            ...$this->getFooterPrimarySidebarData(),
            ...$this->getFooterBottomSidebarData(),
            ...$this->getHeaderTopStartSidebar(),
            ...$this->getHeaderTopEndSidebar(),
            ...$this->getBlogTopSidebarData(),
            ...$this->getTeamSidebarData(),
        ]);
    }

    public function getHeaderSidebarData(): array
    {
        return [
            [
                'widget_id' => SiteLogoWidget::class,
                'sidebar_id' => 'header_sidebar',
                'position' => 1,
                'data' => [],
            ],
            [
                'widget_id' => MainMenuWidget::class,
                'sidebar_id' => 'header_sidebar',
                'position' => 2,
                'data' => [],
            ],
            [
                'widget_id' => HeaderControlsWidget::class,
                'sidebar_id' => 'header_sidebar',
                'position' => 3,
                'data' => [
                    'show_search_button' => true,
                    'show_theme_switcher' => true,
                    'action_label' => 'Join For Free Trial',
                    'action_url' => '/contact',
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
                    'title' => 'Subscribe to our Newsletter!',
                    'subtitle' => 'Stay updated',
                    'description' => 'Join 52,000+ people on our newsletter',
                    'background_image' => $this->filePath('backgrounds/newsletter.png'),
                    'left_image' => $this->filePath('backgrounds/newsletter-left.png'),
                ],
            ],
        ];
    }

    public function getFooterBottomSidebarData(): array
    {
        return [
            [
                'widget_id' => SiteCopyrightWidget::class,
                'sidebar_id' => 'footer_bottom_sidebar',
                'position' => 1,
                'data' => [],
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
                    'logo' => $this->filePath('general/logo-white.png'),
                    'logo_dark' => $this->filePath('general/logo-white.png'),
                ],
            ],
            [
                'widget_id' => CoreSimpleMenu::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 2,
                'data' => [
                    'name' => 'Company',
                    'items' => collect(['About us', 'Our Team', 'Contact', 'Pricing', 'Privacy Policy', 'Features'])
                        ->map(fn ($item) => [
                            ['key' => 'label', 'value' => $item],
                            ['key' => 'url', 'value' => '/' . Str::slug($item)],
                        ])
                        ->all(),
                ],
            ],
            [
                'widget_id' => CoreSimpleMenu::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 3,
                'data' => [
                    'name' => 'Pages',
                    'items' => collect(['Projects', 'Services', 'Blog', 'Contact', '404', 'Features v2'])
                        ->map(fn ($item) => [
                            ['key' => 'label', 'value' => $item],
                            ['key' => 'url', 'value' => '/' . Str::slug($item)],
                        ])
                        ->all(),
                ],
            ],
            [
                'widget_id' => CoreSimpleMenu::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 4,
                'data' => [
                    'name' => 'Teams',
                    'items' => collect(['Our Team', 'Our Team v2', 'Our Team v3', 'Our Team v4', 'Our Team v5', 'Our Team v6'])
                        ->map(fn ($item) => [
                            ['key' => 'label', 'value' => $item],
                            ['key' => 'url', 'value' => '/' . Str::slug($item)],
                        ])
                        ->all(),
                ],
            ],
            [
                'widget_id' => CoreSimpleMenu::class,
                'sidebar_id' => 'footer_primary_sidebar',
                'position' => 5,
                'data' => [
                    'name' => 'Services',
                    'items' => collect(['Services', 'Services v2', 'Services v3', 'About us', 'About us v2', 'About us v3'])
                        ->map(fn ($item) => [
                            ['key' => 'label', 'value' => $item],
                            ['key' => 'url', 'value' => '/' . Str::slug($item)],
                        ])
                        ->all(),
                ],
            ],
        ];
    }

    public function getServiceSidebarData(): array
    {
        return [
            [
                'widget_id' => ServicesWidget::class,
                'sidebar_id' => 'service_sidebar',
                'position' => 1,
                'data' => [
                    'service_ids' => [1, 2, 3, 4, 5],
                ],
            ],
            [
                'widget_id' => BrochureDownloadsWidget::class,
                'sidebar_id' => 'service_sidebar',
                'position' => 2,
                'data' => [
                    'title' => 'Service Brochure',
                    'items' => [
                        [
                            [
                                'key' => 'label',
                                'value' => 'PDF. Download (25 Mb)',
                            ],
                            [
                                'key' => 'url',
                                'value' => '/storage/docs/sample.pdf',
                            ],
                            [
                                'key' => 'icon',
                                'value' => 'ti ti-file-type-pdf',
                            ],
                        ],
                        [
                            [
                                'key' => 'label',
                                'value' => 'ZIP. Download (15 Mb)',
                            ],
                            [
                                'key' => 'url',
                                'value' => '/storage/docs/sample.pdf',
                            ],
                            [
                                'key' => 'icon',
                                'value' => 'ti ti-file-type-pdf',
                            ],
                        ],
                        [
                            [
                                'key' => 'label',
                                'value' => 'Open on Google Driver',
                            ],
                            [
                                'key' => 'url',
                                'value' => 'https://drive.google.com/',
                            ],
                            [
                                'key' => 'icon',
                                'value' => 'ti ti-brand-google-drive',
                            ],
                        ],
                        [
                            [
                                'key' => 'label',
                                'value' => 'Open on Dropbox',
                            ],
                            [
                                'key' => 'url',
                                'value' => 'https://www.dropbox.com/',
                            ],
                            [
                                'key' => 'icon',
                                'value' => 'ti ti-file-zip',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'widget_id' => CustomerSupportWidget::class,
                'sidebar_id' => 'service_sidebar',
                'position' => 3,
                'data' => [
                    'title' => 'Providing the Ultimate Experience in Financial Services',
                    'contact_title' => 'Contact Us',
                    'contact_number' => '+01 (24) 568 900',
                    'contact_url' => 'tel:0124568900',
                    'button_label' => 'Get 15 Days Free Trial',
                    'icon_image' => $this->filePath('shapes/icon-contact.png'),
                    'button_url' => '/contact',
                ],
            ],
            [
                'widget_id' => ContactFormWidget::class,
                'sidebar_id' => 'service_sidebar',
                'position' => 4,
                'data' => [
                    'title' => 'Get A Quote',
                    'button_label' => 'Send Message',
                ],
            ],
        ];
    }

    public function getProjectSidebarData(): array
    {
        return [
            [
                'widget_id' => CustomerSupportWidget::class,
                'sidebar_id' => 'project_sidebar',
                'position' => 1,
                'data' => [
                    'title' => 'Providing the Ultimate Experience in Financial Services',
                    'contact_title' => 'Contact Us',
                    'contact_number' => '+01 (24) 568 900',
                    'contact_url' => 'tel:0124568900',
                    'button_label' => 'Get 15 Days Free Trial',
                    'icon_image' => $this->filePath('shapes/icon-contact.png'),
                    'button_url' => '/contact',
                ],
            ],
        ];
    }

    public function getTeamSidebarData(): array
    {
        return [
            [
                'widget_id' => FeaturesWidget::class,
                'sidebar_id' => 'team_sidebar',
                'position' => 1,
                'data' => [
                    'title' => 'Skills & Experience',
                    'items' => [
                        [
                            [
                                'key' => 'title',
                                'value' => 'Market Analysis and Insights',
                            ],
                            [
                                'key' => 'description',
                                'value' => 'Gain a deep understanding of your industry and competitors with our comprehensive market analysis.',
                            ],
                            [
                                'key' => 'icon',
                                'value' => null,
                            ],
                            [
                                'key' => 'icon_image',
                                'value' => $this->filePath('icons/icon-1.png'),
                            ]
                        ],
                        [
                            [
                                'key' => 'title',
                                'value' => 'Business Model Innovation',
                            ],
                            [
                                'key' => 'description',
                                'value' => 'We assist in redefining your business modelto align with current market trends andfuture demands.',
                            ],
                            [
                                'key' => 'icon',
                                'value' => null,
                            ],
                            [
                                'key' => 'icon_image',
                                'value' => $this->filePath('icons/icon-12.png'),
                            ]
                        ],
                        [
                            [
                                'key' => 'title',
                                'value' => 'Change Management',
                            ],
                            [
                                'key' => 'description',
                                'value' => 'Successfully manage organizational change withour expert guidance. We help you navigatetransitions smoothly.',
                            ],
                            [
                                'key' => 'icon',
                                'value' => null,
                            ],
                            [
                                'key' => 'icon_image',
                                'value' => $this->filePath('icons/icon-13.png'),
                            ]
                        ],
                        [
                            [
                                'key' => 'title',
                                'value' => 'Marketing Support',
                            ],
                            [
                                'key' => 'description',
                                'value' => 'Successfully manage organizational change withour expert guidance. We help you navigatetransitions smoothly.',
                            ],
                            [
                                'key' => 'icon',
                                'value' => null,
                            ],
                            [
                                'key' => 'icon_image',
                                'value' => $this->filePath('icons/icon-14.png'),
                            ]
                        ],
                        [
                            [
                                'key' => 'title',
                                'value' => 'HR Consultant',
                            ],
                            [
                                'key' => 'description',
                                'value' => 'Successfully manage organizational change withour expert guidance. We help you navigatetransitions smoothly.',
                            ],
                            [
                                'key' => 'icon',
                                'value' => null,
                            ],
                            [
                                'key' => 'icon_image',
                                'value' => $this->filePath('icons/icon-15.png'),
                            ]
                        ],
                    ],
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

    public function getBlogTopSidebarData(): array
    {
        return [
            [
                'widget_id' => BlogPostsWidget::class,
                'sidebar_id' => 'blog_top_sidebar',
                'position' => 1,
                'data' => [
                    'style' => 1,
                    'title' => 'Our Latest Articles',
                    'subtitle' => 'FROM BLOG',
                    'description' => 'Explore the insights and trends shaping our industry.',
                ],
            ],
            [
                'widget_id' => CallToActionWidget::class,
                'sidebar_id' => 'blog_top_sidebar',
                'position' => 2,
                'data' => [
                    'title' => 'We are <b>Looking to</b> <br> <b>Expand</b> Our Team',
                    'image' => $this->filePath('general/call-to-action-1.png'),
                    'button_label' => 'Explore Now',
                    'button_url' => '/contact',
                    'button_icon' => 'ti ti-arrow-up-right',
                ],
            ],
        ];
    }
}
