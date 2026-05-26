@php
    $displayBlogTopSidebar ??= true;
    $blogListStyle = request()->input('style') ?: theme_option('blog_list_style', 'style-1');
    $blogListStyle = in_array($blogListStyle, ['style-1', 'style-2']) ? $blogListStyle : 'style-1';
@endphp

@if($displayBlogTopSidebar)
    {!! dynamic_sidebar('blog_top_sidebar') !!}
@endif

{!! apply_filters('ads_render', null, 'post_list_before', ['class' => 'my-2 text-center']) !!}

<section class="section-blog-7 border-bottom">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h3 class="ds-3 mt-3 mb-3">{{ SeoHelper::getTitle() }}</h3>
                <span class="fs-5 fw-medium">{{ SeoHelper::getDescription() }}</span>
            </div>
        </div>

        {!! Theme::partial("blogs.styles.$blogListStyle", compact('posts')) !!}
    </div>
</section>

{!! apply_filters('ads_render', null, 'post_list_after', ['class' => 'my-2 text-center']) !!}
