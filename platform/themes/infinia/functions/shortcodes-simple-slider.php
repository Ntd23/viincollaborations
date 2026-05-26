<?php

use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

if (! is_plugin_active('simple-slider')) {
    return;
}

app()->booted(function (): void {
    add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
        return Theme::getThemeNamespace('partials.shortcodes.simple-slider.index');
    }, 120);

    Shortcode::setPreviewImage('simple-slider', Theme::asset()->url('images/ui-blocks/simple-slider.png'));

    Shortcode::modifyAdminConfig('simple-slider', function (ShortcodeForm $form) {
        $form
            ->add(
                'title_font_size',
                NumberField::class,
                NumberFieldOption::make()
                    ->label('Title font size (px)')
                    ->helperText(__('The font size of the title text. Default value is 64.'))
                    ->defaultValue(64)
            )
            ->add(
                'is_autoplay',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Is autoplay?'))
                    ->choices(['yes' => __('Yes'), 'no' => __('No')])
            )
            ->add(
                'autoplay_speed',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Autoplay speed (if autoplay enabled)'))
                    ->choices(
                        array_combine(
                            [2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000],
                            [2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000]
                        )
                    )
            );

        return $form;
    });
});
