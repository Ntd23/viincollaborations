@php
    $style = $shortcode->style;

    $style = in_array($style, range(1, 2)) ? $style : 1;
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.call-to-action.styles.style-$style"))
