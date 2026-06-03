<section {!! $shortcode->htmlAttributes() !!} class="shortcode-projects shortcode-projects-style-4 section-team-1 position-relative fix section-padding border-bottom">
    <div class="container position-relative z-2">
        <div class="text-center">
            @if ($subtitle = $shortcode->subtitle)
                <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                    <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                    <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{!! BaseHelper::clean($subtitle) !!}</span>
                </div>
            @endif

            @if ($title = $shortcode->title)
                <h3 class="ds-3 my-3 fw-regular">{!! BaseHelper::clean($title) !!}</h3>
            @endif
        </div>

        <div class="row mt-6 align-items-stretch g-4">
            {{-- Left stat card --}}
            <div class="col-lg-5">
                <div class="card border rounded-4 h-100 overflow-hidden d-flex flex-column position-relative">

                    {{-- World map dots decorative background --}}
                    <img src="{{ Theme::asset()->url('images/shapes/vector-2.png') }}"
                         alt=""
                         class="position-absolute top-0 end-0 pe-none"
                         style="max-width: 85%; opacity: 0.18; pointer-events: none; z-index: 0;">

                    {{-- Text content --}}
                    <div class="p-4 p-lg-5 position-relative" style="z-index: 1; background: #fff;">
                        @php $dataCount = $shortcode->data_count; @endphp

                        @if ($dataCount)
                            <h2 class="count ds-2 fw-bold text-primary my-0">
                                <span class="odometer" data-count="{{ $dataCount }}"></span>
                                @if ($dataCountUnit = $shortcode->data_count_unit)
                                    {!! BaseHelper::clean($dataCountUnit) !!}
                                @endif
                            </h2>

                            @if ($dataCountLabel = $shortcode->data_count_label)
                                <h5 class="fw-bold text-900 mt-1 mb-3">{!! BaseHelper::clean($dataCountLabel) !!}</h5>
                            @endif
                        @endif

                        @if ($description = $shortcode->description)
                            <p class="fs-5 text-500 mb-0">{!! BaseHelper::clean($description) !!}</p>
                        @endif
                    </div>

                    {{-- Image area — grows to fill remaining card height, min 260px on mobile --}}
                    @if ($image = $shortcode->image)
                        <div class="position-relative flex-grow-1" style="min-height: 260px; z-index: 0;">
                            {{ RvMedia::image($image, $shortcode->title ?: __('Image'), attributes: ['class' => 'position-absolute top-0 start-0 w-100 h-100', 'style' => 'object-fit: cover; display: block;']) }}
                            {{-- Gradient fade: white at top of image → transparent --}}
                            <div class="position-absolute top-0 start-0 w-100"
                                 style="height: 100px; background: linear-gradient(to bottom, #ffffff 0%, rgba(255,255,255,0) 100%); z-index: 1; pointer-events: none;"></div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Right project list --}}
            @if ($projects->isNotEmpty())
                <div class="col-lg-7 d-flex flex-column gap-4">
                    @foreach ($projects as $project)
                        <a href="{{ $project->url }}" class="card border rounded-4 p-4 hover-up text-decoration-none text-reset d-block">
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
                                {{-- Rectangular thumbnail --}}
                                <div class="flex-shrink-0 w-100 w-sm-auto" style="height: 140px; overflow: hidden; border-radius: 0.75rem;">
                                    {{ RvMedia::image($project->image, $project->name, 'horizontal_thumb', attributes: ['class' => 'w-100 h-100', 'style' => 'object-fit: cover;']) }}
                                </div>

                                {{-- Title + description --}}
                                <div class="flex-grow-1 min-w-0">
                                    <strong class="d-block fs-6 mb-1 text-900">{{ $project->name }}</strong>
                                    @if ($projectDescription = $project->description)
                                        <p class="mb-0 fs-7 text-600 lh-base">{!! BaseHelper::clean($projectDescription) !!}</p>
                                    @endif
                                </div>

                                {{-- Sequential number (hidden on xs) --}}
                                <div class="flex-shrink-0 d-none d-sm-block ms-2">
                                    <span class="fs-1 fw-bold text-300 lh-1">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="rotate-center ellipse-rotate-success position-absolute z-1"></div>
    <div class="rotate-center-rev ellipse-rotate-primary position-absolute z-1"></div>
</section>

@once
    <style>
        .shortcode-projects-style-4::after {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            height: 1px;
            background: rgba(7, 26, 61, 0.14);
            content: "";
            pointer-events: none;
        }
    </style>
@endonce
