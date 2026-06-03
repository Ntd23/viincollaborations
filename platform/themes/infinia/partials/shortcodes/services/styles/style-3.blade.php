<section {!! $shortcode->htmlAttributes() !!} class="shortcode-services shortcode-services-style-3 section-feature-12 border-bottom pb-120 pt-110"
    @style($variablesStyle)
>
    <div class="container">
        <div class="text-center">
            @if ($title = $shortcode->title)
                <h5 class="ds-5">{!! BaseHelper::clean($title) !!}</h5>
            @endif

            @if ($description = $shortcode->description)
                <p class="fs-5 pb-4">{!! BaseHelper::clean($description) !!}</p>
            @endif
        </div>
        <div class="row">
            @foreach($services as $service)
                @php
                    $serviceImage = $service->image ? RvMedia::getImageUrl($service->image) : null;
                @endphp

                <div class="col-lg-4">
                    <div
                        class="feature-item mb-5 p-5 rounded-4 hover-up position-relative overflow-hidden bg-neutral-900 text-white d-flex flex-column"
                        @style([
                            "background-image: linear-gradient(180deg, rgba(17, 24, 39, 0.48), rgba(17, 24, 39, 0.88)), url('$serviceImage');" => $serviceImage,
                            'background-image: linear-gradient(180deg, rgba(17, 24, 39, 0.82), rgba(17, 24, 39, 0.96));' => ! $serviceImage,
                            'background-position: center;' => true,
                            'background-repeat: no-repeat;' => true,
                            'background-size: cover;' => true,
                            'min-height: 320px;' => true,
                        ])
                    >
                        <div class="position-relative z-1 mt-auto">
                            <h4 class="text-white">{{ $service->name }}</h4>

                            @if ($serviceDescription = $service->description)
                                <p class="truncate-3-custom text-white opacity-75">
                                    {!! BaseHelper::clean($serviceDescription) !!}
                                </p>

                            @endif

                            <a href="{{ $service->url }}" class="text-white fs-7 fw-bold" title="{{ $service->name }}">
                                {{ __('Learn More') }}
                                <svg class=" ms-2 " xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                                    <g clip-path="url(#clip0_399_9647)">
                                        <path class="fill-white" d="M13.5633 4.06348L12.7615 4.86529L16.3294 8.43321H0.5V9.56716H16.3294L12.7615 13.135L13.5633 13.9369L18.5 9.00015L13.5633 4.06348Z" fill="#ffffff"></path>
                                    </g>
                                    <defs>
                                        <clipPath>
                                            <rect width="18" height="18" fill="white" transform="translate(0.5)"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
