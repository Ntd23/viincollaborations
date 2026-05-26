<?php

namespace Database\Seeders\Themes\Main;

use Botble\Base\Supports\BaseSeeder;
use Botble\Testimonial\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends BaseSeeder
{
    public function run(): void
    {
        Testimonial::query()->truncate();
        DB::table('testimonials_translations')->truncate();

        $this->uploadFiles('testimonials');

        $testimonials = [
            [
                'name' => 'James Dopli',
                'company' => 'CEO of Tech Innovators Inc',
                'content' => "The team's dedication and expertise have transformed our business. Their innovative solutions and outstanding support have significantly boosted our productivity and client satisfaction. Allowing us to streamline our processes and focus on what matters most.",
            ],
            [
                'name' => 'Theodore Handle',
                'company' => 'Software Engineer',
                'content' => 'Our collaboration with the team has been instrumental in optimizing our project management processes. The extensive selection of over 1200 UI blocks has allowed us to customize our project interfaces to meet specific client needs effectively. The generous 10 GB of cloud storage has provided ample space for storing project files securely, enabling seamless collaboration across distributed teams.',
            ],
            [
                'name' => 'Shahnewaz Sakil',
                'company' => 'Marketing Director',
                'content' => "The individual email account feature has improved internal communication clarity and professionalism. Moreover, the premium support team's responsiveness and expertise have ensured minimal disruptions and quick resolutions to any technical challenges we've faced. I highly recommend their services for any enterprise seeking robust SaaS solutions.",
            ],
            [
                'name' => 'Albert Flores',
                'company' => 'Software Engineer',
                'content' => "Our experience with this team has surpassed our expectations on every front. The comprehensive suite of over 1200 UI blocks has enabled us to craft highly functional and aesthetically pleasing user interfaces that resonate with our target audience. Equally impressive is the premium support team's proactive approach.",
            ],
            [
                'name' => 'James Dopli',
                'company' => 'CEO of Tech Innovators Inc',
                'content' => "The team's dedication and expertise have transformed our business. Their innovative solutions and outstanding support have significantly boosted our productivity and client satisfaction. Allowing us to streamline our processes and focus on what matters most.",
            ],
            [
                'name' => 'Theodore Handle',
                'company' => 'Software Engineer',
                'content' => 'Our collaboration with the team has been instrumental in optimizing our project management processes. The extensive selection of over 1200 UI blocks has allowed us to customize our project interfaces to meet specific client needs effectively. The generous 10 GB of cloud storage has provided ample space for storing project files securely, enabling seamless collaboration across distributed teams.',
            ],
        ];

        $faker = $this->fake();

        foreach (range(1, 10) as $ignored) {
            $testimonials[] = [
                'name' => $faker->name,
                'company' => $faker->company,
                'content' => $faker->paragraph,
            ];
        }

        foreach ($testimonials as $item) {
            Testimonial::query()->create([
                ...$item,
                'image' => $this->filePath(sprintf('testimonials/avatar-%d.png', rand(1, 20))),
            ]);
        }
    }
}
