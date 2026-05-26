@php
    $style = Arr::get($config, 'style', 1);

    $style = match ($style) {
        2 => 5,
        default => 4,
    };
@endphp

{!! do_shortcode(Shortcode::generateShortcode('blog-posts', [
    'subtitle' => Arr::get($config, 'subtitle'),
    'title' => Arr::get($config, 'title'),
    'description' => Arr::get($config, 'description'),
    'paginate' => Arr::get($config, 'limit', 4),
    'action_label' => Arr::get($config, 'action_label'),
    'action_url' => Arr::get($config, 'action_url'),
    'style' => $style,
])) !!}
