<div class="sidebar">
    <div class="bg-neutral-100 px-5 pb-5 mt-5 rounded-4 border">
        @if ($title = Arr::get($config, 'title'))
            <strong class="d-block fs-6 mb-4 mt-3">{!! BaseHelper::clean($title) !!}</strong>
        @endif

        @if($items = Arr::get($config, 'items'))
            @foreach($items as $item)
                @php
                    $item = collect($item)->pluck('value', 'key');

                    $itemUrl = $item->get('url');
                    $itemLabel = $item->get('label');
                    $icon = $item->get('icon');
                    $iconImage = $item->get('icon_image');
                @endphp

                @continue(!$itemUrl || !$itemLabel)

                <a href="{{ $itemUrl }}" class="bg-white rounded-3 p-3 border d-flex align-items-center mb-3">
                    @if ($iconImage)
                        {{ RvMedia::image($iconImage) }}
                    @elseif ($icon)
                        <x-core::icon :name="$icon"/>
                    @endif
                    <p class="text-900 fs-7 mb-0 ms-3">{!! BaseHelper::clean($itemLabel) !!}</p>
                </a>
            @endforeach
        @endif
    </div>
</div>
