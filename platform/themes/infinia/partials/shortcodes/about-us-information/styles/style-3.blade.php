<section {!! $shortcode->htmlAttributes() !!} class="shortcode-about-us-information shortcode-about-us-information-style-3 section-padding fix">
    <div class="container">
        <div class="row align-items-center mb-8">
            <div class="col-lg-6 pe-lg-8">
                @if ($subtitle = $shortcode->subtitle)
                    <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2 mb-4" data-aos="zoom-in" data-aos-delay="50">
                        <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="icon">
                        <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{!! BaseHelper::clean($subtitle) !!}</span>
                    </div>
                @endif

                @if ($title = $shortcode->title)
                    <h2 class="ds-5 mb-3" data-aos="fade-up" data-aos-delay="100">{!! BaseHelper::clean($title) !!}</h2>
                    <div class="bg-primary mb-5" style="width: 48px; height: 3px; border-radius: 2px;"></div>
                @endif

                @if ($description = $shortcode->description)
                    <p class="fs-5 text-500" data-aos="fade-up" data-aos-delay="150">{!! BaseHelper::clean($description) !!}</p>
                @endif
            </div>

            @if ($image = $shortcode->image)
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                    <div class="position-relative overflow-hidden" style="max-height: 480px;">
                        {{ RvMedia::image($image, $title, attributes: ['class' => 'img-fluid rounded-4 w-100 h-100', 'style' => 'object-fit: cover; object-position: top;']) }}
                    </div>
                </div>
            @endif
        </div>

        @if(count($features) > 0)
            <div class="row g-4">
                @foreach($features as $feature)
                    @continue(! Arr::get($feature, 'title'))
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                        <div class="d-flex align-items-start gap-4 bg-white rounded-4 p-4 h-100 shadow-sm border border-1 border-light hover-up">
                            <div class="flex-shrink-0 bg-primary-soft icon-flip position-relative icon-shape icon-xl rounded-3">
                                @if(! empty($feature['icon_image']))
                                    <div class="icon">
                                        <img src="{{ RvMedia::getImageUrl($feature['icon_image']) }}" alt="icon" class="icon-image">
                                    </div>
                                @elseif(! empty($feature['icon']))
                                    <div class="icon">
                                        <x-core::icon :name="$feature['icon']" />
                                    </div>
                                @else
                                    <div class="icon">
                                        <img src="{{ Theme::asset()->url('images/icons/check.png') }}" alt="check icon">
                                    </div>
                                @endif
                            </div>
                            <div>
                                <strong class="d-block fs-6 fw-bold text-900 mb-1">{!! BaseHelper::clean($feature['title']) !!}</strong>
                                @if(! empty($feature['description']))
                                    <p class="text-500 mb-0 fs-7">{!! BaseHelper::clean(nl2br($feature['description'])) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
