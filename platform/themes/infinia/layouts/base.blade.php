<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>

        <style>
            :root {
                --primary-color: {{ $primaryColor = theme_option('primary_color', '#6d4df2') }};
                --primary-color-dark: {{ $primaryColorDark = theme_option('primary_color_dark', '#6342ec') }};
                --primary-color-dark-light: {{ theme_option('primary_color_dark_light', '#7f7d88') }};
                --primary-color-dark-soft: {{ theme_option('primary_color_dark_soft', '#271c52') }};
                --primary-color-rgb: {{ implode(',', BaseHelper::hexToRgb($primaryColor)) }} !important;
                --primary-color-dark-rgb: {{ implode(',', BaseHelper::hexToRgb($primaryColorDark)) }} !important;
                --select-text-color: {{ theme_option('select_text_color', '#ffffff') }} !important;
                --primary-gradient-bg: linear-gradient(90deg, {{ theme_option('primary_gradient_from', '#6d4df2') }} 0%, {{ theme_option('primary_gradient_to', '#8c71ff') }} 100%);
            }
        </style>

        @php
            Theme::asset()->remove('contact-css');
        @endphp

        {!! Theme::header() !!}
    </head>
    <body {!! Theme::bodyAttributes() !!}>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        <main>
            {!! Theme::breadcrumb()->render(Theme::getThemeNamespace('partials.breadcrumb')) !!}

            @yield('content')
        </main>

        {!! Theme::footer() !!}

        @if (theme_option('hide_theme_mode_switcher', 'no') !== 'yes')
            <script>
                let switchers = document.querySelectorAll('.dark-light-switcher');

                function updateTheme(isDarkMode) {
                    switchers.forEach(function (switcher) {
                        let darkIcon = switcher.querySelector('.bi-sun-fill');
                        let lightIcon = switcher.querySelector('.bi-moon-stars-fill');

                        if (isDarkMode) {
                            lightIcon.style.display = 'none';
                            darkIcon.style.display = 'block';
                        } else {
                            lightIcon.style.display = 'block';
                            darkIcon.style.display = 'none';
                        }
                    });

                    document.documentElement.setAttribute('data-bs-theme', isDarkMode ? 'dark' : 'light');
                }

                let storedTheme = localStorage.getItem('theme');
                if (!storedTheme) {
                    let htmlTheme = document.documentElement.getAttribute('data-bs-theme');

                    if (htmlTheme === 'system') {
                        let prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        storedTheme = prefersDarkMode ? 'dark' : 'light';
                    } else {
                        storedTheme = htmlTheme;
                    }
                }

                let isDarkMode = storedTheme === 'dark';
                updateTheme(isDarkMode);

                switchers.forEach(function (switcher) {
                    switcher.addEventListener('click', function () {
                        let currentTheme = localStorage.getItem('theme') || storedTheme;
                        let isDarkMode = currentTheme === 'dark';

                        let newTheme = isDarkMode ? 'light' : 'dark';
                        localStorage.setItem('theme', newTheme);
                        updateTheme(newTheme === 'dark');
                    });
                });
            </script>
        @endif
    </body>
</html>
