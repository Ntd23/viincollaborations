<section {!! $shortcode->htmlAttributes() !!} class="banner-homepage-shortcode">
    <div class="container">
        <div class="banner-homepage">
            <div class="banner-homepage__glow banner-homepage__glow--blue"></div>
            <div class="banner-homepage__glow banner-homepage__glow--gold"></div>

            <div class="banner-homepage__content">
                @if ($data['trust_text'])
                    <div class="banner-homepage__trust">
                        <x-core::icon name="ti ti-shield-check" />
                        <span>{!! BaseHelper::clean($data['trust_text']) !!}</span>
                    </div>
                @endif

                @if ($data['subtitle'])
                    <h2>{!! BaseHelper::clean($data['subtitle']) !!}</h2>
                @endif

                                @if ($data['title'])
                    <h1>{!! BaseHelper::clean($data['title']) !!}</h1>
                @endif

                @if ($data['description'])
                    <p>{!! BaseHelper::clean($data['description']) !!}</p>
                @endif

                @if ($features)
                    <ul class="banner-homepage__features">
                        @foreach ($features as $feature)
                            <li>
                                @if ($feature['icon_image'])
                                    {{ RvMedia::image($feature['icon_image'], $feature['name'], 'thumb', attributes: ['class' => 'banner-homepage__feature-icon']) }}
                                @elseif ($feature['icon'])
                                    <x-core::icon :name="$feature['icon']" class="banner-homepage__feature-icon" />
                                @elseif ($feature['image'])
                                    {{ RvMedia::image($feature['image'], $feature['name'], 'thumb', attributes: ['class' => 'banner-homepage__feature-icon']) }}
                                @endif
                                <span>{{ $feature['name'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="banner-homepage__actions">
                    @if ($data['primary_button_text'] && $data['primary_button_url'])
                        <a href="{{ $data['primary_button_url'] }}" class="banner-homepage__btn banner-homepage__btn--primary">
                            <span>{!! BaseHelper::clean($data['primary_button_text']) !!}</span>
                            <x-core::icon name="ti ti-arrow-up-right" />
                        </a>
                    @endif

                    @if ($data['secondary_button_text'] && $data['secondary_button_url'])
                        <a href="{{ $data['secondary_button_url'] }}" class="banner-homepage__btn banner-homepage__btn--secondary">
                            <span>{!! BaseHelper::clean($data['secondary_button_text']) !!}</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="banner-homepage__visual" aria-label="{{ __('Vietnam market entry visual') }}">
                @if ($data['image'])
                    <div class="banner-homepage__image-wrap">
                        {{ RvMedia::image($data['image'], $data['title'], attributes: ['class' => 'banner-homepage__image']) }}
                    </div>
                @else
                    <div class="banner-homepage__map-card">
                        <div class="banner-homepage__chaos-card">
                            <x-core::icon name="ti ti-alert-triangle" />
                            <span>{{ __('Paperwork') }}</span>
                            <small>{{ __('Complexity') }}</small>
                        </div>

                        <div class="banner-homepage__map">
                            <svg viewBox="0 0 320 380" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="{{ __('Vietnam glowing map') }}">
                                <path class="banner-homepage__map-outline" d="M186 18C165 43 157 69 173 96C187 119 176 135 158 153C140 171 134 197 152 218C170 239 169 257 151 278C132 301 143 329 171 356C189 374 211 368 209 341C207 314 218 295 234 275C252 253 246 226 223 210C200 194 201 174 223 154C245 134 239 103 213 88C191 75 196 52 210 26C216 15 197 5 186 18Z" />
                                <path class="banner-homepage__map-line" d="M177 91L156 174L188 238L174 330" />
                                <path class="banner-homepage__map-line banner-homepage__map-line--two" d="M205 146L188 238L226 270" />
                                <circle class="banner-homepage__pin" cx="177" cy="91" r="6" />
                                <circle class="banner-homepage__pin" cx="156" cy="174" r="6" />
                                <circle class="banner-homepage__pin" cx="188" cy="238" r="6" />
                                <circle class="banner-homepage__pin" cx="226" cy="270" r="6" />
                                <circle class="banner-homepage__pin" cx="174" cy="330" r="6" />
                            </svg>
                        </div>

                        <div class="banner-homepage__dashboard-card">
                            <x-core::icon name="ti ti-rosette-discount-check" />
                            <span>{{ __('Approved') }}</span>
                            <small>{{ __('Clean dashboard') }}</small>
                        </div>

                        @if ($serviceBadges)
                            <div class="banner-homepage__service-badges">
                                @foreach ($serviceBadges as $badge)
                                    <span>{{ $badge }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if ($badges || $extraBadge)
                    <div class="banner-homepage__trust-badges">
                        @foreach ($badges as $badge)
                            @php
                                $badgeText = trim($badge);
                                $hasMetric = preg_match('/^([\d,.]+\+?)\s*(.+)$/u', $badgeText, $badgeParts);
                            @endphp

                            <div @class([
                                'banner-homepage__trust-badge',
                                'banner-homepage__trust-badge--primary' => $loop->iteration === 1,
                                'banner-homepage__trust-badge--secondary' => $loop->iteration === 2,
                                'banner-homepage__trust-badge--tertiary' => $loop->iteration === 3,
                                'banner-homepage__trust-badge--rest' => $loop->iteration >= 4,
                            ])>
                                <span class="banner-homepage__trust-badge-content">
                                    @if ($hasMetric)
                                        <strong>{{ $badgeParts[1] }}</strong>
                                        <small>{{ $badgeParts[2] }}</small>
                                    @else
                                        <small>{{ $badgeText }}</small>
                                    @endif
                                </span>
                            </div>

                            @if ($loop->first && $extraBadge)
                                @php
                                    $extraBadgeText = trim($extraBadge);
                                    $hasExtraMetric = preg_match('/^([\d,.]+\+?)\s*(.+)$/u', $extraBadgeText, $extraBadgeParts);
                                @endphp

                                <div class="banner-homepage__trust-badge banner-homepage__trust-badge--extra">
                                    <span class="banner-homepage__trust-badge-content">
                                        @if ($hasExtraMetric)
                                            <strong>{{ $extraBadgeParts[1] }}</strong>
                                            <small>{{ $extraBadgeParts[2] }}</small>
                                        @else
                                            <small>{{ $extraBadgeText }}</small>
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endforeach

                        @if (! $badges && $extraBadge)
                            @php
                                $extraBadgeText = trim($extraBadge);
                                $hasExtraMetric = preg_match('/^([\d,.]+\+?)\s*(.+)$/u', $extraBadgeText, $extraBadgeParts);
                            @endphp

                            <div class="banner-homepage__trust-badge banner-homepage__trust-badge--primary">
                                <span class="banner-homepage__trust-badge-content">
                                    @if ($hasExtraMetric)
                                        <strong>{{ $extraBadgeParts[1] }}</strong>
                                        <small>{{ $extraBadgeParts[2] }}</small>
                                    @else
                                        <small>{{ $extraBadgeText }}</small>
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@once
    <style>
        .banner-homepage-shortcode {
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            width: 100vw;
        }

        .banner-homepage-shortcode > .container {
            max-width: none;
            padding-left: 0;
            padding-right: 0;
        }

        .banner-homepage {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 0.88fr) minmax(560px, 1.18fr);
            align-items: center;
            gap: clamp(24px, 4vw, 56px);
            min-height: 620px;
            border: 1px solid rgba(88, 166, 255, 0.2);
            border-radius: 0;
            background:
                radial-gradient(circle at 18% 16%, rgba(88, 166, 255, 0.22), transparent 28%),
                radial-gradient(circle at 84% 18%, rgba(191, 215, 255, 0.16), transparent 24%),
                radial-gradient(circle at 72% 78%, rgba(18, 62, 138, 0.66), transparent 36%),
                linear-gradient(135deg, #071A3D 0%, #0B2E6D 48%, #123E8A 100%);
            box-shadow: 0 30px 80px rgba(7, 26, 61, 0.28);
            overflow: hidden;
            padding: 0 max(calc((100vw - 1320px) / 2 + 12px), 24px);
        }

        .banner-homepage::before {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(191, 215, 255, 0.18) 1px, transparent 1px);
            background-size: 24px 24px;
            content: "";
            mask-image: linear-gradient(90deg, rgba(0, 0, 0, 0.42), transparent 70%);
            pointer-events: none;
        }

        .banner-homepage__glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(42px);
            opacity: 0.7;
            pointer-events: none;
        }

        .banner-homepage__glow--blue {
            right: 9%;
            top: 14%;
            width: 220px;
            height: 220px;
            background: rgba(88, 166, 255, 0.32);
            animation: bannerHomepagePulse 4.8s ease-in-out infinite;
        }

        .banner-homepage__glow--gold {
            right: 32%;
            bottom: 11%;
            width: 140px;
            height: 140px;
            background: rgba(88, 166, 255, 0.24);
            animation: bannerHomepagePulse 5.8s ease-in-out infinite reverse;
        }

        .banner-homepage__content,
        .banner-homepage__visual {
            position: relative;
            z-index: 1;
        }

        .banner-homepage__trust {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(191, 215, 255, 0.46);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #BFD7FF;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.04em;
            margin-bottom: 22px;
            padding: 10px 16px;
            text-transform: uppercase;
        }

        .banner-homepage__trust svg {
            width: 18px;
            height: 18px;
        }

        .banner-homepage h1 {
            color: #FFFFFF;
            font-size: clamp(26px, 3.5vw, 48px) !important;
            font-weight: 900;
            line-height: 1.02;
            margin: 0 0 18px;
        }

        .banner-homepage h2 {
            color: #BFD7FF;
            font-size: clamp(17px, 1.5vw, 18px) !important;
            font-weight: 700;
            line-height: 1.35;
            margin: 0 0 20px;
        }

        .banner-homepage p {
            color: rgba(191, 215, 255, 0.88);
            font-size: 15px;
            line-height: 1.75;
            margin: 0 0 26px;
            max-width: 650px;
        }

        .banner-homepage__features {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 16px;
            list-style: none;
            margin: 0 0 32px;
            padding: 0;
        }

        .banner-homepage__features li {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #FFFFFF;
            font-size: 14px;
            font-weight: 750;
        }

        .banner-homepage__feature-icon {
            flex: 0 0 auto;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.18), rgba(88, 166, 255, 0.2));
            box-shadow: 0 0 12px rgba(88, 166, 255, 0.45);
            color: #EAF3FF;
            object-fit: cover;
            padding: 4px;
        }

        .banner-homepage__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .banner-homepage__btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 999px;
            font-weight: 850;
            min-height: 54px;
            padding: 15px 24px;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .banner-homepage__btn:hover {
            transform: translateY(-3px);
        }

        .banner-homepage__btn--primary {
            background: linear-gradient(135deg, #FF6A3D 0%, #F0442E 100%);
            box-shadow: 0 16px 36px rgba(244, 91, 63, 0.36);
            color: #FFFFFF;
        }

        .banner-homepage__btn--primary:hover {
            color: #FFFFFF;
            box-shadow: 0 20px 44px rgba(244, 91, 63, 0.46);
        }

        .banner-homepage__btn--secondary {
            border: 1px solid rgba(191, 215, 255, 0.32);
            background: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }

        .banner-homepage__btn--secondary:hover {
            border-color: rgba(191, 215, 255, 0.7);
            color: #FFFFFF;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18);
        }

        .banner-homepage__visual {
            min-width: 0;
            isolation: isolate;
        }

        .banner-homepage__image-wrap,
        .banner-homepage__map-card {
            position: relative;
            min-height: 540px;
            border-radius: 28px;
        }

        .banner-homepage__image-wrap {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 560px;
            overflow: visible;
            padding: 0;
        }

        .banner-homepage__image {
            max-height: 590px;
            width: min(118%, 860px);
            object-fit: contain;
            filter: drop-shadow(0 24px 34px rgba(0, 0, 0, 0.32));
            transform: scale(1.03);
            transform-origin: center right;
        }

        .banner-homepage__map-card::before {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(120deg, rgba(88, 166, 255, 0.1), transparent 42%),
                radial-gradient(circle at 55% 50%, rgba(88, 166, 255, 0.2), transparent 34%);
            content: "";
        }

        .banner-homepage__map {
            position: absolute;
            inset: 22px 34px 62px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-homepage__map svg {
            width: min(100%, 430px);
            height: auto;
            filter: drop-shadow(0 0 28px rgba(88, 166, 255, 0.38));
        }

        .banner-homepage__map-outline {
            fill: rgba(88, 166, 255, 0.08);
            stroke: #58A6FF;
            stroke-width: 3;
        }

        .banner-homepage__map-line {
            stroke: #BFD7FF;
            stroke-width: 2.4;
            stroke-dasharray: 8 9;
            animation: bannerHomepageLine 2.8s linear infinite;
        }

        .banner-homepage__map-line--two {
            stroke: #58A6FF;
            animation-duration: 3.4s;
        }

        .banner-homepage__pin {
            fill: #EAF3FF;
            filter: drop-shadow(0 0 10px rgba(88, 166, 255, 0.9));
            animation: bannerHomepagePin 2.8s ease-in-out infinite;
        }

        .banner-homepage__chaos-card,
        .banner-homepage__dashboard-card {
            position: absolute;
            z-index: 2;
            display: grid;
            gap: 2px;
            min-width: 150px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            backdrop-filter: blur(14px);
            background: rgba(7, 26, 61, 0.72);
            box-shadow: 0 18px 34px rgba(0, 0, 0, 0.24);
            color: #FFFFFF;
            padding: 16px;
            animation: bannerHomepageFloat 4.4s ease-in-out infinite;
        }

        .banner-homepage__chaos-card {
            left: 18px;
            top: 42px;
        }

        .banner-homepage__dashboard-card {
            right: 18px;
            bottom: 92px;
            animation-delay: -1.2s;
        }

        .banner-homepage__chaos-card svg,
        .banner-homepage__dashboard-card svg {
            width: 26px;
            height: 26px;
            margin-bottom: 6px;
        }

        .banner-homepage__chaos-card svg {
            color: #FF6A3D;
        }

        .banner-homepage__dashboard-card svg {
            color: #4ADE80;
        }

        .banner-homepage__chaos-card span,
        .banner-homepage__dashboard-card span {
            font-weight: 850;
        }

        .banner-homepage__chaos-card small,
        .banner-homepage__dashboard-card small {
            color: #BFD7FF;
            font-weight: 700;
        }

        .banner-homepage__service-badges {
            position: absolute;
            inset: auto 22px 24px;
            z-index: 2;
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            justify-content: center;
        }

        .banner-homepage__service-badges span {
            border: 1px solid rgba(88, 166, 255, 0.26);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 850;
            padding: 9px 12px;
        }

        .banner-homepage__trust-badges {
            position: absolute;
            inset: 0;
            z-index: 4;
            pointer-events: none;
        }

        .banner-homepage__title {
            font-size: clamp(48px, 4.8vw, 58px);
        }

        .banner-homepage__trust-badge {
            position: absolute;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: min(250px, 42%);
            min-height: 76px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 999px;
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 18px 38px rgba(7, 26, 61, 0.22);
            color: #123E8A;
            font-size: 13px;
            font-weight: 850;
            line-height: 1.28;
            padding: 13px 18px 13px 14px;
            animation: bannerHomepageFloat 4.8s ease-in-out infinite;
        }

        .banner-homepage__trust-badge--primary {
            left: 0;
            top: 15%;
        }

        .banner-homepage__trust-badge--extra {
            left: 23%;
            top: 15%;
            animation-delay: -0.9s;
        }

        .banner-homepage__trust-badge--secondary {
            right: 3%;
            bottom: 18%;
            animation-delay: -1.5s;
        }

        .banner-homepage__trust-badge--tertiary {
            left: 26%;
            bottom: 4%;
            animation-delay: -0.8s;
        }

        .banner-homepage__trust-badge--rest {
            right: 20%;
            top: 4%;
            animation-delay: -2.1s;
        }

        .banner-homepage__trust-badge-icon {
            display: inline-grid;
            flex: 0 0 auto;
            width: 42px;
            height: 42px;
            place-items: center;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.22), rgba(88, 166, 255, 0.24));
            box-shadow: 0 0 14px rgba(88, 166, 255, 0.5);
            color: #EAF3FF;
        }

        .banner-homepage__trust-badge-content {
            display: grid;
            gap: 2px;
            min-width: 0;
        }

        .banner-homepage__trust-badge-content strong {
            color: #0B2E6D;
            font-size: 32px;
            font-weight: 950;
            line-height: 0.95;
        }

        .banner-homepage__trust-badge-content small {
            color: #123E8A;
            font-size: 12px;
            font-weight: 850;
            line-height: 1.24;
        }

        .banner-homepage__trust-badge svg {
            width: 22px;
            height: 22px;
        }

        @keyframes bannerHomepageFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes bannerHomepagePulse {
            0%, 100% {
                opacity: 0.45;
                transform: scale(0.96);
            }
            50% {
                opacity: 0.82;
                transform: scale(1.06);
            }
        }

        @keyframes bannerHomepageLine {
            to {
                stroke-dashoffset: -34;
            }
        }

        @keyframes bannerHomepagePin {
            0%, 100% {
                opacity: 0.72;
            }
            50% {
                opacity: 1;
            }
        }

        @media (max-width: 991px) {
            .banner-homepage {
                grid-template-columns: 1fr;
                min-height: auto;
                padding: 80px 24px;
            }

            .banner-homepage__image-wrap {
                justify-content: center;
            }

            .banner-homepage__image {
                transform: none;
            }

            .banner-homepage__features {
                grid-template-columns: 1fr;
            }

            .banner-homepage__image-wrap,
            .banner-homepage__map-card {
                min-height: 460px;
            }

            .banner-homepage__trust-badge {
                max-width: min(270px, 48%);
            }
        }

        @media (max-width: 575px) {
            .banner-homepage-shortcode {
                padding: 20px 0;
            }

            .banner-homepage {
                border-radius: 0;
                padding: 2rem 24px;
            }

            .banner-homepage h1 {
                font-size: 32px !important;
            }

            .banner-homepage__actions {
                flex-direction: column;
            }

            .banner-homepage__btn {
                width: 100%;
            }

            .banner-homepage__image-wrap,
            .banner-homepage__map-card {
                min-height: 380px;
            }

            .banner-homepage__image-wrap {
                min-height: auto;
                padding: 22px 0 8px;
            }

            .banner-homepage__image {
                width: min(112%, 680px);
                max-height: none;
            }

            .banner-homepage__trust-badges {
                position: static;
                display: flex;
                flex-wrap: nowrap;
                align-items: stretch;
                gap: 10px;
                margin-top: 10px;
                overflow-x: auto;
                padding-bottom: 4px;
                pointer-events: auto;
                scrollbar-width: none;
            }

            .banner-homepage__trust-badges::-webkit-scrollbar {
                display: none;
            }

            .banner-homepage__trust-badge {
                position: static;
                flex: 0 0 auto;
                width: fit-content;
                max-width: 72vw;
                min-height: 58px;
                padding: 10px 14px;
                animation: none;
            }

            .banner-homepage__trust-badge-content strong {
                font-size: 24px;
            }

            .banner-homepage__trust-badge-content small {
                font-size: 11px;
            }

            .banner-homepage__map {
                inset: 54px 24px 88px;
            }

            .banner-homepage__chaos-card,
            .banner-homepage__dashboard-card {
                min-width: 132px;
                padding: 12px;
            }

            .banner-homepage__chaos-card {
                left: 10px;
                top: 20px;
            }

            .banner-homepage__dashboard-card {
                right: 10px;
                bottom: 86px;
            }
        }
    </style>
@endonce
