@php
    $teamSidebar = dynamic_sidebar('team_sidebar');
    $style = request()->query('style') ?: theme_option('team_style', 'style-1');
    $style = in_array($style, ['style-1', 'style-2']) ? $style : 'style-1';
@endphp

{!! apply_filters('ads_render', null, 'team_before', ['class' => 'my-2 text-center']) !!}

@include(Theme::getThemeNamespace('views.teams.team-styles.' . $style))

{!! apply_filters('ads_render', null, 'team_after', ['class' => 'my-2 text-center']) !!}
