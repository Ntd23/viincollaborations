@php
    $backgroundColor = Arr::get($config, 'background_color', '#6d4df2');
    $backgroundColor = $backgroundColor === 'transparent' ? null : $backgroundColor;
    $backgroundImage = Arr::get($config, 'background_image');
    $backgroundImage = $backgroundImage ? RvMedia::getImageUrl($backgroundImage) : null;
    $backgroundImage = $backgroundImage ? "url($backgroundImage)" : null;
@endphp

<section class="widget-newsletter widget-newsletter-style-2 section-newsletter-2 section-padding bg-primary position-relative"
    @style([
        "--widget-background-color: $backgroundColor !important;" => $backgroundColor,
        "--widget-background-image: $backgroundImage !important;" => $backgroundImage,
    ])
>
    <div class="container position-relative fix">
        <div class="row align-items-center text-center position-relative z-1">
            <div class="col-lg-6 mx-auto">
                <div class="px-lg-3 text-center">
                    @if ($subtitle = Arr::get($config, 'subtitle'))
                        <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                            <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                            <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{!! BaseHelper::clean($subtitle) !!}</span>
                        </div>
                    @endif

                    @if ($title = Arr::get($config, 'title'))
                        <h4 class="my-5 text-white">{!! BaseHelper::clean($title) !!}</h4>
                    @endif

                    @if ($description = Arr::get($config, 'description'))
                        <p class="fs-6 fw-medium text-white">{!! BaseHelper::clean(nl2br($description)) !!}</p>
                    @endif

                    {!! $form->renderForm() !!}
                </div>
            </div>
        </div>
    </div>
</section>
