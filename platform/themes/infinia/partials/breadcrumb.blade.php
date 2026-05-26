@php
    $breadcrumbEnabled = Theme::breadcrumb()->enabled();

    if ($breadcrumbEnabled) {
        $breadcrumbEnabled = match (Theme::get('breadcrumbEnabled')) {
            '1' => true,
            '0' => false,
            default => Theme::breadcrumb()->enabled(),
        };
    }
@endphp

@if($breadcrumbEnabled)
    <section class="section-page-header py-8 fix position-relative" @if (($backgroundColor = theme_option('breadcrumb_background_color')) && $backgroundColor !== 'transparent') style="background-color: {{ $backgroundColor }} !important;" @endif>
        <div class="container position-relative z-1">
            <div class="text-start">
                <h3>{{ SeoHelper::getTitleOnly() }}</h3>
                <ol class="ps-0 d-flex list-unstyled">
                    @foreach (Theme::breadcrumb()->getCrumbs() as $crumb)
                        @if($loop->last)
                            <li class="d-flex align-items-center">
                                <svg class="mx-3" xmlns="http://www.w3.org/2000/svg" width="8" height="13" viewBox="0 0 8 13" fill="none">
                                    <path class="stroke-dark" d="M1 1.5L6.5 6.75L1 12" stroke="#111827" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <p class="mb-0 text-900">{{ $crumb['label'] }}</p>
                            </li>
                        @else
                            <li>
                                <a href="{{ $crumb['url'] }}" class="d-flex align-items-center">
                                    @if(! $loop->first)
                                        <svg class="mx-3" xmlns="http://www.w3.org/2000/svg" width="8" height="13" viewBox="0 0 8 13" fill="none">
                                            <path class="stroke-dark" d="M1 1.5L6.5 6.75L1 12" stroke="#111827" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    @endif

                                    <p class="mb-0 text-primary">{{ $crumb['label'] }}</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
        @if($backgroundImage = theme_option('breadcrumb_background_image'))
            {{ RvMedia::image($backgroundImage, __('Background image'), attributes: ['class' => 'position-absolute bottom-0 start-0 end-0 top-0 z-0 h-100']) }}
        @endif
        @if (! $backgroundColor || $backgroundColor === 'transparent')
            <div class="bouncing-blobs-container">
                <div class="bouncing-blobs-glass"></div>
                <div class="bouncing-blobs">
                    <div class="position-absolute top-0 start-0 translate-middle-y bouncing-blob--green"></div>
                    <div class="position-absolute top-0 end-0 bouncing-blob--primary"></div>
                </div>
            </div>
        @endif
    </section>
@endif
