<div class="d-flex align-items-center pe-5 pe-lg-0 me-5 me-lg-0">
    @if($config['show_search_button'])
        <a href="#" title="{{ __('Search') }}" data-bs-toggle="offcanvas" data-bs-target=".offcanvasTop">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                    class="stroke-dark"
                    d="M19.25 19.25L15.5 15.5M4.75 11C4.75 7.54822 7.54822 4.75 11 4.75C14.4518 4.75 17.25 7.54822 17.25 11C17.25 14.4518 14.4518 17.25 11 17.25C7.54822 17.25 4.75 14.4518 4.75 11Z"
                    stroke="black"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </a>
    @endif
    @if ($config['show_theme_switcher'] && theme_option('hide_theme_mode_switcher', 'no') !== 'yes')
        <div class="dark-light-switcher d-flex justify-content-center align-items-center icon-shape icon-md border bg-white rounded-3 ms-3 me-md-3 me-0">
            <i class="bi theme-icon bi-sun-fill"></i>
            <i class="bi theme-icon bi-moon-stars-fill"></i>
        </div>
    @endif
    @if($config['action_label'])
        <a href="{{ $config['action_url'] }}" class="btn btn-gradient d-none d-md-block">
            {{ $config['action_label'] }}
        </a>
    @endif
    <div class="burger-icon burger-icon-white border rounded-3">
        <span class="burger-icon-top"></span>
        <span class="burger-icon-mid"></span>
        <span class="burger-icon-bottom"></span>
    </div>
</div>
