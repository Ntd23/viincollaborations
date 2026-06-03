@php
    $sliderId = 'business-setup-slider-' . uniqid();
@endphp

<section {!! $shortcode->htmlAttributes() !!} id="{{ $sliderId }}" class="business-setup-slider section-padding">
    <div class="container">
        @if ($shortcode->title || $shortcode->subtitle || $shortcode->description)
            <div class="business-setup-slider__heading text-center mx-auto">
                @if ($subtitle = $shortcode->subtitle)
                    <span class="business-setup-slider__eyebrow">{!! BaseHelper::clean($subtitle) !!}</span>
                @endif

                @if ($title = $shortcode->title)
                    <h2>{!! BaseHelper::clean($title) !!}</h2>
                @endif

                @if ($description = $shortcode->description)
                    <p>{!! BaseHelper::clean(nl2br($description)) !!}</p>
                @endif
            </div>
        @endif

        <div class="business-setup-slider__shell">
            <div class="swiper business-setup-slider__swiper">
                <div class="swiper-wrapper">
                    @foreach ($slides as $slide)
                        @php
                            $problems = array_values(array_filter(array_map('trim', explode("\n", $slide['problem'] ?? ''))));
                            $solutions = array_values(array_filter(array_map('trim', explode("\n", $slide['solution'] ?? ''))));
                            $ctaLabel = $slide['cta_label'] ?? __('Start Your Business Setup');
                            $ctaUrl = $slide['cta_url'] ?? null;
                            $graphicIdea = $slide['graphic_idea'] ?? null;
                        @endphp

                        <div class="swiper-slide">
                            <div class="business-setup-slider__card">
                                <div class="business-setup-slider__grid">
                                    <div class="business-setup-slider__panel business-setup-slider__panel--problem">
                                        <span class="business-setup-slider__label business-setup-slider__label--problem">
                                            <x-core::icon name="ti ti-alert-triangle" />
                                            {{ __('Problem') }}
                                        </span>

                                        @if ($headline = ($slide['headline'] ?? null))
                                            <h3>{!! BaseHelper::clean($headline) !!}</h3>
                                        @endif

                                        @if ($subHeadline = ($slide['sub_headline'] ?? null))
                                            <strong>{!! BaseHelper::clean($subHeadline) !!}</strong>
                                        @endif

                                        @if ($description = ($slide['description'] ?? null))
                                            <p>{!! BaseHelper::clean($description) !!}</p>
                                        @endif

                                        @if ($problems)
                                            <ul class="business-setup-slider__list business-setup-slider__list--problem">
                                                @foreach ($problems as $problem)
                                                    <li>
                                                        <x-core::icon name="ti ti-x" />
                                                        <span>{!! BaseHelper::clean($problem) !!}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>

                                    <div class="business-setup-slider__morph" aria-hidden="true">
                                        <div class="business-setup-slider__morph-card business-setup-slider__morph-card--chaos">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="business-setup-slider__morph-arrow">
                                            <x-core::icon name="ti ti-arrow-right" />
                                        </div>
                                        <div class="business-setup-slider__morph-card business-setup-slider__morph-card--clean">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>

                                        @if ($graphicIdea)
                                            <small>{!! BaseHelper::clean($graphicIdea) !!}</small>
                                        @endif
                                    </div>

                                    <div class="business-setup-slider__panel business-setup-slider__panel--solution">
                                        <span class="business-setup-slider__label business-setup-slider__label--solution">
                                            <x-core::icon name="ti ti-circle-check" />
                                            {{ __('Solution') }}
                                        </span>

                                        @if ($solutionTitle = ($slide['solution_title'] ?? null))
                                            <h3>{!! BaseHelper::clean($solutionTitle) !!}</h3>
                                        @endif

                                        @if ($solutions)
                                            <ul class="business-setup-slider__list business-setup-slider__list--solution">
                                                @foreach ($solutions as $solution)
                                                    <li>
                                                        <x-core::icon name="ti ti-check" />
                                                        <span>{!! BaseHelper::clean($solution) !!}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                @if ($ctaUrl)
                                    <div class="business-setup-slider__footer">
                                        <a href="{{ $ctaUrl }}" class="business-setup-slider__cta">
                                            <span>{!! BaseHelper::clean($ctaLabel) !!}</span>
                                            <x-core::icon name="ti ti-arrow-up-right" />
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button class="business-setup-slider__nav business-setup-slider__nav--prev" type="button" aria-label="{{ __('Previous') }}">
                <x-core::icon name="ti ti-arrow-left" />
            </button>
            <button class="business-setup-slider__nav business-setup-slider__nav--next" type="button" aria-label="{{ __('Next') }}">
                <x-core::icon name="ti ti-arrow-right" />
            </button>

            <div class="business-setup-slider__pagination"></div>
        </div>
    </div>
</section>

@once
    <style>
        .business-setup-slider {
            background:
                radial-gradient(circle at 10% 8%, rgba(239, 68, 68, 0.09), transparent 25%),
                radial-gradient(circle at 92% 12%, rgba(16, 185, 129, 0.13), transparent 28%),
                linear-gradient(135deg, #f8fafc 0%, #eef2ff 48%, #f7fbf9 100%);
            overflow: hidden;
        }

        .business-setup-slider__heading {
            max-width: 880px;
            margin-bottom: 42px;
        }

        .business-setup-slider__heading h2 {
            color: #172033;
            font-weight: 850;
            margin: 14px 0;
        }

        .business-setup-slider__heading p {
            color: #5f6b7a;
            font-size: 18px;
            margin: 0;
        }

        .business-setup-slider__eyebrow {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.72);
            box-shadow: 8px 8px 22px rgba(148, 163, 184, 0.24), -8px -8px 22px rgba(255, 255, 255, 0.95);
            color: var(--primary-color);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .04em;
            padding: 10px 18px;
            text-transform: uppercase;
        }

        .business-setup-slider__shell {
            position: relative;
            border-radius: 34px;
            padding: 18px;
            background: rgba(255, 255, 255, 0.58);
            box-shadow: 24px 24px 70px rgba(30, 41, 59, 0.14), -18px -18px 50px rgba(255, 255, 255, 0.9);
        }

        .business-setup-slider__card {
            border: 1px solid rgba(255, 255, 255, 0.74);
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.94), rgba(243, 247, 255, 0.76));
            box-shadow: inset 1px 1px 0 rgba(255, 255, 255, 0.9), 0 22px 46px rgba(15, 23, 42, 0.12);
            padding: clamp(18px, 3vw, 34px);
        }

        .business-setup-slider__grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(210px, 0.62fr) minmax(0, 1fr);
            gap: 18px;
            align-items: stretch;
        }

        .business-setup-slider__panel {
            display: flex;
            flex-direction: column;
            min-height: 440px;
            border-radius: 26px;
            padding: clamp(22px, 3vw, 36px);
            box-shadow: inset 12px 12px 30px rgba(148, 163, 184, 0.12), inset -14px -14px 30px rgba(255, 255, 255, 0.86);
        }

        .business-setup-slider__panel--problem {
            background:
                radial-gradient(circle at 0 0, rgba(239, 68, 68, 0.12), transparent 36%),
                linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(255, 244, 244, 0.82));
        }

        .business-setup-slider__panel--solution {
            background:
                radial-gradient(circle at 100% 0, rgba(16, 185, 129, 0.16), transparent 36%),
                linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(238, 253, 246, 0.86));
        }

        .business-setup-slider__label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            align-self: flex-start;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 6px 8px 18px rgba(148, 163, 184, 0.18), -6px -6px 18px rgba(255, 255, 255, 0.92);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 22px;
            padding: 9px 15px;
            text-transform: uppercase;
        }

        .business-setup-slider__label svg {
            height: 16px;
            width: 16px;
        }

        .business-setup-slider__label--problem {
            color: #dc2626;
        }

        .business-setup-slider__label--solution {
            color: #059669;
        }

        .business-setup-slider__panel h3 {
            color: #111827;
            font-size: clamp(26px, 2.7vw, 40px);
            font-weight: 850;
            margin-bottom: 14px;
        }

        .business-setup-slider__panel strong {
            color: #ea580c;
            display: block;
            font-size: 18px;
            margin-bottom: 14px;
        }

        .business-setup-slider__panel p {
            color: #475569;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .business-setup-slider__list {
            display: grid;
            gap: 12px;
            list-style: none;
            margin: auto 0 0;
            padding: 0;
        }

        .business-setup-slider__list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.66);
            box-shadow: 5px 7px 16px rgba(148, 163, 184, 0.14), -5px -5px 16px rgba(255, 255, 255, 0.82);
            color: #1f2937;
            font-weight: 700;
            padding: 12px 14px;
        }

        .business-setup-slider__list svg {
            flex: 0 0 auto;
            height: 18px;
            margin-top: 2px;
            width: 18px;
        }

        .business-setup-slider__list--problem svg {
            color: #ef4444;
        }

        .business-setup-slider__list--solution svg {
            color: #10b981;
        }

        .business-setup-slider__morph {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 440px;
            border-radius: 26px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.64), rgba(255, 255, 255, 0.34)),
                radial-gradient(circle at 50% 44%, rgba(var(--primary-color-rgb), 0.12), transparent 44%);
            overflow: hidden;
            padding: 22px;
        }

        .business-setup-slider__morph::before {
            position: absolute;
            inset: 28px;
            border: 1px dashed rgba(100, 116, 139, 0.25);
            border-radius: 24px;
            content: "";
        }

        .business-setup-slider__morph-card {
            position: relative;
            z-index: 1;
            width: min(150px, 70%);
            border-radius: 22px;
            background: #fff;
            box-shadow: 10px 14px 28px rgba(30, 41, 59, 0.14), -8px -8px 24px rgba(255, 255, 255, 0.92);
            padding: 18px;
        }

        .business-setup-slider__morph-card span {
            display: block;
            height: 10px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .business-setup-slider__morph-card span:last-child {
            margin-bottom: 0;
            width: 62%;
        }

        .business-setup-slider__morph-card--chaos {
            transform: rotate(-6deg) translateY(6px);
            animation: businessSetupChaos 4.5s ease-in-out infinite;
        }

        .business-setup-slider__morph-card--chaos span {
            background: linear-gradient(90deg, #fb7185, #f97316);
        }

        .business-setup-slider__morph-card--clean {
            transform: rotate(4deg) translateY(-6px);
            animation: businessSetupClean 4.5s ease-in-out infinite;
        }

        .business-setup-slider__morph-card--clean span {
            background: linear-gradient(90deg, #10b981, #22c55e);
        }

        .business-setup-slider__morph-arrow {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #172033;
            box-shadow: 10px 14px 28px rgba(23, 32, 51, 0.22);
            color: #fff;
            margin: 16px 0;
        }

        .business-setup-slider__morph-arrow svg {
            height: 24px;
            width: 24px;
        }

        .business-setup-slider__morph small {
            position: relative;
            z-index: 1;
            color: #64748b;
            display: block;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.5;
            margin-top: 18px;
            max-width: 190px;
            text-align: center;
        }

        .business-setup-slider__footer {
            display: flex;
            justify-content: center;
            margin-top: 22px;
        }

        .business-setup-slider__cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border-radius: 999px;
            background: #172033;
            box-shadow: 10px 14px 26px rgba(23, 32, 51, 0.22);
            color: #fff;
            font-weight: 850;
            padding: 15px 24px;
        }

        .business-setup-slider__cta:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .business-setup-slider__cta svg {
            height: 18px;
            width: 18px;
        }

        .business-setup-slider__nav {
            position: absolute;
            top: 50%;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.86);
            box-shadow: 8px 10px 24px rgba(30, 41, 59, 0.16), -6px -6px 20px rgba(255, 255, 255, 0.92);
            color: #172033;
            transform: translateY(-50%);
        }

        .business-setup-slider__nav--prev {
            left: -8px;
        }

        .business-setup-slider__nav--next {
            right: -8px;
        }

        .business-setup-slider__pagination {
            display: flex;
            justify-content: center;
            margin-top: 22px;
        }

        .business-setup-slider__pagination .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: #94a3b8;
            opacity: 1;
        }

        .business-setup-slider__pagination .swiper-pagination-bullet-active {
            width: 30px;
            border-radius: 999px;
            background: var(--primary-color);
        }

        @keyframes businessSetupChaos {
            0%, 100% {
                transform: rotate(-7deg) translateY(8px);
            }
            50% {
                transform: rotate(-2deg) translateY(0);
            }
        }

        @keyframes businessSetupClean {
            0%, 100% {
                transform: rotate(4deg) translateY(-6px);
            }
            50% {
                transform: rotate(0) translateY(0);
            }
        }

        @media (max-width: 1199px) {
            .business-setup-slider__grid {
                grid-template-columns: 1fr;
            }

            .business-setup-slider__panel,
            .business-setup-slider__morph {
                min-height: auto;
            }

            .business-setup-slider__morph {
                min-height: 260px;
            }

            .business-setup-slider__morph-arrow svg {
                transform: rotate(90deg);
            }
        }

        @media (max-width: 575px) {
            .business-setup-slider__shell {
                border-radius: 22px;
                padding: 10px;
            }

            .business-setup-slider__card,
            .business-setup-slider__panel,
            .business-setup-slider__morph {
                border-radius: 20px;
            }

            .business-setup-slider__nav {
                display: none;
            }
        }
    </style>
@endonce

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper === 'undefined') {
            return;
        }

        new Swiper('#{{ $sliderId }} .business-setup-slider__swiper', {
            loop: {{ count($slides) > 1 ? 'true' : 'false' }},
            speed: 650,
            slidesPerView: 1,
            spaceBetween: 24,
            autoplay: {
                delay: 5800,
                disableOnInteraction: false,
            },
            pagination: {
                el: '#{{ $sliderId }} .business-setup-slider__pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '#{{ $sliderId }} .business-setup-slider__nav--next',
                prevEl: '#{{ $sliderId }} .business-setup-slider__nav--prev',
            },
        });
    });
</script>
