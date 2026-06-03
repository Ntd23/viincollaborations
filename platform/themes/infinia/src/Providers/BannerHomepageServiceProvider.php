<?php

namespace Theme\Infinia\Providers;

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Portfolio\Models\Service;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Shortcode\ShortcodeField;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class BannerHomepageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! function_exists('add_shortcode')) {
            return;
        }

        add_shortcode(
            'banner_homepage',
            __('Banner Homepage'),
            __('Premium homepage hero banner for Vietnam business setup services.'),
            function (ShortcodeCompiler $shortcode): string {
                $defaults = [
                    'trust_text' => __('Vietnam Business Setup & Market Entry Partner'),
                    'title' => __('Expand Your Business Into Vietnam'),
                    'subtitle' => __('Business Setup, Licensing, Legal & Tax Support — Made Simple for Foreign Investors'),
                    'description' => __('We help international companies establish, operate and grow in Vietnam with trusted local guidance, regulatory support and strategic business connections.'),
                    'primary_button_text' => __('Book Free Consultation'),
                    'primary_button_url' => '/contact',
                    'secondary_button_text' => __('Explore Setup Process'),
                    'secondary_button_url' => '/services',
                    'trust_badges' => implode(PHP_EOL, [
                        __('End-to-End Setup'),
                        __('Government Liaison'),
                        __('Compliance Ready'),
                    ]),
                    'trust_badge_extra' => null,
                    'image' => null,
                ];

                $data = array_merge($defaults, array_filter([
                    'trust_text' => $shortcode->trust_text,
                    'title' => $shortcode->title,
                    'subtitle' => $shortcode->subtitle,
                    'description' => $shortcode->description,
                    'primary_button_text' => $shortcode->primary_button_text,
                    'primary_button_url' => $shortcode->primary_button_url,
                    'secondary_button_text' => $shortcode->secondary_button_text,
                    'secondary_button_url' => $shortcode->secondary_button_url,
                    'trust_badges' => $shortcode->trust_badges,
                    'trust_badge_extra' => $shortcode->trust_badge_extra,
                    'image' => $shortcode->image,
                ], fn ($value): bool => $value !== null && $value !== ''));

                $featureServiceIds = shortcode()->fields()->getIds('feature_service_ids', $shortcode);
                $serviceBadgeIds = shortcode()->fields()->getIds('service_badge_ids', $shortcode);

                $features = $this->getServices($featureServiceIds);
                $serviceBadges = $this->getServiceNames($serviceBadgeIds);
                $badges = array_values(array_filter(array_map('trim', explode(PHP_EOL, $data['trust_badges']))));
                $extraBadge = trim((string) $data['trust_badge_extra']);

                return view(
                    Theme::getThemeNamespace('partials.shortcodes.banner-homepage'),
                    compact('shortcode', 'data', 'features', 'badges', 'extraBadge', 'serviceBadges')
                )->render();
            }
        );

        shortcode()->setAdminConfig('banner_homepage', function (array $attributes): ShortcodeForm {
            $serviceChoices = $this->getServiceChoices();

            return ShortcodeForm::createFromArray($attributes)
                ->withLazyLoading()
                ->add(
                    'trust_text',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Trust text'))
                        ->defaultValue(__('Vietnam Business Setup & Market Entry Partner'))
                )
                ->add(
                    'title',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Title'))
                        ->defaultValue(__('Expand Your Business Into Vietnam'))
                )
                ->add(
                    'subtitle',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Subtitle'))
                        ->defaultValue(__('Business Setup, Licensing, Legal & Tax Support — Made Simple for Foreign Investors'))
                )
                ->add(
                    'description',
                    TextareaField::class,
                    TextareaFieldOption::make()
                        ->label(__('Description'))
                        ->rows(3)
                        ->defaultValue(__('We help international companies establish, operate and grow in Vietnam with trusted local guidance, regulatory support and strategic business connections.'))
                )
                ->add(
                    'primary_button_text',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Primary button text'))
                        ->defaultValue(__('Book Free Consultation'))
                )
                ->add(
                    'primary_button_url',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Primary button URL'))
                        ->defaultValue('/contact')
                )
                ->add(
                    'secondary_button_text',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Secondary button text'))
                        ->defaultValue(__('Explore Setup Process'))
                )
                ->add(
                    'secondary_button_url',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Secondary button URL'))
                        ->defaultValue('/services')
                )
                ->add(
                    'trust_badges',
                    TextareaField::class,
                    TextareaFieldOption::make()
                        ->label(__('Trust badges'))
                        ->rows(3)
                        ->helperText(__('Enter each badge in a new line.'))
                        ->defaultValue(implode(PHP_EOL, [
                            __('End-to-End Setup'),
                            __('Government Liaison'),
                            __('Compliance Ready'),
                        ]))
                )
                ->add(
                    'trust_badge_extra',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('Additional trust badge'))
                        ->helperText(__('Displayed beside the first floating trust badge.'))
                )
                ->add(
                    'feature_service_ids',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Feature checklist services'))
                        ->choices($serviceChoices)
                        ->multiple()
                        ->searchable()
                        ->selected(ShortcodeField::parseIds(Arr::get($attributes, 'feature_service_ids')))
                        ->helperText(__('Choose services to display as the left checklist.'))
                )
                ->add(
                    'service_badge_ids',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Visual service badges'))
                        ->choices($serviceChoices)
                        ->multiple()
                        ->searchable()
                        ->selected(ShortcodeField::parseIds(Arr::get($attributes, 'service_badge_ids')))
                        ->helperText(__('Choose services to display as circular badges in the right visual.'))
                )
                ->add(
                    'image',
                    MediaImageField::class,
                    MediaImageFieldOption::make()
                        ->label(__('Right visual image'))
                        ->helperText(__('If empty, the shortcode renders the decorative Vietnam business setup visual with HTML/CSS.'))
                );
        });
    }

    protected function getServiceChoices(): array
    {
        if (! is_plugin_active('portfolio')) {
            return [];
        }

        return Service::query()
            ->wherePublished()
            ->pluck('name', 'id')
            ->all();
    }

    protected function getServiceNames(array $serviceIds): array
    {
        if (! is_plugin_active('portfolio') || empty($serviceIds)) {
            return [];
        }

        $services = Service::query()
            ->wherePublished()
            ->whereIn('id', $serviceIds)
            ->pluck('name', 'id');

        return collect($serviceIds)
            ->map(fn ($serviceId) => $services->get((int) $serviceId))
            ->filter()
            ->values()
            ->all();
    }

    protected function getServices(array $serviceIds): array
    {
        if (! is_plugin_active('portfolio') || empty($serviceIds)) {
            return [];
        }

        $services = Service::query()
            ->wherePublished()
            ->whereIn('id', $serviceIds)
            ->with('metadata')
            ->get(['id', 'name', 'image'])
            ->keyBy('id');

        return collect($serviceIds)
            ->map(function ($serviceId) use ($services): ?array {
                $service = $services->get((int) $serviceId);

                if (! $service) {
                    return null;
                }

                return [
                    'name' => $service->name,
                    'icon' => $service->getMetaData('icon', true),
                    'icon_image' => $service->getMetaData('icon_image', true),
                    'image' => $service->image,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
