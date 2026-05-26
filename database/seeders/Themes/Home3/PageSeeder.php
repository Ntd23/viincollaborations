<?php

namespace Database\Seeders\Themes\Home3;

use Botble\Page\Models\Page;

class PageSeeder extends \Database\Seeders\Themes\Main\PageSeeder
{
    public function run(): void
    {
        parent::run();

        $homepage = Page::query()->where('name', 'Homepage')->firstOrFail();

        $homepage->update([
            'content' => $this->generateShortcodeContent([
                [
                    'name' => 'hero-banner',
                    'attributes' => [
                        'style' => '3',
                        'title' => 'Elevate your <br> brand with Infinia.',
                        'subtitle' => '🚀 Free Lifetime Update',
                        'description' => 'Access top-tier group mentoring plans and exclusive professional benefits for your team.',
                        'background_image' => $this->filePath('backgrounds/team.png'),
                        'primary_action_label' => 'Get Started',
                        'primary_action_url' => '/contact',
                        'primary_action_icon' => 'ti ti-arrow-up-right',
                        'main_image_1' => $this->filePath('general/hero-banner-3-1.png'),
                        'main_image_2' => $this->filePath('general/hero-banner-3-2.png'),
                        'main_image_3' => $this->filePath('general/hero-banner-3-3.png'),
                        'main_image_4' => $this->filePath('general/hero-banner-3-4.png'),
                        'bottom_title' => 'Trusted by the best',
                        'quantity' => '3',
                        'name_1' => 'Netflix',
                        'url_1' => 'https://www.netflix.com/',
                        'image_1' => $this->filePath('partners/1.png'),
                        'name_2' => 'slack',
                        'url_2' => 'https://slack.com/',
                        'image_2' => $this->filePath('partners/2.png'),
                        'name_3' => 'Slack',
                        'url_3' => 'https://slack.com/',
                        'image_3' => $this->filePath('partners/3.png'),
                        'floating_image' => $this->filePath('partners/star-rotate.png'),
                    ],
                ],
                [
                    'name' => 'partners',
                    'attributes' => [
                        'style' => 3,
                        'title' => 'Trusted by great companies',
                        'quantity' => 20,
                        ...collect(['Framer', 'Reddit', 'Netflix', 'Microsoft', 'Discover', 'Lemon Squeezy', 'Paypal', 'Youtube', 'Spotify', 'Google', 'Amazon', 'Apple', 'Facebook', 'Twitter', 'Instagram', 'Slack', 'Tiktok', 'Pinterest', 'Medium', 'Linkedin'])
                            ->mapWithKeys(function ($name, $index) {
                                $index++;

                                $imageName = $index > 8 ? rand(1, 8) : $index;

                                return [
                                    "name_$index" => $name,
                                    "image_$index" => $this->filePath("partners/$imageName.png"),
                                    "url_$index" => 'https://google.com',
                                    "open_in_new_tab_$index" => true,
                                ];
                            })
                            ->all(),
                    ],
                ],
                [
                    'name' => 'services',
                    'attributes' => [
                        'style' => '5',
                        'title' => 'Let\'s Discover Our Service <b>Our Service</b> <br> <b>Features </b> Charter',
                        'subtitle' => 'WHAT WE OFFERS',
                        'service_ids' => '1,2,3,4,5,6',
                        'primary_action_label' => 'Explore Now',
                        'primary_action_icon' => 'ti ti-arrow-up-right',
                        'primary_action_url' => '/contact',
                        'secondary_action_label' => 'Contact Us',
                        'secondary_action_url' => '/contact',
                        'secondary_action_icon' => 'ti ti-phone-call',
                    ],
                ],
                [
                    'name' => 'our-history',
                    'attributes' => [
                        'style' => '2',
                        'title' => 'We provide <b>solutions</b> to <br> <b>big & small</b> organizations',
                        'subtitle' => 'Why We Are The Best',
                        'content_title' => 'Where your financial <br> dreams become reality',
                        'content_description' => 'Provide your team with top-tier group mentoring programs and exceptional professional benefits.',
                        'image' => $this->filePath('general/our-history-2.png'),
                        'quantity' => '4',
                        'title_1' => 'Best For IT Consulting',
                        'title_2' => 'Save Money & Time',
                        'title_3' => 'Innovative Approaches',
                        'title_4' => '100% Satisfaction',
                        'author_name' => 'Kensei',
                        'author_title' => 'CEO',
                        'author_signature' => 'general/author-signature.png',
                        'author_avatar' => 'general/author-avatar.png',
                        'data_count_title' => 'Years\' <br> Experience',
                        'data_count' => '12',
                        'data_count_unit' => '+',
                        'default_action_label' => 'Video Guide',
                        'default_action_url' => 'https://www.youtube.com/watch?v=tRxGSHL8bI0',
                        'default_action_icon' => 'ti ti-player-play',
                    ],
                ],
                [
                    'name' => 'site-statistics',
                    'attributes' => [
                        'style' => '3',
                        'quantity' => '4',
                        'second_tab_title_1' => 'Continuous <br> growth with',
                        'second_tab_description_1' => 'New accounts',
                        'second_tab_data_1' => '24',
                        'second_tab_unit_1' => 'k',
                        'second_tab_title_2' => 'Successfully <br> completed',
                        'second_tab_description_2' => 'Finished projects',
                        'second_tab_data_2' => '1024',
                        'second_tab_title_3' => 'Recruit more <br> than',
                        'second_tab_description_3' => 'Skilled experts',
                        'second_tab_data_3' => '865',
                        'second_tab_title_4' => 'Increase internet <br> awareness',
                        'second_tab_description_4' => 'Media posts',
                        'second_tab_data_4' => '168',
                        'second_tab_unit_4' => 'k',
                    ],
                ],
                [
                    'name' => 'contact-block',
                    'attributes' => [
                        'title' => 'Providing the <br> Ultimate Experience <br> in Financial Services',
                        'contact_icon' => 'icons/contact.png',
                        'contact_title' => 'Contact Us',
                        'contact_label' => '+01 (24) 568 900',
                        'contact_url' => 'tel:0124568 900',
                        'primary_action_label' => 'Get 15 Days Free Trial',
                        'primary_action_url' => '/contact',
                        'primary_action_icon' => 'ti ti-arrow-narrow-right',
                        'background_image' => $this->filePath('general/contact-block.png'),
                    ],
                ],
                [
                    'name' => 'projects',
                    'attributes' => [
                        'style' => '3',
                        'title' => 'Proud projects <b>that make</b> <br> <b>us stand</b> out',
                        'subtitle' => 'Why We Are The Best',
                        'description' => 'Nunc bibendum augue sed mattis porta. Donec pharetra magna tortor, quis bibendum ligula faucibus vitae,',
                        'data_count' => '50',
                        'data_count_unit' => 'k',
                        'project_ids' => '1,2,3',
                        'quantity' => '4',
                        'title_1' => 'Offshore Software Development',
                        'description_1' => 'Getting started is simple! Download the app from the App Store or Google Play Store, create an account using your email or social media login, and start making video calls instantly.',
                        'title_2' => 'Custom Software Development',
                        'description_2' => 'Getting started is simple! Download the app from the App Store or Google Play Store, create an account using your email or social media login, and start making video calls instantly.',
                        'title_3' => 'Software Outsourcing Services',
                        'description_3' => 'Getting started is simple! Download the app from the App Store or Google Play Store, create an account using your email or social media login, and start making video calls instantly.',
                        'title_4' => 'Software Product Development',
                        'description_4' => 'Getting started is simple! Download the app from the App Store or Google Play Store, create an account using your email or social media login, and start making video calls instantly.',
                    ],
                ],
                [
                    'name' => 'blog-posts',
                    'attributes' => [
                        'style' => '2',
                        'title' => 'Reach out to <br> the world\'s most',
                        'subtitle' => 'Why us ?',
                        'description' => '⚡Here are a few reasons why our customers choose Infinia.',
                        'paginate' => '4',
                    ],
                ],
                [
                    'name' => 'pricing-plans',
                    'attributes' => [
                        'style' => '3',
                        'title' => '<b>Straightforward</b>  Pricing <br> Custom <b>Integrations</b>',
                        'subtitle' => 'Our Pricing',
                        'description' => 'Meet the talented and passionate team members who drive our company forward every day.',
                        'quantity' => '6',
                        'package_ids' => '1,2,3',
                        'background_images' => $this->filePath('backgrounds/bg-line-bottom.png'),
                        'primary_action_label' => 'Get Free Quote',
                        'primary_action_url' => '/contact',
                        'primary_action_icon' => 'ti ti-arrow-narrow-right',
                        'secondary_action_label' => 'How We Work',
                        'secondary_action_url' => '/contact',
                    ],
                ],
                [
                    'name' => 'faqs',
                    'attributes' => [
                        'style' => '3',
                        'title' => 'Ask us anything',
                        'subtitle' => 'Pricing FAQs',
                        'description' => 'Have any questions? We\'re here to assist you.',
                        'quantity' => '6',
                        'category_ids' => '1,2,3',
                        'limit' => '10',
                    ],
                ],
                [
                    'name' => 'blog-posts',
                    'attributes' => [
                        'style' => '4',
                        'title' => 'Our Latest Articles',
                        'subtitle' => 'FROM BLOG',
                        'description' => 'Explore the insights and trends shaping our industry',
                        'paginate' => '4',
                        'action_label' => 'See all articles',
                        'action_url' => '/blog',
                        'background_image' => $this->filePath('backgrounds/team.png'),
                    ],
                ],
            ]),
        ]);
    }
}
