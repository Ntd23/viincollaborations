@php
    Theme::setPageTitle("Careers");
    Theme::layout('full-width');
@endphp

<section class="section-padding shortcode-services shortcode-services-style-1">
    <div class="container">
        <div class="text-center">
            <h3 class="ds-3 my-3" data-aos="fade-zoom-in" data-aos-delay="100">{{ __('Join Our Team') }}</h3>
            <p data-aos="fade-zoom-in" data-aos-delay="50">
                {{ __('Where your career path begins') }}
            </p>
        </div>
        <div class="row mt-6 position-relative">
            @foreach($careers->split(3) as $row)
                <div class="col-lg-4">
                    @foreach($row as $career)
                        <div
                            @class([
                                'rounded-4 shadow-1 bg-white position-relative z-1 hover-up',
                                'p-2 mt-lg-8' => $loop->first && $loop->parent->first,
                                'p-2 mt-lg-8 mt-5' => $loop->first && $loop->parent->last,
                                'p-2 mt-5' => $loop->first || $loop->last,
                            ])
                            data-aos="fade-zoom-in"
                            data-aos-delay="50"
                        >
                            <div class="card-service bg-white p-6 border rounded-4">
                                @if($iconImage = $career->getMetaData('icon_image', true))
                                    {{ RvMedia::image($iconImage, 'icon') }}
                                @elseif($icon = $career->getMetaData('icon', true))
                                    <x-core::icon :name="$icon"/>
                                @endif
                                <strong class="d-block fs-6 my-3">{{ $career->name }}</strong>
                                    @if ($description = $career->description)
                                        <p class="mb-6">{!! BaseHelper::clean(nl2br($description)) !!}</p>
                                    @endif

                                <a href="{{ $career->url }}" class="rounded-pill border icon-shape d-inline-flex gap-3 icon-learn-more">
                                    <svg class="plus" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <g clip-path="url(#clip0_226_5470)">
                                            <path
                                                class="fill-dark"
                                                d="M15.375 7.375H8.625V0.625C8.625 0.279813 8.34519 0 8 0C7.65481 0 7.375 0.279813 7.375 0.625V7.375H0.625C0.279813 7.375 0 7.65481 0 8C0 8.34519 0.279813 8.625 0.625 8.625H7.375V15.375C7.375 15.7202 7.65481 16 8 16C8.34519 16 8.625 15.7202 8.625 15.375V8.625H15.375C15.7202 8.625 16 8.34519 16 8C16 7.65481 15.7202 7.375 15.375 7.375Z"
                                                fill="#111827"
                                            />
                                        </g>
                                        <defs>
                                            <clipPath>
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="10" viewBox="0 0 18 10" fill="none">
                                        <path class="fill-dark" d="M13.0633 0.0634766L12.2615 0.86529L15.8294 4.43321H0V5.56716H15.8294L12.2615 9.13505L13.0633 9.93686L18 5.00015L13.0633 0.0634766Z" fill="#111827" />
                                    </svg>
                                    <span class="fw-bold fs-7 text-900">{{ __('Learn More') }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        @if ($careers instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $careers->total() > 0)
            <div class="view-more text-center wow animated fadeIn">
                {{ $careers->withQueryString()->links(Theme::getThemeNamespace('partials.pagination')) }}
            </div>
        @endif
    </div>
</section>
