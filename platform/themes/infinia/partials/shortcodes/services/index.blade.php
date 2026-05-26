@php
    $style = $shortcode->style;
    $style = in_array($style, range(1, 6)) ? $style : 1;

    $bgColor = $shortcode->background_color;
    $bgColor = $bgColor ? $bgColor === 'transparent' ? null : $bgColor : null;

    $variablesStyle = [
        "--shortcode-background-color: $bgColor !important;" => $bgColor,
    ];
@endphp

{!! Theme::partial("shortcodes.services.styles.style-$style", compact('shortcode', 'services', 'variablesStyle')) !!}
