<?php

use Botble\Base\Forms\FieldOptions\RepeaterFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\RepeaterField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class BrochureDownloadsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Brochure Downloads'),
            'description' => __('Brochure Downloads Widget'),
        ]);
    }

    public function settingForm(): WidgetForm
    {
        $fields = [
            [
                'type' => 'text',
                'label' => __('Label'),
                'required' => true,
                'attributes' => [
                    'name' => 'label',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'type' => 'text',
                'label' => __('URL'),
                'required' => true,
                'attributes' => [
                    'name' => 'url',
                    'value' => null,
                    'options' => [
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
