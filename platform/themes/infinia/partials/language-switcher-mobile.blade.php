@if (is_plugin_active('language'))
    @php
        $supportedLocales = Language::getSupportedLocales();

        if (empty($options)) {
            $options = [
                'before' => '',
                'lang_flag' => true,
                'lang_name' => true,
                'class' => '',
                'after' => '',
            ];
        }
    @endphp

    @if ($supportedLocales && count($supportedLocales) > 1)
        @php
            $languageDisplay = setting('language_display', 'all');
            $showRelated = setting('language_show_default_item_if_current_version_not_existed', true);
        @endphp

        <div class="fs-7">{{ __('Language') }}</div>
        @if (setting('language_switcher_display', 'dropdown') === 'dropdown')
            <ul class="mobile-menu font-heading ps-0 mt-1">
                <li class="has-children">
                    <span class="menu-expand"><i class="bi-chevron-down"></i></span>
                    <a href="#">
                        @if (Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag'))
                            {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()) !!}
                        @endif
                        @if (Arr::get($options, 'lang_name', true) && ($languageDisplay == 'all' || $languageDisplay == 'name'))
                            {{ Language::getCurrentLocaleName() }}
                        @endif
                    </a>

                    <ul class="sub-menu">
                        @foreach ($supportedLocales as $localeCode => $properties)
                            @if ($localeCode != Language::getCurrentLocale())
                                <li>
                                    <a class="text-sm-medium" href="{{ $showRelated ? Language::getLocalizedURL($localeCode) : url($localeCode) }}">
                                        @if (Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag'))
                                            {!! language_flag($properties['lang_flag']) !!} <span class="ms-2">{{ $properties['lang_name'] }}</span>
                                        @endif
                                        @if (Arr::get($options, 'lang_name', true) &&  ($languageDisplay == 'name'))
                                            &nbsp;{{ $properties['lang_name'] }}
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        @else
            <div class="d-flex flex-column gap-2 mt-3">
                @foreach ($supportedLocales as $localeCode => $properties)
                    @continue($localeCode === Language::getCurrentLocale())

                    <a
                        href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}"
                        class="text-decoration-none small"
                    >
                        @if (Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag'))
                            {!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}
                        @endif
                        @if (Arr::get($options, 'lang_name', true) && ($languageDisplay == 'all' || $languageDisplay == 'name'))
                            {{ $properties['lang_name'] }}
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    @endif
@endif
