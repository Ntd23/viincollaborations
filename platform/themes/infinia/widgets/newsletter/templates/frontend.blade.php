@php
    $style = in_array(Arr::get($config, 'style'), range(1, 3)) ? Arr::get($config, 'style') : 1;
@endphp

@include(Theme::getThemeNamespace("widgets.newsletter.templates.styles.style-$style"))
