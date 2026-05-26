<?php

use Botble\Base\Forms\FieldOptions\AlertFieldOption;
use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\EditorFieldOption;
use Botble\Base\Forms\FieldOptions\LabelFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\AlertField;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\LabelField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Testimonial\Models\Testimonial;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Illuminate\Support\Arr;
use Theme\Infinia\Forms\ShortcodeForm;

app()->booted(function (): void {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    Shortcode::register(
        'hero-banner',
        __('Hero Banner'),
        __('Hero Banner'),
        function (ShortcodeCompiler $shortcode) {
            $skills = Shortcode::fields()->getTabsData(['name', 'image'], $shortcode);
            $floatingFeatures = Shortcode::fields()->getTabsData(['title'], $shortcode) ?? [];
            $brands = Shortcode::fields()->getTabsData(['name', 'url', 'image'], $shortcode) ?? [];

            return Theme::partial('shortcodes.hero-banner.index', compact('shortcode', 'skills', 'floatingFeatures', 'brands'));
        }
    );

    Shortcode::setPreviewImage('hero-banner', Theme::asset()->url('images/ui-blocks/hero-banner.png'));

    Shortcode::setAdminConfig('hero-banner', function (array $attributes) {
        $form = ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 4))->mapWithKeys(function ($i) {
                            $image = $i <= 3
                                ? Theme::asset()->url("images/shortcodes/hero-banner/style-$i.png")
                                : Theme::asset()->url("images/shortcodes/hero-banner/style-1.png");
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => $image,
                                ],
                            ];
                        })->all()
                    )
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title (Style 4: dùng | để chia dòng mobile, VD: Collaborations|FIA Agency)'))
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle'))
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Description'))
                    ->collapsible('style', [1, 3], $attributes['style'] ?? 1)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
            )
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Background image'))
                    ->collapsible('style', 2, $attributes['style'] ?? 2)
            )
            ->addButtonActions(['primary' => __('Primary'), 'secondary' => __('Secondary')])
            ->add(
                'logo_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Logo image'))
                    ->collapsible('style', 4, $attributes['style'] ?? 1)
            )
            ->add(
                'main_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Main image'))
                    ->collapsible('style', 4, $attributes['style'] ?? 1)
            )
            ->add(
                'section_1_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Section 1 title'))
                    ->collapsible('style', 4, $attributes['style'] ?? 1)
            )
            ->add(
                'section_1_content',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Section 1 content'))
                    ->collapsible('style', 4, $attributes['style'] ?? 1)
            )
            ->add(
                'section_2_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Section 2 title'))
                    ->collapsible('style', 4, $attributes['style'] ?? 1)
            )
            ->add(
                'section_2_content',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Section 2 content'))
                    ->collapsible('style', 4, $attributes['style'] ?? 1)
            )
            ->add(
                'bottom_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Bottom image'))
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
            )
            ->add(
                'right_background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Right background image'))
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
            )
            ->addOpenFieldset('shape_image');

        foreach (range(1, 3) as $i) {
            $form->add(
                "shape_{$i}_image",
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Shape image :number', ['number' => $i]))
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
            );
        }

        foreach (range(1, 4) as $i) {
            $form->add(
                "main_image_{$i}",
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image :number', ['number' => $i]))
                    ->collapsible('style', 3, $attributes['style'] ?? 1)
            );
        }

        $form
            ->add(
                'floating_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Floating image'))
                    ->collapsible('style', 3, $attributes['style'] ?? 1)
                    ->defaultValue(Theme::asset()->url('images/shapes/star-rotate.png'))
            );

        $form
            ->add(
                'bottom_title',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', 3, $attributes['style'] ?? 1)
                    ->label(__('Bottom title'))
            )
            ->add(
                'brands',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->collapsible('style', 3, $attributes['style'] ?? 1)
                    ->label(__('Features'))
                    ->fields([
                        'name' => [
                            'title' => __('Name'),
                        ],
                        'url' => [
                            'title' => __('URL'),
                        ],
                        'image' => [
                            'title' => __('Image'),
                            'type' => 'image',
                        ],
                    ])
                    ->attrs($attributes)
            );

        return $form
            ->addCloseFieldset('shape_image')
            ->addOpenFieldset('floating_card')
            ->add(
                'floating_card_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
                    ->label(__('Floating card image'))
            )
            ->add(
                'floating_card_title',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [1, 2], $attributes['style'] ?? 1)
                    ->label(__('Floating card title'))
            )
            ->add(
                'floating_card_description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->collapsible('style', [1, 2], $attributes['style'] ?? 1)
                    ->label(__('Floating card description'))
            )
            ->add(
                'floating_tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
                    ->label(__('Features'))
                    ->fields([
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add(
                'floating_card_button_label',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
                    ->label(__('Floating card button label'))
            )
            ->add(
                'floating_card_button_url',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
                    ->label(__('Floating card button URL'))
            )
            ->addCloseFieldset('floating_card')
            ->add(
                'display_social_links',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
                    ->label(__('Display social links?'))
            )
            ->add(
                'social_links_box_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Social links title'))
                    ->collapsible('display_social_links', 1, $attributes['display_social_links'] ?? 0)
            );
    });

    Shortcode::register('partners', __('Partners'), __('Partners'), function (ShortcodeCompiler $shortcode) {
        $partners = Shortcode::fields()->getTabsData(['name', 'image', 'url', 'open_in_new_tab'], $shortcode);

        if (empty($partners)) {
            return null;
        }

        return Theme::partial('shortcodes.partners.index', compact('shortcode', 'partners'));
    });

    Shortcode::setPreviewImage('partners', Theme::asset()->url('images/ui-blocks/partners.png'));

    Shortcode::setAdminConfig('partners', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 4))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/partners/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->collapsible('style', [2, 3, 4], $attributes['style'] ?? 1)
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle'))
                    ->collapsible('style', [4], $attributes['style'] ?? 1)
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Description'))
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
            )
            ->addButtonActions(wrapperAttributes: [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '2',
                'style' => ($attributes['style'] ?? 1) == 2 ? '' : 'display: none;',
            ])
            ->add(
                'partners',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Partners'))
                    ->fields([
                        'name' => [
                            'type' => 'text',
                            'title' => __('Name'),
                        ],
                        'image' => [
                            'type' => 'image',
                            'title' => __('Image'),
                            'required' => true,
                        ],
                        'url' => [
                            'type' => 'text',
                            'title' => __('URL'),
                        ],
                        'open_in_new_tab' => [
                            'type' => 'onOff',
                            'title' => __('Open URL in a new tab'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add('background_color', ColorField::class, ColorFieldOption::make()->label(__('Background color')));
    });

    Shortcode::register('features', __('Features'), __('Features'), function (ShortcodeCompiler $shortcode) {
        $features = Shortcode::fields()->getTabsData(['title', 'description', 'icon', 'icon_image'], $shortcode);
        $dataCounters = Shortcode::fields()->getTabsData(['data_count_title', 'data_count', 'data_count_unit'], $shortcode);

        if (empty($features) && $shortcode->style == 1) {
            return null;
        }

        $checklist = array_filter(explode("\n", $shortcode->checklist));

        return Theme::partial('shortcodes.features.index', compact('shortcode', 'features', 'checklist', 'dataCounters'));
    });

    Shortcode::setPreviewImage('features', Theme::asset()->url('images/ui-blocks/features.png'));

    Shortcode::setAdminConfig('features', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices(
                        collect(range(1, 10))
                            ->mapWithKeys(fn ($number) => [
                                $number => [
                                    'label' => __('Style :number', ['number' => $number]),
                                    'image' => Theme::asset()->url("images/shortcodes/features/style-$number.png"),
                                ],
                            ])
                            ->toArray()
                    )
                    ->selected(Arr::get($attributes, 'style', 'style-1'))
                    ->withoutAspectRatio()
                    ->numberItemsPerRow(1)
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [1, 2, 3, 4, 5, 7, 8, 9], $attributes['style'] ?? 1)
                    ->label(__('Subtitle'))
            )
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()
                    ->label(__('Description'))
                    ->collapsible('style', [5, 6, 7, 8, 9, 10], $attributes['style'] ?? 1)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [1, 2, 3, 4, 6, 7, 8, 9, 10], $attributes['style'] ?? 1)
                    ->label(__('Image'))
            )
            ->add(
                'image_1',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [4, 9], $attributes['style'] ?? 1)
                    ->label(__('Image :number', ['number' => 1]))
            )
            ->add(
                'checklist',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Checklist'))
                    ->helperText(__('Enter each item in a new line'))
                    ->collapsible('style', [2, 5], ($attributes['style'] ?? 1))
            )
            ->addButtonActions(
                ['primary' => __('Primary'), 'secondary' => __('Secondary')],
                [
                    'data-bb-collapse' => 'true',
                    'data-bb-trigger' => '[name=style]',
                    'data-bb-value' => '[3, 7]',
                    'style' => in_array($attributes['style'] ?? 1, [3, 7]) ? '' : 'display: none;',
                ]
            )
            ->addOpenFieldset('floating_card', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '[2, 3, 5, 6, 8]',
                'style' => in_array($attributes['style'] ?? 1, [2, 3, 5, 6, 8]) ? '' : 'display: none;',
            ])
            ->add(
                'floating_card_label',
                LabelField::class,
                LabelFieldOption::make()
                    ->collapsible('style', [2, 5], $attributes['style'] ?? 1)
                    ->label(__('Floating card'))
            )
            ->add(
                'floating_card_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [2, 3, 5, 6], $attributes['style'] ?? 1)
                    ->label(__('Floating card image'))
            )
            ->add(
                'floating_card_title',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [2, 3, 5, 6, 8], $attributes['style'] ?? 1)
                    ->label(__('Floating card title'))
            )
            ->add(
                'floating_card_data_count',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [8], $attributes['style'] ?? 1)
                    ->label(__('Floating card data count'))
            )
            ->add(
                'floating_card_data_count_unit',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [8], $attributes['style'] ?? 1)
                    ->label(__('Floating card data count unit'))
            )
            ->add(
                'floating_card_description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->collapsible('style', [2, 3], $attributes['style'] ?? 1)
                    ->label(__('Floating card description'))
            )
            ->add(
                'floating_card_icon_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [5], $attributes['style'] ?? 1)
                    ->label(__('Floating card icon image'))
            )
            ->add(
                'floating_card_button_label',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [2, 5], $attributes['style'] ?? 1)
                    ->label(__('Floating card button label'))
            )
            ->add(
                'floating_card_button_url',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [2, 5], $attributes['style'] ?? 1)
                    ->label(__('Floating card button URL'))
            )
            ->addCloseFieldset('floating_card')
            ->addOpenFieldset('features', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '[1, 2, 3, 4, 6]',
                'style' => in_array($attributes['style'] ?? 1, [1, 2, 3, 4, 6, 8]) ? '' : 'display: none;',
            ])
            ->add(
                'features_label',
                LabelField::class,
                LabelFieldOption::make()
                    ->label(__('Features'))
            )
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Features'))
                    ->fields([
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                        ],
                        'icon' => [
                            'type' => 'coreIcon',
                            'title' => __('Icon'),
                        ],
                        'icon_image' => [
                            'type' => 'image',
                            'title' => __('Icon image'),
                            'helper' => __('It will replace Icon if it is present.'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->addCloseFieldset('features')
            ->addOpenFieldset('data_count_open', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '[5]',
                'style' => in_array($attributes['style'] ?? 1, [5]) ? '' : 'display: none;',
            ])
            ->add(
                'data_count_label',
                LabelField::class,
                LabelFieldOption::make()
                    ->label(__('Data Counters'))
            )
            ->add(
                'data_counters',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Data Counters'))
                    ->fields([
                        'data_count_title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'data_count' => [
                            'type' => 'number',
                            'title' => __('Counter'),
                        ],
                        'data_count_unit' => [
                            'type' => 'text',
                            'title' => __('Unit'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->addCloseFieldset('data_count_closed')
            ->add(
                'background_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->collapsible('style', [8, 9], $attributes['style'] ?? 1)
                    ->label(__('Background color'))
            );
    });

    Shortcode::register('content-quote', __('Content Quote'), __('Content Quote'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.content-quote.index', compact('shortcode'));
    });

    Shortcode::setPreviewImage('content-quote', Theme::asset()->url('images/ui-blocks/content-quote.png'));

    Shortcode::setAdminConfig('content-quote', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'quote',
                TextareaField::class,
                TextareaFieldOption::make()->label(__('Quote'))->rows(2)
            )
            ->add(
                'author',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Author'))
            )
            ->add(
                'author_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Author Image'))
            )
            ->add(
                'author_description',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Author Description'))
            );
    });

    Shortcode::register('content-checklist', __('Content Checklist'), __('Content Checklist'), function (ShortcodeCompiler $shortcode) {
        $checklist = str($shortcode->checklist)->explode("\n")->filter()->split(3);

        return Theme::partial('shortcodes.content-checklist.index', compact('shortcode', 'checklist'));
    });

    Shortcode::setPreviewImage('content-checklist', Theme::asset()->url('images/ui-blocks/content-checklist.png'));

    Shortcode::setAdminConfig('content-checklist', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'checklist',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Checklist'))
                    ->helperText(__('Enter each item in a new line'))
            );
    });

    Shortcode::register('content-features', __('Content Features'), __('Content Features'), function (ShortcodeCompiler $shortcode) {
        $features = Shortcode::fields()->getTabsData(['title', 'description', 'icon', 'icon_image'], $shortcode);

        return Theme::partial('shortcodes.content-features.index', compact('shortcode', 'features'));
    });

    Shortcode::setPreviewImage('content-features', Theme::asset()->url('images/ui-blocks/content-features.png'));

    Shortcode::setAdminConfig('content-features', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Features'))
                    ->fields([
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                        ],
                        'icon' => [
                            'type' => 'coreIcon',
                            'title' => __('Icon'),
                        ],
                        'icon_image' => [
                            'type' => 'image',
                            'title' => __('Icon image'),
                            'helper' => __('It will replace Icon if it is present.'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            );
    });

    Shortcode::register('about-us-information', __('About Us Information'), __('About Us Information'), function (ShortcodeCompiler $shortcode) {
        if ($shortcode->style == 2) {
            $features = [];
        } elseif ($shortcode->style == 3) {
            $features = Shortcode::fields()->getTabsData(['title', 'description', 'icon', 'icon_image'], $shortcode);
        } else {
            $features = Shortcode::fields()->getTabsData(['title'], $shortcode);
        }

        return Theme::partial('shortcodes.about-us-information.index', compact('shortcode', 'features'));
    });

    Shortcode::setPreviewImage('about-us-information', Theme::asset()->url('images/ui-blocks/about-us-information.png'));

    Shortcode::setAdminConfig('about-us-information', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 3))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/about-us-information/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->collapsible('style', [1, 3], $attributes['style'] ?? 1)
                    ->label(__('Features'))
                    ->fields([
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                            'condition' => ['style' => [3]],
                        ],
                        'icon' => [
                            'type' => 'coreIcon',
                            'title' => __('Icon'),
                            'condition' => ['style' => [3]],
                        ],
                        'icon_image' => [
                            'type' => 'image',
                            'title' => __('Icon image'),
                            'condition' => ['style' => [3]],
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            )
            ->add(
                'display_social_links',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
                    ->label(__('Display social links?'))
            )
            ->add(
                'social_links_box_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Social links box title'))
                    ->collapsible('display_social_links', 1, $attributes['display_social_links'] ?? 0)
            );
    });

    Shortcode::register('about-us-information-tabs', __('About Us Information Tabs'), __('About Us Information Tabs'), function (ShortcodeCompiler $shortcode) {
        $counters = Shortcode::fields()->getTabsData(['data_counter_title', 'data_counter', 'data_counter_unit'], $shortcode);
        $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'content', 'image'], $shortcode);

        $features = explode('|', $shortcode->features) ?? [];

        return Theme::partial('shortcodes.about-us-information-tabs.index', compact('shortcode', 'counters', 'tabs', 'features'));
    });

    Shortcode::setPreviewImage('about-us-information-tabs', Theme::asset()->url('images/ui-blocks/about-us-information-tabs.png'));

    Shortcode::setAdminConfig('about-us-information-tabs', function (array $attributes) {
        $form = ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            );

        foreach (range(1, 2) as $i) {
            $form->addOpenFieldset("data_counter_tab_{$i}_open")
                ->add("data_counter_tab_label_{$i}", AlertField::class, AlertFieldOption::make()->content(__('Data counter :i', ['i' => $i])))
                ->add(
                    "data_counter_title_{$i}",
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Title'))
                )
                ->add(
                    "data_counter_{$i}",
                    NumberField::class,
                    NumberFieldOption::make()
                        ->label(__('Counter'))
                )
                ->add(
                    "data_counter_unit_{$i}",
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Unit'))
                )
                ->addCloseFieldset("data_counter_tab_{$i}_close");
        }

        $form
            ->add(
                'features',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Features'))
                    ->helperText(__('Each new line is a heading separated by a "|".'))
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                ->label(__('Tabs'))
                ->fields([
                    'title' => [
                        'type' => 'text',
                        'title' => __('Title'),
                        'required' => true,
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => __('Description'),
                    ],
                    'content' => [
                        'type' => 'textarea',
                        'title' => __('Content'),
                    ],
                    'image' => [
                        'type' => 'image',
                        'title' => __('Image'),
                    ],
                ])
                ->attrs($attributes)
            )
        ->addOpenFieldset('author_open')
        ->add('author_name', TextField::class, TextFieldOption::make()->label(__('Author name')))
        ->add('author_title', TextField::class, TextFieldOption::make()->label(__('Author title')))
        ->add('author_signature', MediaImageField::class, MediaImageFieldOption::make()->label(__('Author signature')))
        ->add('author_avatar', MediaImageField::class, MediaImageFieldOption::make()->label(__('Author avatar')))
            ->addCloseFieldset('author_closed')
        ->add('bottom_description', TextareaField::class, DescriptionFieldOption::make())
        ->addButtonActions(['primary' => __('Primary')]);

        return $form;
    });

    Shortcode::register('site-statistics', __('Site Statistics'), __('Site Statistics'), function (ShortcodeCompiler $shortcode): ?string {
        $tabs = Shortcode::fields()->getTabsData(['title', 'data', 'unit'], $shortcode);

        if ($shortcode->style == 3) {
            $tabs = Shortcode::fields()->getTabsData(['second_tab_title', 'second_tab_description', 'second_tab_data', 'second_tab_unit'], $shortcode);
        }

        if (! $tabs) {
            return null;
        }

        return Theme::partial('shortcodes.site-statistics.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('site-statistics', Theme::asset()->url('images/ui-blocks/site-statistics.png'));

    Shortcode::setAdminConfig('site-statistics', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 3))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/site-statistics/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->collapsible('style', [1, 2], $attributes['style'] ?? 1)
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->collapsible('style', [1, 2], $attributes['style'] ?? 1)
                    ->attrs($attributes)
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                        ],
                        'data' => [
                            'title' => __('Data'),
                        ],
                        'unit' => [
                            'title' => __('Unit'),
                        ],
                    ])
            )
            ->add(
                'tabs_1',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->collapsible('style', 3, $attributes['style'] ?? 1)
                    ->attrs($attributes)
                    ->fields([
                        'second_tab_title' => [
                            'title' => __('Title'),
                        ],
                        'second_tab_description' => [
                            'title' => __('Description'),
                        ],
                        'second_tab_data' => [
                            'title' => __('Data'),
                        ],
                        'second_tab_unit' => [
                            'title' => __('Unit'),
                        ],
                    ])
            )
            ->addButtonActions(wrapperAttributes: [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => 2,
                'style' => ($attributes['style'] ?? 1) == 2 ? '' : 'display: none;',
            ])
            ->add(
                'background_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->collapsible('style', [2, 3], $attributes['style'] ?? 1)
                    ->label(__('Background color'))
            )
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
                    ->label(__('Background image'))
            );
    });

    Shortcode::register('our-mission', __('Our Mission'), __('Our Mission'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData(['title', 'data', 'unit', 'text_color', 'background_color'], $shortcode);

        $testimonials = collect();

        if (is_plugin_active('testimonial')) {
            $testimonials = Testimonial::query()
                ->wherePublished()
                ->limit($shortcode->testimonial_limit ?: 2)
                ->get();
        }

        return Theme::partial('shortcodes.our-mission.index', compact('shortcode', 'tabs', 'testimonials'));
    });

    Shortcode::setAdminConfig('our-mission', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 3))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/our-mission/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle'))
                    ->collapsible('style', [1, 2], $attributes['style'] ?? 1)
            )
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->addButtonActions(['primary' => __('Primary')], [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => 3,
                'style' => ($attributes['style'] ?? 1) == 3 ? '' : 'display: none;',
            ])
            ->add(
                'bottom_description',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', 3, $attributes['style'] ?? 1)
                    ->label(__('Bottom description'))
            )
            ->addOpenFieldset('floating_data_count_open', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => 3,
                'style' => ($attributes['style'] ?? 1) == 3 ? '' : 'display: none;',
            ])
            ->add('floating_data_count_title', TextField::class, TextFieldOption::make()->label(__('Floating data count title')))
            ->add('floating_data_count_subtitle', TextField::class, TextFieldOption::make()->label(__('Floating Data count subtitle')))
            ->add('floating_data_count', NumberField::class, NumberFieldOption::make()->label(__('Floating Data count')))
            ->add('floating_data_count_unit', TextField::class, TextFieldOption::make()->label(__('Floating Data count unit')))
            ->add('floating_button_label', TextField::class, TextFieldOption::make()->label(__('Floating button label')))
            ->add('floating_button_characters_highlight', TextField::class, TextFieldOption::make()->label(__('Floating button characters highlight')))
            ->add('floating_button_url', TextField::class, TextFieldOption::make()->label(__('Floating button URL')))
            ->addCloseFieldset('floating_data_count_closed')
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Tabs'))
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                        ],
                        'data' => [
                            'title' => __('Data'),
                        ],
                        'unit' => [
                            'title' => __('Unit'),
                        ],
                        'text_color' => [
                            'title' => __('Text color'),
                            'type' => 'color',
                        ],
                        'background_color' => [
                            'title' => __('Background color'),
                            'type' => 'color',
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->when(is_plugin_active('testimonial'), function (ShortcodeForm $form) use ($attributes) {
                $form
                    ->add(
                        'testimonial_box_title',
                        TextField::class,
                        TextFieldOption::make()
                            ->label(__('Testimonial box title'))
                            ->collapsible('style', 2, $attributes['style'] ?? 1)
                    )
                    ->add(
                        'testimonial_limit',
                        NumberField::class,
                        NumberFieldOption::make()
                            ->label(__('Testimonial limit'))
                    );
            })
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            )
            ->add(
                'image_1',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [1, 2], $attributes['style'] ?? 1)
                    ->label(__('Image :number', ['number' => 1]))
            )
            ->add(
                'image_2',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
                    ->label(__('Image :number', ['number' => 2]))
            )
            ->add('background_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Background image')));
    });

    Shortcode::setPreviewImage('our-mission', Theme::asset()->url('images/ui-blocks/our-mission.png'));

    Shortcode::register('our-history', __('Our History'), __('Our History'), function (ShortcodeCompiler $shortcode) {
        $features = Shortcode::fields()->getTabsData(['title'], $shortcode);

        return Theme::partial('shortcodes.our-history.index', compact('shortcode', 'features'));
    });

    Shortcode::setPreviewImage('our-history', Theme::asset()->url('images/ui-blocks/our-history.png'));

    Shortcode::setAdminConfig('our-history', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 4))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/our-history/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()
                    ->collapsible('style', [1, 3], $attributes['style'] ?? 1)
            )
            ->add(
                'main_content',
                TextareaField::class,
                TextareaFieldOption::make()->label(__('Content'))
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
            )
            ->add(
                'content_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Content title'))
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
            )

            ->add(
                'content_description',
                TextareaField::class,
                DescriptionFieldOption::make()
                    ->label(__('Content description'))
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
                    ->collapsible('style', [2, 3, 4], $attributes['style'] ?? 1)
            )
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Features'))
                    ->collapsible('style', [2, 3], $attributes['style'] ?? 1)
                    ->attrs($attributes)
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                        ],
                    ])
            )
            ->addOpenFieldset('author_open', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '[1, 2]',
                'style' => in_array(($attributes['style'] ?? 1), [1, 2]) ? '' : 'display: none;',
            ])
            ->add('author_name', TextField::class, TextFieldOption::make()->label(__('Author name')))
            ->add('author_title', TextField::class, TextFieldOption::make()->label(__('Author title')))
            ->add('author_signature', MediaImageField::class, MediaImageFieldOption::make()->label(__('Author signature')))
            ->add('author_avatar', MediaImageField::class, MediaImageFieldOption::make()->label(__('Author avatar')))
            ->addCloseFieldset('author_closed')
            ->addOpenFieldset('data_count_open', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '2',
                'style' => in_array(($attributes['style'] ?? 1), [2]) ? '' : 'display: none;',
            ])
            ->add('data_count_title', TextField::class, TextFieldOption::make()->label(__('Data count title')))
            ->add('data_count', NumberField::class, NumberFieldOption::make()->label(__('Data count')))
            ->add(
                'data_count_unit',
                TextField::class,
                TextFieldOption::make()->label(__('Data count unit'))
            )
            ->addCloseFieldset('data_count_closed')
            ->addButtonActions(['primary' => __('Primary'), 'secondary' => __('Secondary')], [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '[1, 3]',
                'style' => in_array(($attributes['style'] ?? 1), [1, 3]) ? '' : 'display: none;',
            ])
            ->addButtonActions(['default' => __('Button')], [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '2',
                'style' => in_array(($attributes['style'] ?? 1), [2]) ? '' : 'display: none;',
            ])
            ->addButtonActions(['floating' => __('Floating button')], [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '[3, 4]',
                'style' => in_array(($attributes['style'] ?? 1), [3, 4]) ? '' : 'display: none;',
            ])
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [4], $attributes['style'] ?? 1)
                    ->label(__('Background image'))
            );
    });

    Shortcode::register('platforms-featured', __('Platforms Featured'), __('Platforms Featured'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData(['title', 'url', 'icon_image'], $shortcode);

        return Theme::partial('shortcodes.platforms-featured.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('platforms-featured', Theme::asset()->url('images/ui-blocks/platforms-featured.png'));

    Shortcode::setAdminConfig('platforms-featured', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 2))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/platforms-featured/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            )
            ->add(
                'image_1',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image :number', ['number' => 1]))
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
            )
            ->addButtonActions(['primary' => __('Primary')])
            ->add(
                'bottom_description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
                    ->label(__('Bottom description'))
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                        ],
                        'url' => [
                            'title' => __('URL'),
                        ],
                        'icon_image' => [
                            'type' => 'image',
                            'title' => __('Icon image'),
                            'helper' => __('It will replace Icon if it is present.'),
                        ],
                    ])
            )
            ->add('background_color', ColorField::class, ColorFieldOption::make()->label(__('Background color')));
    });

    Shortcode::register('contact-block', __('Contact Block'), __('Contact Block'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.contact-block.index', compact('shortcode'));
    });

    Shortcode::setPreviewImage('contact-block', Theme::asset()->url('images/ui-blocks/contact-block.png'));

    Shortcode::setAdminConfig('contact-block', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->addOpenFieldset('contact_fieldset_open')
            ->add('contact_icon', MediaImageField::class, MediaImageFieldOption::make()->label(__('Icon')))
            ->add('contact_title', TextField::class, TextFieldOption::make()->label(__('Contact title')))
            ->add('contact_label', TextField::class, TextFieldOption::make()->label(__('Contact label')))
            ->add('contact_url', TextField::class, TextFieldOption::make()->label(__('Contact URL')))
            ->addCloseFieldset('contact_fieldset_closed')
            ->addButtonActions(['primary' => __('Primary')])
            ->add('background_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Background image')));
    });

    Shortcode::register('information-block', __('Information Block'), __('Information Block'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'url', 'icon', 'icon_image', 'data', 'unit'], $shortcode);

        return Theme::partial('shortcodes.information-block.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('information-block', Theme::asset()->url('images/ui-blocks/information-block.png'));

    Shortcode::setAdminConfig('information-block', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                        ],
                        'description' => [
                            'title' => __('Description'),
                            'type' => 'textarea',
                        ],
                        'url' => [
                            'title' => __('URL'),
                        ],
                        'icon' => [
                            'type' => 'coreIcon',
                            'title' => __('Icon'),
                        ],
                        'icon_image' => [
                            'type' => 'image',
                            'title' => __('Icon image'),
                            'helper' => __('It will replace Icon if it is present.'),
                        ],
                        'data' => [
                            'title' => __('Data'),
                        ],
                        'unit' => [
                            'title' => __('Unit'),
                        ],
                    ])
            )
            ->add('background_color', ColorField::class, ColorFieldOption::make()->label(__('Background color')));
    });

    Shortcode::register('app-downloads', __('App Downloads'), __('App Downloads'), function (ShortcodeCompiler $shortcode) {
        $platforms = Shortcode::fields()->getTabsData(['name', 'url', 'image'], $shortcode);

        $features = explode('|', $shortcode->features) ?? [];

        return Theme::partial('shortcodes.app-downloads.index', compact('shortcode', 'platforms', 'features'));
    });

    Shortcode::setPreviewImage('app-downloads', Theme::asset()->url('images/ui-blocks/app-downloads.png'));

    Shortcode::setAdminConfig('app-downloads', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
            ->add(
                'features',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Features'))
                    ->helperText(__('Separate each feature with a "|"'))
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->fields([
                        'name' => [
                            'title' => __('Name'),
                            'required' => true,
                        ],
                        'url' => [
                            'title' => __('URL'),
                        ],
                        'image' => [
                            'type' => 'image',
                            'title' => __('Image'),
                            'required' => true,
                        ],
                    ])
            )
            ->addOpenFieldset('reviews_card')
                ->add('reviews_card_title', TextField::class, TextFieldOption::make()->label(__('Reviews card title')))
                ->add('reviews_card_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Reviews card image')))
                ->add('reviews_card_rate', TextField::class, TextFieldOption::make()->label(__('Reviews card rate')))
                ->add('reviews_card_data', NumberField::class, NumberFieldOption::make()->label(__('Reviews card data')))
                ->add('reviews_card_unit', TextareaField::class, TextareaFieldOption::make()->label(__('Reviews card unit')))
            ->addCloseFieldset('reviews_card');
    });

    Shortcode::register('instruction-steps', __('Instruction Steps'), __('Instruction Steps'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'icon', 'icon_image'], $shortcode);

        return Theme::partial('shortcodes.instruction-steps.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('instruction-steps', Theme::asset()->url('images/ui-blocks/instruction-steps.png'));

    Shortcode::setAdminConfig('instruction-steps', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 2))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/instruction-steps/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
                    ->collapsible('style', 1, $attributes['style'] ?? 1)
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->max(3)
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'description' => [
                            'title' => __('Description'),
                            'type' => 'textarea',
                        ],
                        'icon' => [
                            'title' => __('Icon'),
                            'type' => 'coreIcon',
                        ],
                        'icon_image' => [
                            'title' => __('Icon Image (It will override icon above if set)'),
                            'type' => 'image',
                        ],
                    ])
            )
            ->addButtonActions(['primary' => __('Primary'), 'secondary' => __('Secondary')], [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '1',
                'style' => ($attributes['style'] ?? 1) == 1 ? '' : 'display: none;',
            ])
            ->add(
                'bottom_description',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
                    ->label(__('Bottom description'))
            )
            ->add(
                'action_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Action label'))
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
            )
            ->add(
                'action_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Action URL'))
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
            )
            ->add('background_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Background image')));
    });

    Shortcode::register('feature-tabs', __('Feature Tabs'), __('Feature Tabs'), function (ShortcodeCompiler $shortcode) {
        $tabFields = [
            'tab_name',
            'title',
            'description',
            'image',
        ];

        for ($i = 1; $i <= 5; $i++) {
            $tabFields = [
                ...$tabFields,
                'feature_item_title_' . $i,
                'feature_item_description_' . $i,
                'feature_item_icon_' . $i,
                'feature_item_icon_image_' . $i,
            ];
        }

        $tabs = Shortcode::fields()->getTabsData($tabFields, $shortcode);

        return Theme::partial('shortcodes.feature-tabs.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('feature-tabs', Theme::asset()->url('images/ui-blocks/feature-tabs.png'));

    Shortcode::setAdminConfig('feature-tabs', function (array $attributes) {
        $tabFields = [
            'tab_name' => [
                'title' => __('Tab Name'),
                'required' => true,
            ],
            'title' => [
                'title' => __('Title'),
                'required' => true,
            ],
            'description' => [
                'title' => __('Description'),
                'type' => 'textarea',
            ],
            'image' => [
                'title' => __('Image'),
                'type' => 'image',
            ],
        ];

        for ($i = 1; $i <= 5; $i++) {
            $tabFields = [
                ...$tabFields,
                'feature_item_title_' . $i => [
                    'title' => __('Feature title :number', ['number' => $i]),
                ],
                'feature_item_description_' . $i => [
                    'title' => __('Feature title :number', ['number' => $i]),
                    'type' => 'textarea',
                ],
                'feature_item_icon_' . $i => [
                    'title' => __('Feature icon :number', ['number' => $i]),
                    'type' => 'coreIcon',
                ],
                'feature_item_icon_image_' . $i => [
                    'title' => __('Feature icon image :number (It will override icon above if set)', ['number' => $i]),
                    'type' => 'image',
                ],
            ];
        }

        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->fields($tabFields)
            )
            ->addButtonActions(['primary' => __('Primary'), 'secondary' => __('Secondary')])
            ->add('background_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Background image')));
    });

    Shortcode::register('compare-plans', __('Compare Plans'), __('Compare Plans'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData([
            'criteria',
            'description',
            'value_1',
            'value_2',
            'value_3',
        ], $shortcode);

        $packages = Shortcode::fields()->getTabsData([
            'package_name',
            'package_description',
        ], $shortcode);

        return Theme::partial('shortcodes.compare-plans.index', compact('shortcode', 'tabs', 'packages'));
    });

    Shortcode::setPreviewImage('compare-plans', Theme::asset()->url('images/ui-blocks/compare-plans.png'));

    Shortcode::setAdminConfig('compare-plans', function (array $attributes) {
        $form =  ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add('description', TextareaField::class, DescriptionFieldOption::make());

        foreach (range(1, 3) as $i) {
            $form
                ->addOpenFieldset("package_{$i}_open")
                ->add("label_package_$i", AlertField::class, AlertFieldOption::make()->content(__('Package :number', ['number' => $i])))
                ->add("package_name_$i", TextField::class, TextFieldOption::make()->label(__('Package name :number', ['number' => $i])))
                ->add("package_description_$i", TextareaField::class, TextareaFieldOption::make()->label(__('Package description :number', ['number' => $i])))
                ->addCloseFieldset("package_{$i}_closed");
        }

        return $form->add(
            'tabs',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                 ->attrs($attributes)
                 ->fields([
                     'criteria' => [
                         'title' => __('Comparison criteria'),
                         'required' => true,
                     ],
                     'description' => [
                         'title' => __('Description'),
                         'type' => 'textarea',
                     ],
                     'value_1' => [
                         'title' => __('Value for package :number', ['number' => 1]),
                         'helper' => __("Enter 'yes' to show a checkmark icon, 'no' to show a close icon, or any other value to display as plain text."),
                     ],
                     'value_2' => [
                         'title' => __('Value for package :number', ['number' => 2]),
                         'helper' => __("Enter 'yes' to show a checkmark icon, 'no' to show a close icon, or any other value to display as plain text."),
                     ],
                     'value_3' => [
                         'title' => __('Value for package :number', ['number' => 3]),
                         'helper' => __("Enter 'yes' to show a checkmark icon, 'no' to show a close icon, or any other value to display as plain text."),
                     ],
                 ])
        )
        ->add('bottom_description', TextareaField::class, TextareaFieldOption::make()->label(__('Bottom description')))
         ->addButtonActions(['primary' => __('Primary'), 'secondary' => __('Secondary')])
         ->add('background_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Background image')));
    });

    Shortcode::register('content-page', __('Content Page'), __('Content Page'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData([
            'action_label',
            'action_url',
            'action_icon',
        ], $shortcode);

        return Theme::partial('shortcodes.content-page.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('content-page', Theme::asset()->url('images/ui-blocks/content-page.png'));

    Shortcode::setAdminConfig('content-page', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add('main_content', EditorField::class, EditorFieldOption::make()->label(__('Main content')))
            ->addOpenFieldset('contact_section_open')
            ->add('contact_section_label', AlertField::class, AlertFieldOption::make()->content(__('Contact section')))
            ->add('contact_section_title', TextField::class, TextFieldOption::make()->label(__('Contact section title')))
            ->add('contact_section_description', TextareaField::class, TextareaFieldOption::make()->label(__('Contact section description')))
            ->add('contact_section_subtitle', TextField::class, TextFieldOption::make()->label(__('Contact section subtitle')))
            ->add('contact_section_sub_description', TextareaField::class, TextareaFieldOption::make()->label(__('Contact section sub description')))
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->fields([
                        'action_label' => [
                            'title' => __('Action label'),
                            'required' => true,
                        ],
                        'action_url' => [
                            'title' => __('Action URL'),
                            'required' => true,
                        ],
                        'action_icon' => [
                            'title' => __('Icon'),
                            'type' => 'coreIcon',
                        ],
                    ])
            )
            ->addCloseFieldset('contact_section_closed');
    });

    Shortcode::register('site-contact', __('Site Contact'), __('Site Contact'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData([
            'action_label',
            'action_url',
            'action_icon',
        ], $shortcode);

        if (! $tabs) {
            return null;
        }

        return Theme::partial('shortcodes.site-contact.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('site-contact', Theme::asset()->url('images/ui-blocks/site-contact.png'));

    Shortcode::setAdminConfig('site-contact', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->addOpenFieldset('contact_section_open')
            ->add('contact_section_label', AlertField::class, AlertFieldOption::make()->content(__('Contact items')))
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->max(2)
                    ->fields([
                        'action_label' => [
                            'title' => __('Action label'),
                            'required' => true,
                        ],
                        'action_url' => [
                            'title' => __('Action URL'),
                            'required' => true,
                        ],
                        'action_icon' => [
                            'title' => __('Icon'),
                            'type' => 'coreIcon',
                        ],
                    ])
            )
            ->addCloseFieldset('contact_section_closed')
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add('action_label', TextField::class, TextFieldOption::make()->label(__('Action label')))
            ->add('action_url', TextField::class, TextFieldOption::make()->label(__('Action URL')))
            ->add('background_color', ColorField::class, ColorFieldOption::make()->label(__('Background color')));
    });

    Shortcode::register('call-to-action', __('Call To Action'), __('Call To Action'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.call-to-action.index', compact('shortcode'));
    });

    Shortcode::setPreviewImage('call-to-action', Theme::asset()->url('images/ui-blocks/call-to-action.png'));

    Shortcode::setAdminConfig('call-to-action', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 2))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/call-to-action/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
            ->addButtonActions(['primary' => __('Primary')])
            ->add('background_color', ColorField::class, ColorFieldOption::make()->label(__('Background color')));
    });

    Shortcode::register('work-process', __('Work Process'), __('Work Process'), function (ShortcodeCompiler $shortcode) {
        $features = Shortcode::fields()->getTabsData(['title'], $shortcode);

        return Theme::partial('shortcodes.work-process.index', compact('shortcode', 'features'));
    });

    Shortcode::setPreviewImage('work-process', Theme::asset()->url('images/ui-blocks/work-process.png'));

    Shortcode::setAdminConfig('work-process', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 2))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/work-process/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->add('no', TextField::class, TextFieldOption::make()->placeholder('01')->label(__('No.')))
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Image')))
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                            'required' => true,
                        ],
                    ])
            )
            ->add('background_color', ColorField::class, ColorFieldOption::make()->label(__('Background color')));
    });

    Shortcode::register('support-tools', __('Support Tools'), __('Support Tools'), function (ShortcodeCompiler $shortcode) {
        $tools = Shortcode::fields()->getTabsData(['name', 'logo', 'description', 'action_label', 'action_url'], $shortcode);

        return Theme::partial('shortcodes.support-tools.index', compact('shortcode', 'tools'));
    });

    Shortcode::setPreviewImage('support-tools', Theme::asset()->url('images/ui-blocks/support-tools.png'));

    Shortcode::setAdminConfig('support-tools', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Subtitle')))
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->fields([
                        'name' => [
                            'title' => __('Name'),
                            'required' => true,
                        ],
                        'logo' => [
                            'title' => __('Logo'),
                            'type' => 'image',
                        ],
                        'description' => [
                            'title' => __('Description'),
                            'type' => 'textarea',
                        ],
                        'action_label' => [
                            'title' => __('Action Label'),
                        ],
                        'action_url' => [
                            'title' => __('Action URL'),
                        ],
                    ])
            );
    });
});
