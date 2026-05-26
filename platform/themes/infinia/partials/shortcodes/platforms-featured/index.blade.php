@php
    $style = $shortcode->style;

    $style = in_array($style, range(1, 2)) ? $style : 1;
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.platforms-featured.styles.style-$style"))
