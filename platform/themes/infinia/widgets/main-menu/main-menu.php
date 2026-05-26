<?php

use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class MainMenuWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Main Menu'),
            'description' => __('Display the main menu.'),
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'description',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content(__('Go to :link to manage menus.', [
                        'link' => Html::link(route('menus.index'), __('Menus')),
                    ]))
            );
    }
}
