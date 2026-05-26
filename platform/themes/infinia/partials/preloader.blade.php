<div id="preloader">
    <div id="loader" class="loader">
        <div class="loader-container text-center">
            <div class="loader-icon">
                @if ($image = theme_option('preloader_image'))
                    {{ RvMedia::image($image, lazy: false) }}
                @else
                    <img src="{{ Theme::asset()->url('images/pre-loader.png') }}" alt="preloader">
                @endif

                <p>{{ __('Loading...') }}</p>
            </div>
        </div>
    </div>
</div>
