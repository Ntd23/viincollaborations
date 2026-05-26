<?php

namespace Database\Seeders\Themes\Home2;

class ThemeOptionSeeder extends \Database\Seeders\Themes\Main\ThemeOptionSeeder
{
    public function getThemeOptions(): array
    {
        return [
            ...parent::getThemeOptions(),
            'header_layout' => 'full-width',
        ];
    }
}
