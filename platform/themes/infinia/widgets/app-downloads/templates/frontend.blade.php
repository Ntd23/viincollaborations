@php
    $platforms = (array) Arr::get($config, 'platforms', []);
    $platformsChunk = array_chunk($platforms, 2);
@endphp

<div class="col-lg-3 pt-5 pt-lg-0">
    @if ($title = Arr::get($config, 'title'))
        <h3 class="text-white opacity-50 fs-6 fw-black pb-3 pt-5">{!! BaseHelper::clean($title) !!}</h3>
    @endif

    @if ($description = Arr::get($config, 'description'))
        <p class="text-white fw-medium mt-3 mb-4 opacity-50">{!! BaseHelper::clean($description) !!}</p>
    @endif

    @foreach($platformsChunk as $platforms)
        <div class="d-flex gap-2">
            @foreach($platforms as $platform)
                @php
                    $item = collect($platform)->pluck('value', 'key')->toArray();
                @endphp

                @continue(! $itemImage = Arr::get($item, 'image'))

                <a href="{{ Arr::get($item, 'url') }}">
                    {{ RvMedia::image($itemImage, Arr::get($item, 'name'), attributes: ['class' => 'mb-2']) }}
                </a>
            @endforeach
        </div>
    @endforeach
    <div class="col-1"></div>
</div>
