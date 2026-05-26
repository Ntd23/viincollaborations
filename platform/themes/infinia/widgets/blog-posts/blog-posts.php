<?php

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Blog\Models\Category;
use Botble\Theme\Facades\Theme;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class BlogPostsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Blog Posts'),
            'description' => __('Choose type and categories for posts in widget'),
        ]);
    }

    public function settingForm(): WidgetForm|string|null
    {
        $categories = Category::query()->wherePublished()->pluck('name', 'id')->all();

        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->label(__('Style'))
                    ->defaultValue($attributes['style'] ?? 1)
                    ->numberItemsPerRow(1)
                    ->withoutAspectRatio()
                    ->choices([
                        1 => [
                            'label' => __('Style :i', ['i' => 1]),
                            'image' => Theme::asset()->url('images/shortcodes/blog-posts/style-4.png'),
                        ],
                        2 => [
                            'label' => __('Style :i', ['i' => 2]),
                            'image' => Theme::asset()->url('images/shortcodes/blog-posts/style-5.png'),
                        ],
                    ]),
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subtitle'))
            )
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()->label(__('Description'))
            )
            ->add(
                'category_ids',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Categories'))
                    ->choices($categories)
                    ->multiple()
            )
            ->add(
                'limit',
                NumberField::class,
                TextFieldOption::make()
                ->label(__('Limit'))
                ->defaultValue(4)
            )
            ->add('action_label', TextField::class, TextFieldOption::make()->label(__('Action Label')))
            ->add('action_url', TextField::class, TextFieldOption::make()->label(__('Action URL')));
    }

    protected function requiredPlugins(): array
    {
        return ['blog'];
    }
}
