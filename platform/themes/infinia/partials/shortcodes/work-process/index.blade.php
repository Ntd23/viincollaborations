@php
    $style = $shortcode->style;

    $style = in_array($style, range(1, 2)) ? $style : 1;

    $bgColor = $shortcode->background_color;
    $bgColor = $bgColor ? $bgColor === 'transparent' ? null : $bgColor : null;

    $variablesStyle = [
        "--shortcode-background-color: $bgColor !important;" => $bgColor,
    ];
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.work-process.styles.style-$style"))
