<?php

namespace Database\Seeders\Themes\Home4;

class ThemeOptionSeeder extends \Database\Seeders\Themes\Main\ThemeOptionSeeder
{
    public function getThemeOptions(): array
    {
        return [
            ...parent::getThemeOptions(),
            'footer_background_image' => null,
        ];
    }
}
