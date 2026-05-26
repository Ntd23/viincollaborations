<?php

namespace Database\Seeders\Themes\Main;

use Botble\Base\Supports\BaseSeeder;
use Botble\Page\Database\Traits\HasPageSeeder;
use Botble\Theme\Database\Traits\HasThemeOptionSeeder;
use Botble\Theme\Supports\ThemeSupport;

class ThemeOptionSeeder extends BaseSeeder
{
    use HasThemeOptionSeeder;
    use HasPageSeeder;

    public function run(): void
    {
        $settings = [
            'admin_favicon' => $this->filePath('general/favicon.png'),
            'admin_logo' => $this->filePath('general/logo-white.png'),
        ];

        $this->saveSettings($settings);

        $this->createThemeOptions($this->getThemeOptions());
    }

    public function getThemeOptions(): array
    {
        return [
            'favicon' => $this->filePath('general/favicon.png'),
            'logo' => $this->filePath('general/logo-dark.png'),
            'logo_dark' => $this->filePath('general/logo-white.png'),
            'site_title' => 'Multipurpose Business & Startup Theme',
            'seo_description' => 'Infinia is a versatile Botble CMS theme tailored for technology sectors, including B2B, IT, consulting, and digital marketing. Built on Bootstrap 5, it offers professional, responsive designs to suit diverse business needs.',
            'copyright' => 'Copyright © %Y Infinia. All Rights Reserved',
            '404_image' => $this->filePath('general/404.png'),
            'breadcrumb_background_image' => $this->filePath('backgrounds/breadcrumb.png'),
            'social_links' => ThemeSupport::getDefaultSocialLinksData(),
            'primary_color' => '#6d4df2',
            'tp_primary_font' => 'Satoshi-Variable',
            'homepage_id' => $this->getPageId('Homepage'),
            'blog_page_id' => $this->getPageId('Blog'),
            'default_theme_mode' => 'light',
            'newsletter_popup_enable' => true,
            'newsletter_popup_image' => $this->filePath('general/features-6.png'),
            'newsletter_popup_title' => 'Stay Updated with Infinia',
            'newsletter_popup_subtitle' => 'Newsletter',
            'newsletter_popup_description' => "Join our newsletter and discover how Infinia's multipurpose business startup solution can transform your digital presence with modern, responsive design and powerful features.",
            'footer_background_image' => $this->filePath('general/line-bg.png'),
            'suggest_keywords' => 'Startup, Agency, Creative, Consulting, IT services, Pricing',
            'footer_text_color' => '#ffffff',
            'footer_background_color' => '#111827',
            'footer_heading_color' => '#ffffff',
            'footer_border_color' => '#303234',
        ];
    }
}
