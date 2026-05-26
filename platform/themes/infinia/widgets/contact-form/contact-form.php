<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Contact\Forms\Fronts\ContactForm;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class ContactFormWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Contact Form'),
            'description' => __('Contact form widget'),
        ]);
    }

    public function data(): array|Collection
    {
        $form = ContactForm::createFromArray(['display_fields' => 'email'])
            ->setFormInputWrapperClass('input-group d-flex mb-2')
            ->setFormInputClass('form-control ms-0 border rounded-2')
            ->modify(
                'submit',
                'submit',
                ['attr' => ['class' => 'btn btn-primary hover-up mt-4 w-100 d-flex align-items-center justify-content-between'], 'label' =>
                    sprintf('%s %s', Arr::get($this->getConfig(), 'button_label') ?: __('Submit'), Blade::render('<x-core::icon name="ti ti-arrow-right" />')),
                ],
                true
            );

        $backgroundColor = Arr::get($this->getConfig(), 'background_color');

        return compact('form', 'backgroundColor');
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'button_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Button label'))
            )
            ->add(
                'background_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->defaultValue('#f3f4f6')
                    ->label(__('Background color'))
            );
    }

    protected function requiredPlugins(): array
    {
        return ['contact'];
    }
}
