<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

app()->booted(function (): void {
    if (! is_plugin_active('blog')) {
        return;
    }

    Shortcode::setPreviewImage('blog-posts', Theme::asset()->url('images/ui-blocks/blog-posts.png'));

    Shortcode::modifyAdminConfig('blog-posts', function (ShortcodeForm $form) {
        $attributes = $form->getModel();

        return $form
            ->addBefore(
                'title',
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices(
                        collect(range(1, 5))->mapWithKeys(function ($i) {
                            return [
                                $i => [
                                    'label' => __('Style :i', ['i' => $i]),
                                    'image' => Theme::asset()->url("images/shortcodes/blog-posts/style-$i.png"),
                                ],
                            ];
                        })->all()
                    )
            )
            ->addBefore(
                'paginate',
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->addAfter(
                'title',
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle')),
            )
            ->addAfter(
                'subtitle',
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Description'))
            )
            ->add(
                'action_label',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [1, 3, 4, 5], $attributes['style'] ?? 1)
                    ->label(__('Action label'))
            )
            ->add(
                'action_url',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', [1, 3, 4, 5], $attributes['style'] ?? 1)
                    ->label(__('Action URL'))
            )
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', [3, 4], $attributes['style'] ?? 1)
                    ->label(__('Background image'))
            )
            ->add(
                'background_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->label(__('Background color'))
            );
    });
});
