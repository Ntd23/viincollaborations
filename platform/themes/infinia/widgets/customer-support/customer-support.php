<?php

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class CustomerSupportWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Customer Support Contact'),
            'description' => __('A block providing customer support contact details and trial offer.'),
            'title' => null,
            'icon_image' => null,
            'contact_title' => __('Contact Us'),
            'contact_number' => null,
            'contact_url' => null,
            'button_label' => null,
            'button_url' => null,
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
            ->add('icon_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Icon Image')))
            ->add('contact_title', TextField::class, TextFieldOption::make()->label(__('Contact Title')))
            ->add('contact_number', TextField::class, TextFieldOption::make()->label(__('Contact Number')))
            ->add('contact_url', TextField::class, TextFieldOption::make()->label(__('Contact URL')))
            ->add('button_label', TextField::class, TextFieldOption::make()->label(__('Button Label')))
            ->add('button_url', TextField::class, TextFieldOption::make()->label(__('Button URL')));
    }
}
