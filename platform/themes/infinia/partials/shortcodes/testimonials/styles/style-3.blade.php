@php
    $avatars = $testimonials->pluck('name', 'image')->all();
    $avatarChunks = $avatars ? array_chunk($avatars, max(1, ceil(count($avatars) / 2)), true) : [];
    $hasMultipleTestimonials = $testimonials->count() > 1;
@endphp

<section {!! $shortcode->htmlAttributes() !!} class="shortcode-testimonials shortcode-testimonials-style-3 section-testimonial-4 section-padding position-relative overflow-hidden border-bottom">
    <div class="container position-relative z-1">
        <div class="text-center">
            @if ($subtitle = $shortcode->subtitle)
                <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                    <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                    <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{!! BaseHelper::clean($subtitle) !!}</span>
                </div>
            @endif

            @if ($title = $shortcode->title)
                <h5 class="ds-5 my-3">{!! BaseHelper::clean($title) !!}</h5>
            @endif

            @if ($description = $shortcode->description)
                <p class="fs-5">{!! BaseHelper::clean($description) !!}</p>
            @endif
        </div>

        @if($avatarChunks)
            @foreach($avatarChunks as $avatars)
                <div @class(['row justify-content-center', 'd-none d-lg-flex' => $loop->last, 'mt-8' => $loop->first])>
                    @foreach($avatars as $avatar => $name)
                        @continue(! $avatar)
                        <div class="avatar-xxl rounded-circle" title="{{ $name }}">
                            {{ RvMedia::image($avatar, $name, 'thumb', attributes: ['class' => 'assessor rounded-circle border border-5 border-primary-soft']) }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif

        @if ($testimonials->isNotEmpty())
            <div class="row mt-6">
                <div class="col-lg-6 mx-auto text-center">
                    <div
                        class="swiper slider-two pt-2 pb-3"
                        @if ($hasMultipleTestimonials) data-loop="true" data-autoplay="true" @endif
                    >
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <div class="px-lg-6">
                                        <div class="testimonial-style-3__author">
                                            @if ($testimonial->image)
                                                {{ RvMedia::image($testimonial->image, $testimonial->name, 'thumb', attributes: ['class' => 'testimonial-style-3__author-image']) }}
                                            @endif

                                            <div class="testimonial-style-3__author-content">
                                                <strong class="d-block fs-6 mb-0">{{ $testimonial->name }}</strong>
                                                <div class="flag">
                                                    @if ($company = $testimonial->company)
                                                        <span class="fs-8">{{ $company }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if ($content = $testimonial->content)
                                            <p class="text-900 mt-5">{!! BaseHelper::clean($content) !!}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($hasMultipleTestimonials)
                            <div class="swiper-pagination slider-two-swiper-pagination"></div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if($shortcode->background_image)
        <div class="position-absolute top-0 start-50 translate-middle-x z-0">
            {{ RvMedia::image($shortcode->background_image, __('Image')) }}
        </div>
    @endif
    <div class="rotate-center ellipse-rotate-success position-absolute z-0"></div>
    <div class="rotate-center-rev ellipse-rotate-primary position-absolute z-0"></div>
</section>

@once
    <style>
        .shortcode-testimonials-style-3::after {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            height: 1px;
            background: rgba(7, 26, 61, 0.14);
            content: "";
            pointer-events: none;
        }

        .shortcode-testimonials-style-3 .testimonial-style-3__author {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            max-width: 100%;
            text-align: start;
        }

        .shortcode-testimonials-style-3 .testimonial-style-3__author-image {
            flex: 0 0 auto;
            width: 72px;
            height: 72px;
            border: 5px solid rgba(13, 110, 253, 0.12);
            border-radius: 50%;
            object-fit: cover;
        }

        .shortcode-testimonials-style-3 .testimonial-style-3__author-content {
            min-width: 0;
        }

        @media (max-width: 575px) {
            .shortcode-testimonials-style-3 .testimonial-style-3__author {
                display: flex;
                text-align: start;
            }
        }
    </style>
@endonce
