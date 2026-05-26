<?php

use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class HeaderControlsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Header Controls'),
            'description' => __('Essential header controls for quick navigation and access.'),
            'show_search_button' => true,
            'show_theme_switcher' => true,
            'action_label' => null,
            'action_url' => null,
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'show_search_button',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Show Search Button')),
            )
            ->add(
                'show_theme_switcher',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Show Theme Switcher'))
                    ->helperText(__('Allow users to switch between light and dark themes.')),
            )
            ->add(
                'action_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Action Label'))
            )
            ->add(
                'action_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Action URL'))
            );
    }
}
