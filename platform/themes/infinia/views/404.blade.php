@php
    SeoHelper::setTitle(__('404 - Not found'));
    Theme::fireEventGlobalAssets();
@endphp

@extends(Theme::getThemeNamespace('layouts.base'))

@section('content')
    <section class="not-found-page">
        <div class="container pb-120">
            <div class="text-center section-padding">
                @if($image = theme_option('404_image'))
                    {{ RvMedia::image($image, Theme::getSiteTitle()) }}
                @endif
                <h5 class="ds-5 pt-8">{!! BaseHelper::clean("We Can't Find What <br /> You're Looking For")!!}</h5>
                <p>{!! BaseHelper::clean('We apologize, but the page you requested seems to be missing. It may <br /> have been moved, deleted, or there might be a typo in the URL.') !!}</p>
                <a href="{{ BaseHelper::getHomepageUrl() }}" class="btn btn-primary hover-up mt-5">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="14" viewBox="0 0 24 14" fill="none">
                        <path
                            class="stroke-white"
                            d="M2.89413 7.25597H23.5V6.74404H2.89413H1.68704L2.54058 5.89049L6.94422 1.4868L6.58227 1.12484L0.707108 6.99996L6.58228 12.8751L6.94422 12.5132L2.54058 8.10952L1.68703 7.25597H2.89413Z"
                            stroke="white"
                        />
                    </svg>
                    {{ __('Go Back Homepage') }}
                </a>
            </div>
        </div>
    </section>
@endsection
