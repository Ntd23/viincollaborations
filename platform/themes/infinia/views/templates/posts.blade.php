@php
    $style = $shortcode->style;
    $style = in_array($style, range(1, 5)) ? $style : 1;

    $bgColor = $shortcode->background_color;

    $bgColor = $bgColor === 'transparent' ? null : $bgColor;

    $variablesStyle = [
        "--shortcode-background-color: $bgColor !important;" => $bgColor,
    ];
@endphp

@include(Theme::getThemeNamespace("views.templates.post-styles.style-$style"))
