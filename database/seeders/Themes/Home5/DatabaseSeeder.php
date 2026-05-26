<?php

namespace Database\Seeders\Themes\Home5;

class DatabaseSeeder extends \Database\Seeders\Themes\Main\DatabaseSeeder
{
    public function getSeeders(): array
    {
        return [
            ...parent::getSeeders(),
            PageSeeder::class,
            ThemeOptionSeeder::class,
            WidgetSeeder::class,
        ];
    }
}
