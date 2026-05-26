<div class="bg-primary rounded-4 position-relative">
    <div class="p-7">
        @if($config['title'])
            <h4 class="text-white">{!! BaseHelper::clean(nl2br($config['title'])) !!}</h4>
        @endif
        <a href="{{ $config['contact_url'] }}" class="d-flex align-items-center mt-8 mb-9">
            @if($config['icon_image'])
                {{ RvMedia::image($config['icon_image'], Theme::getSiteTitle()) }}
            @endif
            @if($config['contact_title'] || $config['contact_subtitle'])
                <div @class(['ms-3' => $config['icon_image']])>
                    @if($config['contact_title'])
                        <span class="text-white mb-0 fs-4">{{ $config['contact_title'] }}</span>
                    @endif
                    @if($config['contact_number'])
                        <h5 class="text-white d-block">{{ $config['contact_number'] }}</h5>
                    @endif
                </div>
            @endif
        </a>
        @if($config['button_label'])
            <a href="{{ $config['button_url'] }}" class="fw-bold btn text-start bg-white fs-6 d-flex align-items-center justify-content-between text-primary hover-up w-100">
                <span>{{ $config['button_label'] }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path class="" d="M17.4177 5.41772L16.3487 6.48681L21.1059 11.244H0V12.756H21.1059L16.3487 17.5132L17.4177 18.5822L24 12L17.4177 5.41772Z" fill="currentColor"></path>
                </svg>
            </a>
        @endif
    </div>

    <img src="{{ Theme::asset()->url('images/decorations/block-bg-line.png') }}" alt="line" class="position-absolute top-0 end-0 z-1">
</div>
