<?php

namespace Database\Seeders\Themes\Home3;

class ThemeOptionSeeder extends \Database\Seeders\Themes\Main\ThemeOptionSeeder
{
    public function getThemeOptions(): array
    {
        return [
            ...parent::getThemeOptions(),
            'header_layout' => 'container',
            'display_header_top' => true,
            'footer_background_color' => '#ffffff',
            'footer_heading_color' => '#000000',
            'footer_text_color' => '#000000',
            'footer_border_color' => '#ffffff',
            'footer_background_image' => null,
        ];
    }
}
