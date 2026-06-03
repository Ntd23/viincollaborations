@php
    $projectItems = $projects instanceof \Illuminate\Pagination\LengthAwarePaginator ? collect($projects->items()) : $projects;
    $projectIcons = ['bi-bank', 'bi-file-earmark-text', 'bi-people'];

    $fallbackHighlights = [
        [
            'title' => __('Strategic Guidance'),
            'description' => __('Solutions aligned with your goals and market.'),
        ],
        [
            'title' => __('Reliable Partnership'),
            'description' => __('A trusted team committed to your long-term success.'),
        ],
        [
            'title' => __('Risk Reduction'),
            'description' => __('Minimize delays and ensure compliance with confidence.'),
        ],
        [
            'title' => __('Business Growth'),
            'description' => __('Empowering your business to grow smarter and faster.'),
        ],
    ];

    $highlights = collect($tabs)
        ->map(function ($tab) {
            return [
                'title' => Arr::get($tab, 'title'),
                'description' => Arr::get($tab, 'description'),
                'icon' => Arr::get($tab, 'icon'),
                'icon_image' => Arr::get($tab, 'icon_image'),
            ];
        })
        ->filter(fn ($tab) => $tab['title'] && $tab['description'])
        ->values();

    if ($highlights->isEmpty()) {
        $highlights = collect($fallbackHighlights);
    }
@endphp

<section {!! $shortcode->htmlAttributes() !!} class="shortcode-projects shortcode-projects-style-5 section-padding bg-linear-3 position-relative fix border-bottom">
    <div class="container position-relative z-2">
        <div class="text-center mx-auto shortcode-projects-style-5__heading">
            @if ($subtitle = $shortcode->subtitle)
                <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                    <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                    <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{!! BaseHelper::clean($subtitle) !!}</span>
                </div>
            @endif

            @if ($title = $shortcode->title)
                <h3 class="ds-3 my-3 fw-bold text-900">{!! BaseHelper::clean($title) !!}</h3>
            @endif

            @if ($description = $shortcode->description)
                <p class="fs-5 text-600 mb-0">{!! BaseHelper::clean($description) !!}</p>
            @endif
        </div>

        <div class="row g-4 align-items-stretch mt-6">
            <div class="col-lg-6">
                <div class="shortcode-projects-style-5__image h-100">
                    @if ($image = $shortcode->image)
                        {{ RvMedia::image($image, $shortcode->title ?: __('Project image'), attributes: ['class' => 'w-100 h-100']) }}
                    @elseif ($projectItems->first()?->image)
                        {{ RvMedia::image($projectItems->first()->image, $projectItems->first()->name, 'horizontal_thumb', attributes: ['class' => 'w-100 h-100']) }}
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <div class="d-flex flex-column gap-4 h-100">
                    @foreach ($projectItems->take(3) as $project)
                        <a href="{{ $project->url }}" class="shortcode-projects-style-5__project d-flex align-items-center gap-4 text-decoration-none text-reset hover-up">
                            <span class="shortcode-projects-style-5__icon flex-shrink-0">
                                <i class="bi {{ $projectIcons[$loop->index % count($projectIcons)] }}"></i>
                            </span>

                            <span class="d-block flex-grow-1 min-w-0">
                                <strong class="shortcode-projects-style-5__project-title d-block mb-2 text-900">{{ $project->name }}</strong>

                                @if ($projectDescription = $project->description)
                                    <span class="shortcode-projects-style-5__project-description d-block text-600 lh-base">{!! BaseHelper::clean($projectDescription) !!}</span>
                                @endif
                            </span>

                            <span class="shortcode-projects-style-5__number flex-shrink-0">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="shortcode-projects-style-5__highlights mt-5">
            <div class="row g-0">
                @foreach ($highlights->take(4) as $highlight)
                    @php
                        $highlightIcon = Arr::get($highlight, 'icon');
                        $highlightIconImage = Arr::get($highlight, 'icon_image');
                    @endphp

                    <div class="col-sm-6 col-lg-3">
                        <div class="shortcode-projects-style-5__highlight text-center h-100">
                            @if ($highlightIconImage)
                                {{ RvMedia::image($highlightIconImage, Arr::get($highlight, 'title'), attributes: ['class' => 'shortcode-projects-style-5__highlight-icon']) }}
                            @elseif ($highlightIcon)
                                <span class="shortcode-projects-style-5__highlight-icon">
                                    <x-core::icon :name="$highlightIcon" />
                                </span>
                            @endif

                            <strong class="shortcode-projects-style-5__highlight-title d-block mt-3 mb-2 text-900">{!! BaseHelper::clean($highlight['title']) !!}</strong>
                            <p class="shortcode-projects-style-5__highlight-description text-600 mb-0">{!! BaseHelper::clean($highlight['description']) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="rotate-center ellipse-rotate-success position-absolute z-1"></div>
    <div class="rotate-center-rev ellipse-rotate-primary position-absolute z-1"></div>
</section>

@once
    <style>
        .shortcode-projects-style-5 {
            --project-style-5-blue: #315fda;
            --project-style-5-ink: #071a3d;
            --project-style-5-border: rgba(7, 26, 61, 0.1);
        }

        .shortcode-projects-style-5::after {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            height: 1px;
            background: rgba(7, 26, 61, 0.14);
            content: "";
            pointer-events: none;
        }

        .shortcode-projects-style-5__heading {
            max-width: 760px;
        }

        .shortcode-projects-style-5__image {
            min-height: 420px;
            overflow: hidden;
            border-radius: 18px;
            background: #f3f6fb;
        }

        .shortcode-projects-style-5__image img {
            display: block;
            object-fit: cover;
        }

        .shortcode-projects-style-5__project {
            min-height: 132px;
            padding: 24px 28px;
            border: 1px solid var(--project-style-5-border);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 16px 40px rgba(7, 26, 61, 0.04);
        }

        .shortcode-projects-style-5__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(49, 95, 218, 0.1);
            color: var(--project-style-5-blue);
            font-size: 36px;
        }

        .shortcode-projects-style-5__project-title {
            font-size: 20px;
            line-height: 1.25;
        }

        .shortcode-projects-style-5__project-description {
            font-size: 16px;
        }

        .shortcode-projects-style-5__number {
            color: #a8b1c2;
            font-size: 38px;
            font-weight: 800;
            line-height: 1;
        }

        .shortcode-projects-style-5__highlights {
            overflow: hidden;
            border-radius: 18px;
            background: linear-gradient(180deg, #f9fbff 0%, #eef4ff 100%);
            box-shadow: 0 16px 40px rgba(7, 26, 61, 0.04);
        }

        .shortcode-projects-style-5__highlight {
            padding: 26px 28px;
        }

        .shortcode-projects-style-5__highlight-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            color: var(--project-style-5-blue);
        }

        .shortcode-projects-style-5__highlight-icon svg,
        img.shortcode-projects-style-5__highlight-icon {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .shortcode-projects-style-5__highlight-title {
            font-size: 18px;
            line-height: 1.25;
        }

        .shortcode-projects-style-5__highlight-description {
            font-size: 15px;
            line-height: 1.45;
        }

        .shortcode-projects-style-5__highlight p {
            max-width: 190px;
            margin-right: auto;
            margin-left: auto;
        }

        .shortcode-projects-style-5__highlights .row > [class*="col-"]:not(:last-child) .shortcode-projects-style-5__highlight {
            border-right: 1px solid rgba(49, 95, 218, 0.16);
        }

        @media (max-width: 991.98px) {
            .shortcode-projects-style-5__image {
                min-height: 340px;
            }

            .shortcode-projects-style-5__highlights .row > [class*="col-"]:nth-child(2n) .shortcode-projects-style-5__highlight {
                border-right: 0;
            }
        }

        @media (max-width: 575.98px) {
            .shortcode-projects-style-5__project {
                align-items: flex-start !important;
                padding: 22px;
            }

            .shortcode-projects-style-5__number {
                display: none;
            }

            .shortcode-projects-style-5__highlights .row > [class*="col-"] .shortcode-projects-style-5__highlight {
                border-right: 0;
                border-bottom: 1px solid rgba(49, 95, 218, 0.16);
            }

            .shortcode-projects-style-5__highlights .row > [class*="col-"]:last-child .shortcode-projects-style-5__highlight {
                border-bottom: 0;
            }
        }
    </style>
@endonce
