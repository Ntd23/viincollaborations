<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Contact\Forms\ShortcodeContactAdminConfigForm;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Arr;

app()->booted(function (): void {
    if (! is_plugin_active('contact')) {
        return;
    }

    add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
        return Theme::getThemeNamespace('partials.shortcodes.contact-form.index');
    });

    Shortcode::setPreviewImage('contact-form', Theme::asset()->url('images/ui-blocks/contact-form.png'));

    Shortcode::modifyAdminConfig('contact-form', function (ShortcodeContactAdminConfigForm $form) {
        $fields = [
            'title' => [
                'type' => 'text',
                'title' => __('Title'),
            ],
            'description' => [
                'type' => 'text',
                'title' => __('Description'),
            ],
            'icon' => [
                'type' => 'coreIcon',
                'title' => __('Icon'),
            ],
        ];

        foreach (range(1, 3) as $i) {
            $fields["button_label_$i"] = [
                'type' => 'text',
                'title' => __('Button label :number (only style :style)', ['number' => $i, 'style' => 2]),
            ];

            $fields["button_url_$i"] = [
                'type' => 'text',
                'title' => __('Button URL :number (only style :style)', ['number' => $i, 'style' => 2]),
            ];

            $fields["button_icon_$i"] = [
                'type' => 'coreIcon',
                'title' => __('Button Icon :number (only style :style)', ['number' => $i, 'style' => 2]),
            ];
        }

        return $form
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices(
                        collect(range(1, 3))
                            ->mapWithKeys(fn ($number) => [
                                $number => [
                                    'label' => __('Style :number', ['number' => $number]),
                                    'image' => Theme::asset()->url("images/shortcodes/contact-form/style-$number.png"),
                                ],
                            ])
                            ->toArray()
                    )
                    ->selected(Arr::get($form->getModel(), 'style', 'style-1'))
                    ->withoutAspectRatio()
                    ->numberItemsPerRow(1)
                    ->toArray()
            )
            ->add(
                'form_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Form title'))
            )
            ->add(
                'form_description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Form description'))
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
                DescriptionFieldOption::make()
            )
            ->addOpenFieldset('contact_info')
            ->add(
                'contact_info',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Contact Info'))
                    ->fields($fields)
                    ->attrs($form->getModel())
            )
            ->addCloseFieldset('contact_info')
            ->add(
                'background_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->label(__('Background color'))
            )
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Background image'))
            );
    });
});
