<?php

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\ShortcodeField;
use Botble\Team\Models\Team;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Arr;
use Theme\Infinia\Forms\ShortcodeForm;

app()->booted(function (): void {
    if (! is_plugin_active('team')) {
        return;
    }

    Shortcode::register('teams', __('Teams'), __('Teams'), function (ShortcodeCompiler $shortcode): ?string {
        if (empty($teamIds = Shortcode::fields()->getIds('team_ids', $shortcode))) {
            return null;
        }

        $tabs = [];

        if ($shortcode->style == 5) {
            $tabs = Shortcode::fields()->getTabsData(['title', 'subtitle', 'url', 'icon', 'icon_image'], $shortcode);
        }

        $teams = Team::query()
            ->whereIn('id', $teamIds)
            ->wherePublished()
            ->with('slugable')
            ->get();

        return Theme::partial('shortcodes.teams.index', compact('shortcode', 'teams', 'tabs'));
    });

    Shortcode::setPreviewImage('teams', Theme::asset()->url('images/ui-blocks/teams.png'));

    Shortcode::setAdminConfig('teams', function (array $attributes): ShortcodeForm {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices(
                        collect(range(1, 6))
                            ->mapWithKeys(fn ($number) => [
                                $number => [
                                    'label' => __('Style :number', ['number' => $number]),
                                    'image' => Theme::asset()->url("images/shortcodes/teams/style-$number.png"),
                                ],
                            ])
                            ->toArray()
                    )
                    ->selected(Arr::get($attributes, 'style', 'style-1'))
                    ->withoutAspectRatio()
                    ->numberItemsPerRow(1)
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
                TextareaFieldOption::make()
                    ->label(__('Description'))
            )
            ->add(
                'bottom_description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Bottom description'))
                    ->collapsible('style', 3, $attributes['style'] ?? 1)
            )
            ->addButtonActions(wrapperAttributes: [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => '[name=style]',
                'data-bb-value' => '3',
                'style' => ($attributes['style'] ?? 1) == 3 ? '' : 'display: none;',
            ])
            ->add(
                'team_ids',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Teams'))
                    ->searchable()
                    ->multiple()
                    ->selected(ShortcodeField::parseIds($attributes['team_ids'] ?? ''))
                    ->choices(
                        Team::query()
                            ->wherePublished()
                            ->pluck('name', 'id')
                            ->all()
                    )
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->collapsible('style', 5, $attributes['style'] ?? 1)
                    ->fields([
                        'title' => [
                            'title' => __('Title'),
                        ],
                        'subtitle' => [
                            'title' => __('Subtitle'),
                        ],
                        'url' => [
                            'title' => __('URL'),
                        ],
                        'icon' => [
                            'title' => __('Icon'),
                            'type' => 'coreIcon',
                        ],
                        'icon_image' => [
                            'title' => __('Icon Image (It will override icon above if set)'),
                            'type' => 'image',
                        ],
                    ])
                    ->attrs($attributes)
                    ->label(__('Tabs'))
            )
            ->add(
                'background_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Background image'))
            );
    });
});
