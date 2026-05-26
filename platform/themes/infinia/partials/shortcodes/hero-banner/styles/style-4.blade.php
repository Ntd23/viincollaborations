<section {!! $shortcode->htmlAttributes() !!} class="shortcode-hero-banner shortcode-hero-banner-style-4 hero-banner position-relative overflow-hidden section-padding">
    <style>
        /* === HEAD: Desktop — flex, tất cả 1 dòng === */
        .shortcode-hero-banner-style-4 .hero-s4-head {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
        }
        .shortcode-hero-banner-style-4 .hero-s4-head .hero-s4-logo {
            height: 46px !important;
            width: auto;
            display: block;
            flex-shrink: 0;
        }
        .shortcode-hero-banner-style-4 .hero-s4-title-main,
        .shortcode-hero-banner-style-4 .hero-s4-title-sub {
            font-size: 46px !important;
            font-weight: 700 !important;
            line-height: 1.25 !important;
            flex-shrink: 1;
            margin: 0;
        }
        @media (max-width: 991px) {
            .shortcode-hero-banner-style-4 .hero-s4-head .hero-s4-logo { height: 36px !important; }
            .shortcode-hero-banner-style-4 .hero-s4-title-main,
            .shortcode-hero-banner-style-4 .hero-s4-title-sub { font-size: 36px !important; }
        }
        @media (max-width: 768px) {
            .shortcode-hero-banner-style-4 .hero-s4-head .hero-s4-logo { height: 24px !important; }
            .shortcode-hero-banner-style-4 .hero-s4-title-main,
            .shortcode-hero-banner-style-4 .hero-s4-title-sub { font-size: 24px !important; }
        }

        /* === HEAD: Mobile — grid, logo+title-main dòng 1 / title-sub dòng 2 full width === */
        @media (max-width: 576px) {
            .shortcode-hero-banner-style-4 .hero-s4-head {
                display: grid !important;
                grid-template-columns: auto 1fr;
                column-gap: 0.5rem;
                row-gap: 0.1rem;
                align-items: center;
            }
            .shortcode-hero-banner-style-4 .hero-s4-head .hero-s4-logo {
                grid-column: 1;
                grid-row: 1;
                height: 22px !important;
                align-self: center;
            }
            .shortcode-hero-banner-style-4 .hero-s4-title-main {
                grid-column: 2;
                grid-row: 1;
                font-size: 22px !important;
            }
            .shortcode-hero-banner-style-4 .hero-s4-title-sub {
                grid-column: 1 / 3;
                grid-row: 2;
                font-size: 22px !important;
            }
        }

        /* === Section titles === */
        .shortcode-hero-banner-style-4 .hero-s4-section-title {
            font-size: var(--tc-fs-4, 24px);
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        .shortcode-hero-banner-style-4 .hero-s4-section2-bar {
            width: 3rem;
            height: 3px;
            background: var(--primary-color, #6342EC);
            border-radius: 2px;
            margin-bottom: 1rem;
        }
        .shortcode-hero-banner-style-4 .hero-s4-right img {
            width: 100%;
            height: auto;
            border-radius: 1.25rem;
            display: block;
        }
    </style>

    <div class="container">

        {{-- Hàng 1: Logo + Tiêu đề (full width) --}}
        @if($shortcode->logo_image || $shortcode->title)
            @php
                $titleFull = $shortcode->title ?? '';
                $hasSplit  = str_contains($titleFull, '|');
                $titleMain = $hasSplit ? explode('|', $titleFull, 2)[0] : $titleFull;
                $titleSub  = $hasSplit ? trim(explode('|', $titleFull, 2)[1]) : '';
            @endphp
            <div class="hero-s4-head" data-aos="fade-zoom-in" data-aos-delay="0">
                @if($shortcode->logo_image)
                    {{ RvMedia::image($shortcode->logo_image, __('Logo'), attributes: ['class' => 'hero-s4-logo']) }}
                @endif
                @if($titleMain)
                    <span class="hero-s4-title-main">{!! BaseHelper::clean($titleMain) !!}</span>
                @endif
                @if($titleSub)
                    <span class="hero-s4-title-sub">{!! BaseHelper::clean($titleSub) !!}</span>
                @endif
            </div>
        @endif

        {{-- Hàng 2: Nội dung (trái) + Ảnh (phải) --}}
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-lg-0 mb-5">
                <div class="pe-lg-3">

                    @if($shortcode->subtitle)
                        <p class="fw-bold mb-4" data-aos="fade-zoom-in" data-aos-delay="30">
                            {!! BaseHelper::clean($shortcode->subtitle) !!}
                        </p>
                    @endif

                    @if($shortcode->section_1_title || $shortcode->section_1_content)
                        <div class="mb-4" data-aos="fade-zoom-in" data-aos-delay="50">
                            @if($shortcode->section_1_title)
                                <p class="hero-s4-section-title">{!! BaseHelper::clean($shortcode->section_1_title) !!}</p>
                            @endif
                            @if($shortcode->section_1_content)
                                <p class="text-700 mb-0">{!! BaseHelper::clean($shortcode->section_1_content) !!}</p>
                            @endif
                        </div>
                    @endif

                    @if($shortcode->section_2_title || $shortcode->section_2_content)
                        <div class="mb-5" data-aos="fade-zoom-in" data-aos-delay="100">
                            @if($shortcode->section_2_title)
                                <p class="hero-s4-section-title">{!! BaseHelper::clean($shortcode->section_2_title) !!}</p>
                                <div class="hero-s4-section2-bar"></div>
                            @endif
                            @if($shortcode->section_2_content)
                                <p class="text-700 mb-0">{!! BaseHelper::clean($shortcode->section_2_content) !!}</p>
                            @endif
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-3" data-aos="fade-zoom-in" data-aos-delay="150">
                        @if($shortcode->primary_action_label)
                            <a href="{{ $shortcode->primary_action_url }}" class="btn btn-gradient">
                                {{ $shortcode->primary_action_label }}
                                @if($shortcode->primary_action_icon)
                                    <x-core::icon :name="$shortcode->primary_action_icon" />
                                @endif
                            </a>
                        @endif
                        @if($shortcode->secondary_action_label)
                            <a href="{{ $shortcode->secondary_action_url }}" class="btn btn-outline-secondary hover-up">
                                @if($shortcode->secondary_action_icon)
                                    <x-core::icon :name="$shortcode->secondary_action_icon" />
                                @endif
                                {{ $shortcode->secondary_action_label }}
                            </a>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Ảnh bên phải --}}
            <div class="col-lg-6">
                @if($shortcode->main_image)
                    <div class="hero-s4-right" data-aos="zoom-in" data-aos-delay="100">
                        {{ RvMedia::image($shortcode->main_image, __('Image')) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>
