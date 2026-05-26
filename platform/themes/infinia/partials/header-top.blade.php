@php
    $headerLayout = theme_option('header_layout', 'container');
    $headerLayout = in_array($headerLayout, ['container', 'full-width']) ? $headerLayout : 'container';
    $headerTopStartSidebar = dynamic_sidebar('header_top_start_sidebar');
    $headerTopEndSidebar = dynamic_sidebar('header_top_end_sidebar');
    $bgColor = theme_option('header_top_background_color', '#f5eeff');
    $textColor = theme_option('header_top_text_color', '#000000');
@endphp

<div class="top-bar header-top position-relative z-4"
    @style([
        "--header-top-background-color: $bgColor" => $bgColor,
        "--header-top-text-color: $textColor" => $textColor,
    ])
>
    <div class="bg-primary-soft">
        <div @class(['py-2', 'container' => $headerLayout == 'container', 'container-fluid px-md-8 px-2' => $headerLayout == 'full-width'])>
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center">
                @if ($headerTopStartSidebar)
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        {!! $headerTopStartSidebar !!}
                    </div>
                @endif

                <div class="d-flex d-none d-lg-flex align-items-center justify-content-center justify-content-lg-end">
                    {!! $headerTopEndSidebar !!}

                    {!! Theme::partial('language-switcher') !!}
                </div>
            </div>
        </div>
    </div>
</div>
