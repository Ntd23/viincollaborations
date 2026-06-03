<section class="shortcode-blog-posts shortcode-blog-posts-style-1 section-blog-1 section-padding container-fluid mt-6 mt-lg-0 position-relative overflow-hidden"
    @style($variablesStyle)
>
    <div class="container">
        <div class="row mb-6">
            <div class="col-12">
                @if($shortcode->subtitle)
                    <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                        <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                        <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{!! BaseHelper::clean($shortcode->subtitle) !!}</span>
                    </div>
                @endif

                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3 my-3">
                    @if($shortcode->title)
                        <h3 class="ds-5 mb-0" data-aos="fade-zoom-in" data-aos-delay="50">{!! BaseHelper::clean($shortcode->title) !!}</h3>
                    @endif

                    @if($shortcode->action_label)
                        <a href="{{ $shortcode->action_url }}" class="d-none d-md-inline-flex align-items-center fw-bold text-primary">
                            {{ $shortcode->action_label }}
                            <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="24" height="14" viewBox="0 0 24 14" fill="none">
                                <path class="fill-dark" d="M17.4177 0.417969L16.3487 1.48705L21.1059 6.24429H0V7.75621H21.1059L16.3487 12.5134L17.4177 13.5825L24 7.0002L17.4177 0.417969Z" fill="black" />
                            </svg>
                        </a>
                    @endif
                </div>

                @if($shortcode->description)
                    <span class="fs-5 fw-medium" data-aos="fade-zoom-in" data-aos-delay="100">
                        {!! BaseHelper::clean(nl2br($shortcode->description)) !!}
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            @foreach($posts as $post)
                <div class="col-lg-4 text-start">
                    @include(Theme::getThemeNamespace('views.templates.partials.post-item'))
                </div>
            @endforeach

            @if($shortcode->action_label)
                <div class="col-12 d-md-none text-end mt-4">
                    <a href="{{ $shortcode->action_url }}" class="d-inline-flex align-items-center fw-bold text-primary">
                        {{ $shortcode->action_label }}
                        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="24" height="14" viewBox="0 0 24 14" fill="none">
                            <path class="fill-dark" d="M17.4177 0.417969L16.3487 1.48705L21.1059 6.24429H0V7.75621H21.1059L16.3487 12.5134L17.4177 13.5825L24 7.0002L17.4177 0.417969Z" fill="black" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
