<?php

use Botble\Base\Forms\FieldOptions\ButtonFieldOption;
use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\EmailFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\EmailField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Newsletter\Forms\Fronts\NewsletterForm;
use Botble\Theme\Facades\Theme;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;
use Illuminate\Support\Collection;

class NewsletterWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Newsletter form'),
            'description' => __('Display Newsletter form on sidebar'),
            'title' => null,
            'subtitle' => null,
            'left_image' => null,
            'background_image' => null,
        ]);
    }

    protected function data(): array|Collection
    {
        $form = NewsletterForm::create()
            ->remove(['wrapper_before', 'wrapper_after'])
            ->modify(
                'email',
                EmailField::class,
                EmailFieldOption::make()
                    ->label(false)
                    ->cssClass('ps-5 py-3 form-control bg-neutral-100 rounded-start-pill border-2 border-end-0 border-white'),
            )
            ->addBefore(
                'email',
                'open_wrapper',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content('<div class="input-group mb-3 mt-4 position-relative">')
            )
            ->addAfter(
                'submit',
                'close_wrapper',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content('</div>')
            )
            ->addBefore(
                'submit',
                'open_submit_wrapper',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content('<div class="bg-neutral-100 border-2 border border-start-0 border-white rounded-end-pill">')
            )
            ->modify(
                'submit',
                'submit',
                ButtonFieldOption::make()
                    ->label(__('Join Now'))
                    ->cssClass('btn btn-gradient px-3 py-3 m-3 fs-7 fw-bold border-0 rounded-pill')
            )
            ->addAfter(
                'submit',
                'close_submit_wrapper',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content('</div>')
            );

        return compact('form');
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
                            'image' => Theme::asset()->url('images/widgets/newsletter/style-1.png'),
                        ],
                        2 => [
                            'label' => __('Style :i', ['i' => 2]),
                            'image' => Theme::asset()->url('images/widgets/newsletter/style-2.png'),
                        ],
                        3 => [
                            'label' => __('Style :i', ['i' => 2]),
                            'image' => Theme::asset()->url('images/widgets/newsletter/style-3.png'),
                        ],
                    ]),
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title')),
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle')),
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Description')),
            )
            ->add(
                'left_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->collapsible('style', 1, $this->getConfig()['style'] ?? 1)
                    ->label(__('Left image')),
            )
            ->add(
                'background_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->collapsible('style', 2, $this->getConfig()['style'] ?? 1)
                    ->label(__('Background color')),
            )
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Background image')),
            );
    }

    protected function requiredPlugins(): array
    {
        return ['newsletter'];
    }
}
