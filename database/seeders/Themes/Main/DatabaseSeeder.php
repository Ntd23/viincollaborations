<?php

namespace Database\Seeders\Themes\Main;

use Botble\ACL\Database\Seeders\UserSeeder;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Database\Seeders\LanguageSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        $this->call($this->getSeeders());

        $this->finished();
    }

    public function getSeeders(): array
    {
        return [
            LanguageSeeder::class,
            UserSeeder::class,
            PortfolioSeeder::class,
            FaqSeeder::class,
            TeamSeeder::class,
            TestimonialSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
            ThemeOptionSeeder::class,
            WidgetSeeder::class,
            MenuSeeder::class,
            SimpleSliderSeeder::class,
            GallerySeeder::class,
            CareerSeeder::class,
        ];
    }
}
