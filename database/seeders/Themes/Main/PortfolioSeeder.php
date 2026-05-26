<?php

namespace Database\Seeders\Themes\Main;

use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Portfolio\Enums\PackageDuration;
use Botble\Portfolio\Models\Package;
use Botble\Portfolio\Models\Project;
use Botble\Portfolio\Models\Service;
use Botble\Portfolio\Models\ServiceCategory;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PortfolioSeeder extends BaseSeeder
{
    public function run(): void
    {
        ServiceCategory::query()->truncate();
        Service::query()->truncate();
        Project::query()->truncate();
        Package::query()->truncate();
        DB::table('pf_service_categories_translations')->truncate();
        DB::table('pf_services_translations')->truncate();
        DB::table('pf_projects_translations')->truncate();
        DB::table('pf_packages_translations')->truncate();

        $this->uploadFiles('projects');
        $this->uploadFiles('services');
        $this->uploadFiles('icons');

        $categories = [
            [
                'name' => 'Development',
                'description' => 'All types of software and web development services.',
            ],
            [
                'name' => 'Design',
                'description' => 'Creative and intuitive design solutions for UI/UX and branding.',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Digital marketing services, including SEO, social media, and more.',
            ],
            [
                'name' => 'Content',
                'description' => 'Content creation and management for blogs, websites, and media.',
            ],
        ];
        $services = [
            [
                'name' => 'Research Planning',
                'description' => 'Get expert advice on research planning and effective execution strategies tailored for your business growth.',
                'metadata' => [
                    'icon_image' => $this->filePath('icons/icon-6.png'),
                ],
            ],
            [
                'name' => 'Strategy Lab',
                'description' => 'Unlock your business potential with insightful, strategic solutions customized for your industry’s unique needs.',
                'metadata' => [
                    'icon_image' => $this->filePath('icons/icon-7.png'),
                ],
            ],
            [
                'name' => 'Business Consultancy',
                'description' => 'We provide expert consultancy services to help your business overcome challenges and achieve sustainable growth.',
                'metadata' => [
                    'icon_image' => $this->filePath('icons/icon-8.png'),
                ],
            ],
            [
                'name' => 'Business Promotion',
                'description' => 'Boost your brand’s visibility and connect with a wider audience through innovative, cutting-edge promotion strategies.',
                'metadata' => [
                    'icon_image' => $this->filePath('icons/icon-9.png'),
                ],
            ],
            [
                'name' => 'Finance Advisory',
                'description' => 'Manage your finances efficiently and effectively with our expert financial planning and advisory services.',
                'metadata' => [
                    'icon_image' => $this->filePath('icons/icon-10.png'),
                ],
            ],
            [
                'name' => 'Revenue Generation',
                'description' => 'Discover new revenue streams and maximize profitability using our proven and innovative business models.',
                'metadata' => [
                    'icon_image' => $this->filePath('icons/icon-11.png'),
                ],
            ],
        ];
        $projects = [
            [
                'name' => 'E-Commerce Website',
                'description' => 'A full-featured e-commerce platform with a clean UI/UX, integrated payment systems, and advanced search features.',
                'client' => 'Retail Store',
                'start_date' => '2023-08-15',
                'metadata' => [
                    'link' => 'https://example.com/e-commerce',
                    'category_ids' => [1],
                ],
            ],
            [
                'name' => 'Mobile App Design',
                'description' => 'A sleek mobile app design for a travel booking service, focusing on user-friendly navigation and visual appeal.',
                'client' => 'Travel Agency',
                'start_date' => '2023-05-20',
                'metadata' => [
                    'link' => 'https://example.com/mobile-app',
                    'category_ids' => [2],
                ],
            ],
            [
                'name' => 'Portfolio Website',
                'description' => 'A minimalist portfolio website for showcasing creative work, with fast loading and responsive design.',
                'client' => 'Creative Professional',
                'start_date' => '2022-11-10',
                'metadata' => [
                    'link' => 'https://example.com/portfolio',
                    'category_ids' => [1, 2],
                ],
            ],
            [
                'name' => 'SEO and Marketing Campaign',
                'description' => 'A successful SEO and digital marketing campaign, driving organic traffic and increasing conversion rates.',
                'client' => 'Tech Startup',
                'start_date' => '2023-02-05',
                'metadata' => [
                    'link' => 'https://example.com/seo-marketing',
                    'category_ids' => [3, 4],
                ],
            ],
            [
                'name' => 'CRM Development',
                'description' => 'Customized CRM software for managing customer interactions and data, integrating seamlessly with third-party tools.',
                'client' => 'B2B Enterprise',
                'start_date' => '2022-09-01',
                'metadata' => [
                    'link' => 'https://example.com/crm',
                    'category_ids' => [1, 3],
                ],
            ],
            [
                'name' => 'Learning Management System',
                'description' => 'A scalable LMS for online education, featuring course management, assessments, and real-time progress tracking.',
                'client' => 'Educational Institution',
                'start_date' => '2023-01-10',
                'metadata' => [
                    'link' => 'https://example.com/lms',
                    'category_ids' => [2, 4],
                ],
            ],
            [
                'name' => 'Healthcare Web App',
                'description' => 'A secure web application for patient data management, appointment scheduling, and telehealth services.',
                'client' => 'Healthcare Provider',
                'start_date' => '2023-03-25',
                'metadata' => [
                    'link' => 'https://example.com/healthcare-app',
                    'category_ids' => [1, 5],
                ],
            ],
            [
                'name' => 'Real Estate Listing Platform',
                'description' => 'A responsive platform for real estate listings, featuring property filters, interactive maps, and virtual tours.',
                'client' => 'Real Estate Agency',
                'start_date' => '2022-12-15',
                'metadata' => [
                    'link' => 'https://example.com/real-estate',
                    'category_ids' => [1, 6],
                ],
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::query()->create($category);
        }

        $categories = ServiceCategory::query()->pluck('id');

        foreach ($services as $service) {
            $metadata = Arr::pull($service, 'metadata', []);

            $service = Service::query()->create([
                ...$service,
                'image' => $this->filePath(sprintf('services/%s.jpg', rand(1, 10))),
                'category_id' => $categories->random(),
                'content' => File::get(database_path('seeders/contents/service.html')),
                'is_featured' => $this->fake()->boolean(),
                'views' => $this->fake()->numberBetween(0, 10000),
            ]);

            foreach ($metadata as $key => $item) {
                MetaBox::saveMetaBoxData($service, $key, $item);
            }

            SlugHelper::createSlug($service);
        }

        foreach ($projects as $index => $project) {
            $index++;

            $metadata = Arr::pull($project, 'metadata', []);

            $project = Project::query()->create([
                ...$project,
                'content' => File::get(database_path('seeders/contents/project.html')),
                'image' => $this->filePath("projects/$index.png"),
                'author' => $this->fake()->name,
                'place' => $this->fake()->city,
                'is_featured' => $this->fake()->boolean(),
                'views' => $this->fake()->numberBetween(0, 10000),
            ]);

            foreach ($metadata as $key => $item) {
                MetaBox::saveMetaBoxData($project, $key, $item);
            }

            SlugHelper::createSlug($project);
        }

        $packages = [
            [
                'name' => 'Trial Plan',
                'description' => 'Protect for testing',
                'price' => 0,
                'features' => <<<HTML
                +Single Team Member
                +Over 1200 UI Blocks
                +10 GB of Cloud Storage
                -Personal Email Account
                -Priority Support
                HTML,
            ],
            [
                'name' => 'Standard',
                'description' => 'Great for large teams',
                'price' => '$49',
                'annual_price' => '$441',
                'duration' => PackageDuration::MONTHLY,
                'is_popular' => true,
                'features' => <<<HTML
                +05 Team Member
                +All multimedia channels
                +All advanced CRM features
                +Up to 15,000 contacts
                +24/7 Support (Email, Chat)
                HTML,
            ],
            [
                'name' => 'Business',
                'description' => 'Advanced projects',
                'price' => '$69',
                'annual_price' => '$621',
                'duration' => PackageDuration::MONTHLY,
                'features' => <<<HTML
                +50 Team Member
                +Over 1500 UI Blocks
                +100 GB of Cloud Storage
                +Personal Email Account
                +Priority Support
                HTML,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'For big companies',
                'price' => '$99',
                'annual_price' => '$891',
                'duration' => PackageDuration::MONTHLY,
                'features' => <<<HTML
                +Customized features
                +Scalability & security
                +Account manager
                +Unlimited chat history
                +50 Integrations
                HTML,
            ],
        ];

        foreach ($packages as $item) {
            Package::query()->create([
                ...$item,
                'content' => '',
                'action_label' => 'Get Started',
                'action_url' => '/contact',
            ]);
        }
    }
}
