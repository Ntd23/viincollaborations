<section class="widget-newsletter widget-newsletter-style-1 section-newsletter-1 pb-120 pt-120 fix position-relative">
    <div class="container position-relative fix">
        <div class="row align-items-center fix text-center border rounded-4 position-relative z-1">
            <div class="col-lg-6 my-4">
                {{ RvMedia::image($config['left_image'], Theme::getSiteTitle()) }}
            </div>
            <div class="col-lg-6 mt-lg-0 mt-5">
                <div class="px-lg-5 text-lg-start text-center">
                    @if($config['subtitle'])
                        <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                            <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                            <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{{ $config['subtitle'] }}</span>
                        </div>
                    @endif
                    @if($config['title'])
                        <h4 class="mt-3 mb-3">{{ $config['title'] }}</h4>
                    @endif
                    @if($config['description'])
                        <span class="fs-6 fw-medium">{!! BaseHelper::clean(nl2br($config['description'])) !!}</span>
                    @endif

                    {!! $form->renderForm() !!}
                </div>
            </div>
        </div>
        @if($config['background_image'])
            <div class="position-absolute top-50 start-50 translate-middle z-0">
                {{ RvMedia::image($config['background_image'], Theme::getSiteTitle()) }}
            </div>
        @endif
        <div class="bouncing-blobs-container rounded-4 fix">
            <div class="bouncing-blobs-glass rounded-4"></div>
            <div class="bouncing-blobs">
                <div class="bouncing-blob bouncing-blob--green"></div>
                <div class="bouncing-blob bouncing-blob--primary"></div>
            </div>
        </div>
    </div>
</section>
