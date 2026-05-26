<section {!! $shortcode->htmlAttributes() !!} class="shortcode-site-statistics shortcode-site-statistics-style-3 section-static-1 position-relative fix z-0 section-padding"
    @style($variablesStyle)
>
    <div class="container">
        <div class="inner">
            <div class="row justify-content-between">
                @foreach($tabs as $item)
                    @php
                        $title = Arr::get($item, 'second_tab_title');
                        $data = Arr::get($item, 'second_tab_data');
                    @endphp

                    @continue(! $title || ! $data)

                    <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
                        <div class="counter-item-cover counter-item">
                            <div class="content text-center mx-auto">
                                <strong class="d-block fs-6">{!! BaseHelper::clean($title) !!}</strong>
                                <span class="h1 count fw-black text-primary my-0">
                                    <span class="odometer" data-count="{{ $data }}"></span>
                                    @if ($unit = Arr::get($item, 'second_tab_unit'))
                                        <span>{!! BaseHelper::clean($unit) !!}</span>
                                    @endif
                                </span>
                                @if ($description = Arr::get($item, 'second_tab_description'))
                                    <p class="fs-5">{!! BaseHelper::clean($description) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
