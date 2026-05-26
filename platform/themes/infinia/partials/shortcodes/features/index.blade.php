@php
    $style = $shortcode->style;

    $style = in_array($style, range(1, 10)) ? $style : 1;
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.features.styles.style-$style"))
