@php
    $style = $shortcode->style;

    $style = in_array($style, range(1, 4)) ? $style : 1;

    $bgColor = $shortcode->background_color;

    $variablesStyle = [
        "--shortcode-background-color: $bgColor !important;" => $bgColor,
    ];
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.partners.styles.style-$style"))
