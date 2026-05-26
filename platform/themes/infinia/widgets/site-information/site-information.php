<?php

use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class SiteInformationWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Site information'),
            'description' => __('Widget display site information'),
            'show_logo' => true,
            'logo_height' => 35,
            'about' => null,
            'show_social_links' => true,
            'logo' => null,
            'logo_dark' => null,
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'show_logo',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(__('Show logo'))
                    ->helperText(__('Toggle to display or hide the logo on your site.'))
            )
            ->add(
                'logo',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('show_logo', 1, $this->getConfig('show_logo') ?? true)
                    ->label(__('Logo'))
                    ->helperText(__('Leave empty to use the default logo.'))
            )
            ->add(
                'logo_dark',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('show_logo', 1, $this->getConfig('show_logo') ?? true)
                    ->label(__('Logo dark'))
                    ->helperText(__('Leave empty to use the default logo.'))
            )
            ->add(
                'logo_height',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(__('Logo height (default: 35px)'))
                    ->defaultValue(35)
            )
            ->add(
                'about',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('About'))
            )
            ->add(
                'show_social_links',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(__('Show social links'))
                    ->helperText(
                        __(
                            'Toggle to display or hide social links on your site. Configure the links in Theme Options -> Social Links.'
                        )
                    )
            );
    }
}
