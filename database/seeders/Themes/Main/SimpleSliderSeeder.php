<?php

namespace Database\Seeders\Themes\Main;

use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Setting\Facades\Setting;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SimpleSliderSeeder extends BaseSeeder
{
    public function run(): void
    {
        SimpleSlider::query()->truncate();
        SimpleSliderItem::query()->truncate();

        $this->uploadFiles('sliders');

        foreach ($this->getSliders() as $parent) {
            /**
             * @var SimpleSlider $slider
             */
            $slider = SimpleSlider::query()->create(array_merge(Arr::except($parent, 'children'), [
                'key' => Str::slug($parent['name']),
            ]));

            LanguageMeta::saveMetaData($slider);

            foreach ($parent['children'] as $key => $item) {
                $sliderItem = $slider->sliderItems()->create([
                    ...Arr::except($item, ['metadata']),
                    'order' => $key,
                ]);

                foreach ($item['metadata'] as $metaKey => $metaValue) {
                    MetaBox::saveMetaBoxData($sliderItem, $metaKey, $metaValue);
                }
            }
        }

        Setting::set('simple_slider_using_assets', false)->save();
    }

    protected function getSliders(): array
    {
        return [
            [
                'name' => 'Home slider',
                'description' => 'The main slider on homepage',
                'children' => [
                    [
                        'title' => '<b>Best</b> Solutions <br> for <b>Innovation</b>',
                        'description' => 'Infinia offers full range of consultancy & training methods for business consultation.',
                        'image' => $this->filePath('sliders/1.png'),
                        'metadata' => [
                            'subtitle' => '🚀 Welcome to Infinia',
                            'slogan' => '20+ Years of Experience',
                            'primary_action_label' => 'View Our Services',
                            'primary_action_url' => '/contact',
                            'primary_action_icon' => 'ti ti-arrow-up-right',
                            'secondary_action_label' => 'Video Guide',
                            'secondary_action_url' => 'https://www.youtube.com/watch?v=tRxGSHL8bI0',
                            'secondary_action_icon' => 'ti ti-player-play',
                            'background_image' => $this->filePath('backgrounds/team.png'),
                        ],
                    ],
                    [
                        'title' => '<b>Best</b> Solutions <br> for <b>Innovation</b>',
                        'description' => 'Infinia offers full range of consultancy & training methods for business consultation..',
                        'image' => $this->filePath('sliders/2.png'),
                        'metadata' => [
                            'subtitle' => '🚀 Welcome to Infinia',
                            'slogan' => '20+ Years of Experience',
                            'primary_action_label' => 'View Our Services',
                            'primary_action_url' => '/contact',
                            'primary_action_icon' => 'ti ti-arrow-up-right',
                            'secondary_action_label' => 'Video Guide',
                            'secondary_action_url' => 'https://www.youtube.com/watch?v=tRxGSHL8bI0',
                            'secondary_action_icon' => 'ti ti-player-play',
                            'background_image' => $this->filePath('backgrounds/team.png'),
                        ],
                    ],
                ],
            ],
        ];
    }
}
