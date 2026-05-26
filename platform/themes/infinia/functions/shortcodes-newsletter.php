<?php

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Newsletter\Forms\Fronts\NewsletterForm;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

app()->booted(function (): void {
    if (! is_plugin_active('newsletter')) {
        return;
    }

    Shortcode::register('newsletter', __('Newsletter'), __('Newsletter'), function (ShortcodeCompiler $shortcode): ?string {
        $form = NewsletterForm::create();

        return Theme::partial('shortcodes.newsletter.index', compact('shortcode', 'form'));
    });

    Shortcode::setPreviewImage('newsletter', Theme::asset()->url('images/ui-blocks/newsletter.png'));

    Shortcode::setAdminConfig('newsletter', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
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
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add('button_label', TextField::class, TextFieldOption::make()->label(__('Button label')))
            ->add('image', MediaImageField::class);
    });
});
