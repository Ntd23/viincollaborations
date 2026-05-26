{!! do_shortcode(Shortcode::generateShortcode('call-to-action', [
    'title' => Arr::get($config, 'title'),
    'image' => Arr::get($config, 'image'),
    'primary_action_label' => Arr::get($config, 'button_label'),
    'primary_action_url' => Arr::get($config, 'button_url'),
    'primary_action_icon' => Arr::get($config, 'button_icon'),
    'background_color' => Arr::get($config, 'background_color'),
])) !!}
