@php
    $serviceSidebar = dynamic_sidebar('service_sidebar');
    $style = request()->query('style') ?: theme_option('service_style', 'style-1');
    $style = in_array($style, ['style-1', 'style-2']) ? $style : 'style-1';
@endphp

{!! apply_filters('ads_render', null, 'service_before', ['class' => 'my-2 text-center']) !!}

@include(Theme::getThemeNamespace('views.portfolio.service-styles.' . $style))

{!! apply_filters('ads_render', null, 'service_after', ['class' => 'my-2 text-center']) !!}
