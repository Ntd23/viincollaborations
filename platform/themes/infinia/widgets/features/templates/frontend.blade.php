@if($items = Arr::get($config, 'items'))
    <div>
        @if ($title = Arr::get($config, 'title'))
            <h5 class="mb-5">{!! BaseHelper::clean($title) !!}</h5>
        @endif

        <div>
            @foreach($items as $item)
                @php
                    $item = collect($item)->pluck('value', 'key');

                    $itemTitle = $item->get('title');
                    $itemDescription = $item->get('description');
                    $itemIcon = $item->get('icon');
                    $itemIconImage = $item->get('icon_image');
                @endphp

                @continue(! $itemTitle)

                <div @class(['d-flex', 'pt-3' => ! $loop->first])>
                    @if($itemIcon || $itemIconImage)
                        <div class="bg-primary-soft icon-flip position-relative icon-shape icon-xxl rounded-3 mb-4">
                            <div class="icon">
                                @if($itemIconImage)
                                    {{ RvMedia::image($itemIconImage) }}
                                @else
                                    <x-core::icon :name="$itemIcon"/>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="ps-5">
                        <strong class="d-block fs-6">{!! BaseHelper::clean($itemTitle) !!}</strong>

                        @if ($itemDescription)
                            <p>{!! BaseHelper::clean($itemDescription) !!}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
