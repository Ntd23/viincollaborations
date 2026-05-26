@php
    $style = $shortcode->style;

    $style = in_array($style, range(1, 2)) ? $style : 1;
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.instruction-steps.styles.style-$style"))
