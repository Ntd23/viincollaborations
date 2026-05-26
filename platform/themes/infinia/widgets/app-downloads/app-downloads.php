<?php

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\RepeaterFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\RepeaterField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class AppDownloadsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('App Downloads'),
            'description' => __('Display app download links'),
        ]);
    }

    protected function settingForm(): string|null|WidgetForm
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()
            )
            ->add(
                'platforms',
                RepeaterField::class,
                RepeaterFieldOption::make()
                    ->fields([
                        [
                            'type' => 'text',
                            'label' => __('Name'),
                            'attributes' => [
                                'name' => 'name',
                                'value' => null,
                                'options' => [
                                    'class' => 'form-control',
                                ],
                            ],
                        ],
                        [
                            'type' => 'mediaImage',
                            'label' => __('Image'),
                            'attributes' => [
                                'name' => 'image',
                                'value' => null,
                                'options' => [
                                    'class' => 'form-control',
                                ],
                            ],
                        ],
                        [
                            'type' => 'text',
                            'label' => __('URL'),
                            'attributes' => [
                                'name' => 'url',
                                'value' => null,
                                'options' => [
                                    'class' => 'form-control',
                                ],
                            ],
                        ],
                    ])
            );
    }
}
