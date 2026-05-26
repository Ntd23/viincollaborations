@php
    $style = $shortcode->style;
    $style = in_array($style, range(1, 6)) ? $style : 1;
@endphp

{!! Theme::partial("shortcodes.teams.styles.style-$style", compact('shortcode', 'teams', 'tabs')) !!}
