<?php

namespace Database\Seeders\Themes\Main;

use Botble\Base\Supports\BaseSeeder;
use Botble\Menu\Database\Traits\HasMenuSeeder;
use Botble\Page\Database\Traits\HasPageSeeder;
use Botble\Page\Models\Page;

class MenuSeeder extends BaseSeeder
{
    use HasMenuSeeder;
    use HasPageSeeder;

    public function run(): void
    {
        $this->createMenus([
            [
                'name' => 'Main Menu',
                'location' => 'main-menu',
                'items' => [
                    [
                        'title' => 'Home',
                        'url' => '#',
                        'children' => [
                            [
                                'title' => 'Home v.1',
                                'url' => 'https://infinia.botble.com',
                                'target' => '_blank',
                            ],
                            [
                                'title' => 'Home v.2',
                                'url' => 'https://infinia-home-2.botble.com',
                                'target' => '_blank',
                            ],
                            [
                                'title' => 'Home v.3',
                                'url' => 'https://infinia-home-3.botble.com',
                                'target' => '_blank',
                            ],
                            [
                                'title' => 'Home v.4',
                                'url' => 'https://infinia-home-4.botble.com',
                                'target' => '_blank',
                            ],
                            [
                                'title' => 'Home v.5',
                                'url' => 'https://infinia-home-5.botble.com',
                                'target' => '_blank',
                            ],
                        ],
                    ],
                    [
                        'title' => 'About Us',
                        'url' => '#',
                        'children' => [
                            [
                                'title' => 'About Us v.1',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('About Us'),
                            ],
                            [
                                'title' => 'About Us v.2',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('About Us v2'),
                            ],
                            [
                                'title' => 'About Us v.3',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('About Us v3'),
                            ],
                        ],
                    ],
                    [
                        'title' => 'Pages',
                        'url' => '#',
                        'children' => [
                            [
                                'title' => 'Projects',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Projects'),
                            ],
                            [
                                'title' => 'Services v.1',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Services'),
                            ],
                            [
                                'title' => 'Services v.2',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Services v2'),
                            ],
                            [
                                'title' => 'Services v.3',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Services v3'),
                            ],
                            [
                                'title' => 'Services Detail v.1',
                                'url' => '/services/research-planning',
                            ],
                            [
                                'title' => 'Services Detail v.2',
                                'url' => '/services/research-planning?style=style-2',
                            ],
                            [
                                'title' => 'Pricing v.1',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Pricing'),
                            ],
                            [
                                'title' => 'Pricing v.2',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Pricing v2'),
                            ],
                            [
                                'title' => 'Pricing v.3',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Pricing v3'),
                            ],
                            [
                                'title' => 'Our Team v.1',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Our Team'),
                            ],
                            [
                                'title' => 'Our Team v.2',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Our Team v2'),
                            ],
                            [
                                'title' => 'Our Team v.3',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Our Team v3'),
                            ],
                            [
                                'title' => 'Our Team v.4',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Our Team v4'),
                            ],
                            [
                                'title' => 'Our Team v.5',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Our Team v5'),
                            ],
                            [
                                'title' => 'Our Team v.6',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Our Team v6'),
                            ],
                            [
                                'title' => 'Team Detail v.1',
                                'url' => '/teams/jennifer-brown',
                            ],
                            [
                                'title' => 'Team Detail v.2',
                                'url' => '/teams/jennifer-brown?style=style-2',
                            ],
                            [
                                'title' => 'Features v.1',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Features'),
                            ],
                            [
                                'title' => 'Features v.2',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Features v2'),
                            ],
                            [
                                'title' => 'Work Process',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Work Process'),
                            ],
                            [
                                'title' => 'Book a demo',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Book a demo'),
                            ],
                            [
                                'title' => 'Page Integration',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Page Integration'),
                            ],
                            [
                                'title' => 'Coming Soon',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Coming Soon'),
                            ],
                            [
                                'title' => 'Privacy Policy',
                                'reference_type' => Page::class,
                                'reference_id' => $this->getPageId('Privacy Policy'),
                            ],
                        ],
                    ],
                    [
                        'title' => 'Blog',
                        'url' => '#',
                        'children' => [
                            [
                                'title' => 'Blog v.1',
                                'url' => '/blog',
                            ],
                            [
                                'title' => 'Blog v.2',
                                'url' => '/blog?style=style-2',
                            ],
                            [
                                'title' => 'Blog Detail v.1',
                                'url' => '/adapting-to-the-new-web-development-trends-in-2024',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Contact',
                        'reference_type' => Page::class,
                        'reference_id' => $this->getPageId('Contact'),
                    ],
                ],
            ],
        ]);
    }
}
