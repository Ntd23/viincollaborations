@php
    $shortCodeTabs = [];
    $items = Arr::get($config, 'items', []);
    $quantity = 0;

    if (! is_array($items) && Str::isJson($items)) {
       $items = json_decode($items, true);
    }

    foreach ($items as $index => $tab) {
        $quantity++;
        foreach ($tab as $value) {
            $shortCodeTabs[Arr::get($value, 'key') . '_' .$index + 1] = Arr::get($value, 'value');
        }
    }

    $style = Arr::get($config, 'style', 1);
@endphp

@if ($style == 2)
    @foreach($items as $item)
        @php
            $item = collect($item)->pluck('value', 'key')->all();

            $label = Arr::get($item, 'action_label');
            $url = Arr::get($item, 'action_url');
            $icon = Arr::get($item, 'action_icon');
        @endphp

        @continue(! $label)

        @if ($url)
            <a href="{{ $url }}" @class(['pe-4' => ! $loop->last])>
                @if ($icon)
                    <x-core::icon :name="$icon" />
                @endif

                <span class="text-900 ps-1 fs-7">{!! BaseHelper::clean($label) !!}</span>
            </a>
        @else
            <div @class(['location d-flex align-items-center','pe-4' => ! $loop->last])>
                @if ($icon)
                    <x-core::icon :name="$icon" />
                @endif

                <span class="text-900 ps-1 fs-7">{!! BaseHelper::clean($label) !!}</span>
            </div>
        @endif
    @endforeach
@else
    {!! do_shortcode(Shortcode::generateShortcode('site-contact', [
        ...$shortCodeTabs,
        'quantity' => $quantity,
        'description' => Arr::get($config, 'description'),
        'action_label' => Arr::get($config, 'action_label'),
        'action_url' => Arr::get($config, 'action_url'),
    ])) !!}
@endif

