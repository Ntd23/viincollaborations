<?php

namespace Theme\Infinia\Providers;

use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\ServiceProvider;

class BusinessSetupSliderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! function_exists('add_shortcode')) {
            return;
        }

        add_shortcode(
            'business_setup_slider',
            __('Business Setup Slider'),
            __('Display a claymorphism business setup service slider.'),
            function (ShortcodeCompiler $shortcode): ?string {
                $slides = shortcode()->fields()->getTabsData([
                    'headline',
                    'sub_headline',
                    'description',
                    'problem',
                    'solution_title',
                    'solution',
                    'cta_label',
                    'cta_url',
                    'graphic_idea',
                ], $shortcode);

                $slides = array_filter($slides, fn (array $slide): bool => ! empty($slide['headline']) || ! empty($slide['solution_title']));

                if (empty($slides)) {
                    return null;
                }

                return view(
                    Theme::getThemeNamespace('partials.shortcodes.business-setup-slider'),
                    compact('shortcode', 'slides')
                )->render();
            }
        );

        shortcode()->setAdminConfig('business_setup_slider', function (array $attributes): ShortcodeForm {
            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add(
                    'title',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Title'))
                        ->placeholder(__('Business setup in Vietnam, made clear'))
                )
                ->add(
                    'subtitle',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Subtitle'))
                        ->placeholder(__('Company formation, tax, legal, and technology investment support'))
                )
                ->add(
                    'description',
                    TextareaField::class,
                    TextareaFieldOption::make()
                        ->label(__('Description'))
                        ->rows(2)
                )
                ->add(
                    'slides',
                    ShortcodeTabsField::class,
                    ShortcodeTabsFieldOption::make()
                        ->label(__('Slides'))
                        ->attrs($attributes)
                        ->fields([
                            'headline' => [
                                'title' => __('Problem headline'),
                                'required' => true,
                            ],
                            'sub_headline' => [
                                'title' => __('Sub headline'),
                            ],
                            'description' => [
                                'title' => __('Description'),
                                'type' => 'textarea',
                            ],
                            'problem' => [
                                'title' => __('Pain points'),
                                'type' => 'textarea',
                                'helper' => __('Enter each item in a new line.'),
                            ],
                            'solution_title' => [
                                'title' => __('Solution title'),
                                'required' => true,
                            ],
                            'solution' => [
                                'title' => __('Benefits'),
                                'type' => 'textarea',
                                'helper' => __('Enter each item in a new line.'),
                            ],
                            'graphic_idea' => [
                                'title' => __('Center visual idea'),
                                'type' => 'textarea',
                            ],
                            'cta_label' => [
                                'title' => __('CTA label'),
                            ],
                            'cta_url' => [
                                'title' => __('CTA URL'),
                            ],
                        ])
                );
        });
    }
}
