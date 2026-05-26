{!! apply_filters('ads_render', null, 'post_before', ['class' => 'my-2 text-center']) !!}

<section>
    <div class="container mt-10">
        <div class="row">
            <div class="col-md-8 mx-auto">
                @if($post->categories->isNotEmpty())
                    <div class="d-flex gap-2">
                        @foreach($post->categories as $category)
                            <a href="{{ $category->url }}" class="bg-primary-soft rounded-pill px-3 fw-bold py-2 text-primary fs-7">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                <h5 class="ds-5 mt-3 mb-4">{!! BaseHelper::clean($post->name) !!}</h5>
                @if($post->description)
                    <p class="fs-5 text-900 mb-0">
                        {!! BaseHelper::clean($post->description) !!}
                    </p>
                @endif
                <div class="d-flex align-items-center justify-content-between mt-7 py-3 border-top border-bottom">
                    <div class="d-flex align-items-center position-relative z-1">
                        @if($post->author)
                            <div class="icon-shape rounded-circle border border-2 border-white">
                                {{ RvMedia::image($post->author->avatar_url, $post->author->name, attributes: ['class' => 'rounded-circle', 'style' => 'width: 40px; height: 40px;']) }}
                            </div>
                        @endif
                        <div class="ms-3">
                            <h6 class="fs-7 m-0">{{ $post->author->name }}</h6>
                            <p class="mb-0 fs-8">{{ Theme::formatDate($post->created_at) }}</p>
                        </div>
                        <a href="{{ $post->url }}" title="{{ $post->name }}" class="position-absolute bottom-0 start-0 end-0 top-0 z-0"></a>
                    </div>
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 19.25C16.0041 19.25 19.25 16.0041 19.25 12C19.25 7.99594 16.0041 4.75 12 4.75C7.99594 4.75 4.75 7.99594 4.75 12C4.75 16.0041 7.99594 19.25 12 19.25Z" stroke="#111827" stroke-width="1.5" />
                            <path d="M12 8V12L14 14" stroke="#111827" stroke-width="1.5" />
                        </svg>
                        <span class="ms-2 fs-7 text-900">{{ __(':time mins to read', ['time' => $post->time_reading]) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-10 mx-auto my-7">
                {{ RvMedia::image($post->image, $post->name, attributes: ['class' => 'rounded-4 w-100']) }}
            </div>
            <div class="col-md-8 mx-auto">
                <div class="ck-content">
                    {!! BaseHelper::clean($post->content) !!}
                </div>
            </div>
            <div class="col-md-8 mx-auto mb-5 py-3">
                @if ($post->tags->isNotEmpty())
                    <div class="d-flex align-items-center mt-5">
                        <p class="fw-bold text-500 mb-0 me-2">{{ __('Tags:') }}</p>
                        @foreach($post->tags as $tag)
                            <a href="{{ $tag->url }}" class="bg-primary-soft rounded-pill px-3 fw-bold py-2 text-primary fs-7 me-1">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="d-flex align-items-center mt-5">
                    <p class="fw-bold text-500 mb-0 me-2">{{ __('Share this post:') }}</p>
                    {!! Theme::renderSocialSharing($post->url, SeoHelper::getDescription(), $post->image) !!}
                </div>
                {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $post) !!}
            </div>
        </div>
    </div>
</section>

@php
    $relatedPosts = get_related_posts($post->getKey(), 3);
@endphp

@if($relatedPosts->isNotEmpty())
    <section class="section-blog-8 section-padding pb-0 position-relative fix">
        <div class="container position-relative z-1">
            <div class="row text-center">
                <h5 class="ds-5">{{ __('Related Posts') }}</h5>
            </div>
            <div class="row">
                @foreach($relatedPosts as $post)
                    <div class="col-lg-4 text-start">
                        @include(Theme::getThemeNamespace('views.templates.partials.post-item'))
                    </div>
                @endforeach
            </div>
        </div>
        <div class="rotate-center ellipse-rotate-success position-absolute z-0"></div>
        <div class="rotate-center-rev ellipse-rotate-primary position-absolute z-0"></div>
    </section>
@endif

{!! apply_filters('ads_render', null, 'post_after', ['class' => 'my-2 text-center']) !!}
