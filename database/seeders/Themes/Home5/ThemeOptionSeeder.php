<?php

namespace Database\Seeders\Themes\Home5;

class ThemeOptionSeeder extends \Database\Seeders\Themes\Main\ThemeOptionSeeder
{
    public function getThemeOptions(): array
    {
        return [
            ...parent::getThemeOptions(),
            'footer_background_image' => null,
            'footer_background_color' => '#374151',
            'display_header_top' => true,
            'header_top_background_color' => '#6d4df2',
            'header_top_text_color' => '#ffffff',
            'header_layout' => 'full-width',
        ];
    }
}
