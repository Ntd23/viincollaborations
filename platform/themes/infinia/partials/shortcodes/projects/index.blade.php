@php
    $style = $shortcode->style;
    $style = in_array($style, range(1, 4)) ? $style : 1;
@endphp

{!! Theme::partial("shortcodes.projects.styles.style-$style", compact('shortcode', 'projects', 'tabs')) !!}
