@php
    $style = $shortcode->style;
    $style = in_array($style, range(1, 3)) ? $style : 1;

    $bgColor = $shortcode->background_color;
    $bgImage = $shortcode->background_image ? RvMedia::getImageUrl($shortcode->background_image) : null;

    $variablesStyle = [
        "--shortcode-background-color: $bgColor !important;" => $bgColor,
        "--shortcode-background-image: url($bgImage) !important;" => $bgImage,
    ];

    $fields = ['title', 'description', 'icon'];

    for ($i = 1; $i <= 3; $i++) {
        $fields[] = "button_label_{$i}";
        $fields[] = "button_url_{$i}";
        $fields[] = "button_icon_{$i}";
    }

    $tabs = Shortcode::fields()->getTabsData($fields, $shortcode);
@endphp

@include(Theme::getThemeNamespace("partials.shortcodes.contact-form.styles.style-$style"))
