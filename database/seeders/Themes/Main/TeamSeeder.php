<?php

namespace Database\Seeders\Themes\Main;

use Botble\Base\Supports\BaseSeeder;
use Botble\Team\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TeamSeeder extends BaseSeeder
{
    public function run(): void
    {
        Team::query()->truncate();
        DB::table('teams_translations')->truncate();

        $this->uploadFiles('teams');

        $teams = [
            [
                'name' => 'Michael Anderson',
                'title' => 'Co-Founder',
            ],
            [
                'name' => 'Jennifer Brown',
                'title' => 'CEO & Founder',
            ],
            [
                'name' => 'Sarah Brown',
                'title' => 'Product Manager',
            ],
            [
                'name' => 'David Clark',
                'title' => 'UX/UI Designer',
            ],
            [
                'name' => 'Jessica Carter',
                'title' => 'DevOps Engineer',
            ],
            [
                'name' => 'Lauren Graham',
                'title' => 'Data Analyst',
            ],
            [
                'name' => 'James Bennett',
                'title' => 'Sales Executive',
            ],
            [
                'name' => 'William Foster',
                'title' => 'Marketing Specialist',
            ],
        ];

        $faker = $this->fake();
        $content = File::get(database_path('seeders/contents/team.html'));

        foreach ($teams as $index => $team) {
            $index++;

            Team::query()->create([
                ...$team,
                'photo' => $this->filePath("teams/$index.png"),
                'description' => $faker->paragraph(4),
                'email' => $faker->email(),
                'phone' => $faker->e164PhoneNumber(),
                'address' => $faker->address(),
                'content' => $content,
                'socials' => [
                    'facebook' => 'https://facebook.com',
                    'twitter' => 'https://twitter.com',
                    'instagram' => 'https://instagram.com',
                ],
            ]);
        }
    }
}
