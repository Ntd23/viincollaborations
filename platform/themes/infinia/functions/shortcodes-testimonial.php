<?php

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\ShortcodeField;
use Botble\Testimonial\Models\Testimonial;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Arr;
use Theme\Infinia\Forms\ShortcodeForm;

app()->booted(function (): void {
    if (! is_plugin_active('testimonial')) {
        return;
    }

    Shortcode::register('testimonials', __('Testimonials'), __('Testimonials'), function (ShortcodeCompiler $shortcode) {
        if (empty($testimonialIds = Shortcode::fields()->getIds('testimonial_ids', $shortcode))) {
            return null;
        }

        $testimonials = Testimonial::query()
            ->wherePublished()
            ->whereIn('id', $testimonialIds)
            ->get();

        if ($testimonials->isEmpty()) {
            return null;
        }

        return Theme::partial('shortcodes.testimonials.index', compact('shortcode', 'testimonials'));
    });

    Shortcode::setPreviewImage('testimonials', Theme::asset()->url('images/ui-blocks/testimonials.png'));

    Shortcode::setAdminConfig('testimonials', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->withoutAspectRatio()
                    ->numberItemsPerRow(1)
                    ->choices(
                        collect(range(1, 4))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/testimonials/style-$i.png"),
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
            )
            ->add(
                'testimonial_ids',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Testimonials'))
                    ->choices(
                        Testimonial::query()
                            ->wherePublished()
                            ->select(['id', 'name', 'company'])
                            ->get()
                            ->mapWithKeys(fn (Testimonial $item) => [$item->getKey() => trim(sprintf('%s - %s', $item->name, $item->company), ' - ')]) // @phpstan-ignore-line
                            ->all()
                    )
                    ->multiple()
                    ->searchable()
                    ->selected(ShortcodeField::parseIds(Arr::get($attributes, 'testimonial_ids')))
            )
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Background image'))
                    ->collapsible('style', [1, 3, 4], ($attributes['style'] ?? 1))
            )
            ->addButtonActions(
                [
                    'primary' => __('Primary'),
                    'secondary' => __('Secondary'),
                ],
                [
                    'data-bb-collapse' => 'true',
                    'data-bb-trigger' => '[name=style]',
                    'data-bb-value' => '[1, 2, 3]',
                    'style' => in_array($attributes['style'] ?? 1, [1, 2, 3]) ? '' : 'display: none;',
                ]
            );
    });
});
