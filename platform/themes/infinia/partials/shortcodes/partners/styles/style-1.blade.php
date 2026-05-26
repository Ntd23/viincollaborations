<div {!! $shortcode->htmlAttributes() !!} class="shortcode-partners shortcode-partners-style-1 section-logo-cloud container-fluid mt-8 mt-lg-0 border-top border-bottom"
    @style($variablesStyle)
>
    <div class="container">
        <div class="row mask-image">
            <div class="partners-slider my-7 position-relative z-1">
                @foreach($partners as $partner)
                    <div class="partner-item">
                        @if($partner['url'])
                            <a href="{{ $partner['url'] }}" @if($partner['open_in_new_tab']) target="_blank" @endif>
                                @endif
                                {{ RvMedia::image($partner['image'], $partner['name']) }}
                                @if($partner['url'])
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
