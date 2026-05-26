<?php

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Faq\Models\Faq;
use Botble\Faq\Models\FaqCategory;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\ShortcodeField;
use Botble\Theme\Facades\Theme;
use Theme\Infinia\Forms\ShortcodeForm;

app()->booted(function (): void {
    if (! is_plugin_active('faq')) {
        return;
    }

    Shortcode::register('faqs', __('FAQs'), __('FAQs'), function (ShortcodeCompiler $shortcode) {
        if (empty($categoryIds = Shortcode::fields()->getIds('category_ids', $shortcode))) {
            return null;
        }

        $faqs = Faq::query()
            ->wherePublished()
            ->whereIn('category_id', $categoryIds)
            ->limit($shortcode->limit ?: 5)
            ->get();

        $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'icon', 'icon_image'], $shortcode);

        return Theme::partial('shortcodes.faqs.index', compact('shortcode', 'faqs', 'tabs'));
    });

    Shortcode::setPreviewImage('faqs', Theme::asset()->url('images/ui-blocks/faqs.png'));

    Shortcode::setAdminConfig('faqs', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->withoutAspectRatio()
                    ->numberItemsPerRow(1)
                    ->choices([
                        1 => [
                            'image' => Theme::asset()->url('images/shortcodes/faqs/style-1.png'),
                            'label' => __('Display in content'),
                        ],
                        2 => [
                            'image' => Theme::asset()->url('images/shortcodes/faqs/style-2.png'),
                            'label' => __('Style :number', ['number' => 2]),
                        ],
                        3 => [
                            'image' => Theme::asset()->url('images/shortcodes/faqs/style-3.png'),
                            'label' => __('Style :number', ['number' => 3]),
                        ],
                        4 => [
                            'image' => Theme::asset()->url('images/shortcodes/faqs/style-4.png'),
                            'label' => __('Style :number', ['number' => 4]),
                        ],
                    ])
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [2, 3, 4], $attributes['style'] ?? 1)
                    ->label(__('Title'))
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle'))
                    ->collapsible('style', [3, 4], $attributes['style'] ?? 1)
            )
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()
                    ->collapsible('style', [2, 3, 4], $attributes['style'] ?? 1)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [2, 4], $attributes['style'] ?? 1)
                    ->label(__('Image'))
            )
            ->add(
                'image_1',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [4], $attributes['style'] ?? 1)
                    ->label(__('Image :number', ['number' => 1]))
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->attrs($attributes)
                    ->collapsible('style', 2, $attributes['style'] ?? 1)
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
            ->add(
                'category_ids',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Categories'))
                    ->choices(FaqCategory::query()->pluck('name', 'id')->all())
                    ->selected(ShortcodeField::parseIds($attributes['category_ids'] ?? ''))
                    ->searchable()
                    ->multiple()
            )
            ->add('limit', NumberField::class, NumberFieldOption::make()->label(__('Limit')))
            ->addButtonActions([
                'primary' => __('Primary'),
                'secondary' => __('Secondary'),
            ], [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '4',
                'style' => in_array($attributes['style'] ?? 1, [4]) ? '' : 'display: none;',
            ])
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Background image'))
                    ->collapsible('style', [1, 2], $attributes['style'] ?? 1)
            );
    });
});
