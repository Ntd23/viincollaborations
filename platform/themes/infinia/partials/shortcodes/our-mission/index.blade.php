@php
    $style = $shortcode->style;
    $style = in_array($style, range(1, 3)) ? $style : 1;
@endphp

{!! Theme::partial("shortcodes.our-mission.styles.style-$style", compact('shortcode', 'tabs', 'testimonials')) !!}
