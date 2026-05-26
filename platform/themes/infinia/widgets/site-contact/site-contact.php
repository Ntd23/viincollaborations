<?php

use Botble\Base\Forms\FieldOptions\RepeaterFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\RepeaterField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Theme\Facades\Theme;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class SiteContactWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Site contact'),
            'description' => __('Display site contact information'),
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->selected($this->getConfig()['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->choices([
                        1 => [
                            'label' => __('Style :i', ['i' => 1]),
                            'image' => Theme::asset()->url('images/widgets/site-contact/style-1.png'),
                        ],
                        2 => [
                            'label' => __('Style :i', ['i' => 2]),
                            'image' => Theme::asset()->url('images/widgets/site-contact/style-2.png'),
                        ],
                    ]),
            )
            ->add(
                'items',
                RepeaterField::class,
                RepeaterFieldOption::make()
                ->fields([
                    [
                        'type' => 'text',
                        'label' => __('Action label'),
                        'attributes' => [
                            'name' => 'action_label',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'type' => 'text',
                        'label' => __('Action URL'),
                        'attributes' => [
                            'name' => 'action_url',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'type' => 'coreIcon',
                        'label' => __('Action Icon'),
                        'attributes' => [
                            'name' => 'action_icon',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                ])
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->collapsible('style', 1, $this->getConfig()['style'] ?? 1)
                    ->label(__('Description')),
            )
            ->add(
                'action_label',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', 1, $this->getConfig()['style'] ?? 1)
                    ->label(__('Action label')),
            )
            ->add(
                'action_url',
                TextField::class,
                TextFieldOption::make()
                    ->collapsible('style', 1, $this->getConfig()['style'] ?? 1)
                    ->label(__('Action URL')),
            );
    }
}
