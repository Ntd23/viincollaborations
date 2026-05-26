@if($galleries->isNotEmpty())
    <div class="col-lg-3">
        @if ($title = Arr::get($config, 'title'))
            <h3 class="text-white opacity-50 fs-6 fw-black pb-3 pt-5">{!! BaseHelper::clean($title) !!}</h3>
        @endif
        <div class="d-flex flex-wrap gap-2">
            @foreach($galleries as $gallery)
                <a href="{{ $gallery->url }}" class="me-2 hover-up">
                    {{ RvMedia::image($gallery->image, $gallery->name, 'thumb', attributes: ['class' => 'rounded-3', 'width' => 80]) }}
                </a>
            @endforeach
        </div>
    </div>
@endif

