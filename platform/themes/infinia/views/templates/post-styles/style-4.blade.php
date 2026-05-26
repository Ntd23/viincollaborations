<section class="shortcode-blog-posts shortcode-blog-posts-style-4 section-blog-3 position-relative section-padding fix"
    @style($variablesStyle)
>
    <div class="container position-relative z-1">
        <div class="row align-items-end mb-5">
            <div class="col-md-auto col-12 me-auto">
                @if ($subtitle = $shortcode->subtitle)
                    <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                        <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                        <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{!! BaseHelper::clean($subtitle) !!}</span>
                    </div>
                @endif

                @if ($title = $shortcode->title)
                    <h3 class="ds-3 mt-3 mb-3">{!! BaseHelper::clean($title) !!}</h3>
                @endif

                @if ($description = $shortcode->description)
                    <span class="fs-5 fw-medium">{!! BaseHelper::clean($description) !!}</span>
                @endif
            </div>

            @if(($actionLabel = $shortcode->action_label) && ($actionUrl = $shortcode->action_url))
                <div class="col-md-auto col-12 pt-md-0 pt-3">
                    <a href="{{ $actionUrl }}" class="ms-md-5 fw-bold text-primary">{!! BaseHelper::clean($actionLabel) !!}
                        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="24" height="14" viewBox="0 0 24 14" fill="none">
                            <path class="fill-dark" d="M17.4177 0.417969L16.3487 1.48705L21.1059 6.24429H0V7.75621H21.1059L16.3487 12.5134L17.4177 13.5825L24 7.0002L17.4177 0.417969Z" fill="black" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
        <div class="row">
            @php
                $postsChunk = $posts->chunk(ceil($posts->count() / 2));
            @endphp
            @foreach($postsChunk as $posts)
                <div class="col-lg-6 pe-lg-8">
                    @foreach($posts as $post)
                        <a href="{{ $post->url }}" class="d-flex flex-md-row flex-column align-items-center mb-4 hover-up">
                            {{ RvMedia::image($post->image, $post->name, 'thumb', attributes: ['class' => 'rounded-3 w-100 w-md-auto']) }}

                            <div class="content ms-5 mt-md-0 mt-3">
                                <strong class="d-block fs-6 mb-2">{{ $post->name }}</strong>
                                @if ($postDescription = $post->description)
                                    <p class="truncate-3-custom">{!! BaseHelper::clean($postDescription) !!}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    @if ($backgroundImage = $shortcode->background_image)
        <div class="position-absolute top-0 start-50 translate-middle-x z-0">
            {{ RvMedia::image($backgroundImage) }}
        </div>
    @endif

    <div class="bouncing-blobs-container">
        <div class="bouncing-blobs-glass"></div>
        <div class="bouncing-blobs">
            <div class="bouncing-blob bouncing-blob--green"></div>
            <div class="bouncing-blob bouncing-blob--primary"></div>
        </div>
    </div>
</section>
