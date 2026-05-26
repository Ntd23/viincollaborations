<?php

use Botble\Base\Forms\FieldOptions\RepeaterFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\RepeaterField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class FeaturesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Features'),
            'description' => __('Features widget'),
        ]);
    }

    public function settingForm(): WidgetForm|null|string
    {
        $fields = [
            [
                'type' => 'text',
                'label' => __('Title'),
                'required' => true,
                'attributes' => [
                    'name' => 'title',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'type' => 'textarea',
                'label' => __('Description'),
                'required' => true,
                'attributes' => [
                    'name' => 'description',
                    'value' => null,
                    'options' => [
                        'rows' => 3,
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'type' => 'coreIcon',
                'label' => __('Icon'),
                'required' => true,
                'attributes' => [
                    'name' => 'icon',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'type' => 'mediaImage',
                'label' => __('Icon Image (It will override icon above if set)'),
                'required' => true,
                'attributes' => [
                    'name' => 'icon_image',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
        ];

        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'items',
                RepeaterField::class,
                RepeaterFieldOption::make()
                    ->fields($fields)
                    ->label(__('Items'))
            );
    }
}
