<section {!! $shortcode->htmlAttributes() !!} class="shortcode-partners shortcode-partners-style-2 section-logo-cloud section-logo-cloud-5 position-relative"
    @style($variablesStyle)
>
    <div class="container-fluid pt-110 pb-110 mt-lg-0 border-top border-bottom">
        <div class="container">
            <div class="row align-items-center">
                @if($shortcode->title || $shortcode->description || $shortcode->primary_action_label)
                    <div class="col-lg-3 pb-lg-0 pb-8">
                        @if($shortcode->title)
                            <h4 class="text-nowrap">
                                {!! BaseHelper::clean(nl2br($shortcode->title)) !!}
                            </h4>
                        @endif
                        @if($shortcode->description)
                            <p class="pt-2 pb-4">{!! BaseHelper::clean(nl2br($shortcode->description)) !!}</p>
                        @endif
                        @if($shortcode->primary_action_label)
                            <a href="{{ $shortcode->primary_action_url }}" class="shadow-1 btn text-start bg-white d-inline-block text-primary hover-up">
                                {{ $shortcode->primary_action_label }}
                                @if($shortcode->primary_action_icon)
                                    <x-core::icon :name="$shortcode->primary_action_icon" class="ms-2 text-dark" />
                                @endif
                            </a>
                        @endif
                    </div>
                @endif
                <div class="col-lg-9 ps-lg-8">
                    @foreach($partners as $partner)
                        <div class="bg-white py-3 px-3 shadow-1 rounded-2 align-self-center icon-height icon-shape hover-up me-2 mb-2" style="height: 62px;">
                            @if($partner['url'])
                                <a href="{{ $partner['url'] }}" target="_blank">
                                    {{ RvMedia::image($partner['image'], $partner['name'], attributes: ['style' => 'height: 100%']) }}
                                </a>
                            @else
                                {{ RvMedia::image($partner['image'], $partner['name'], attributes: ['style' => 'height: 100%']) }}
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="bouncing-blobs-container rounded-4 fix">
            <div class="bouncing-blobs-glass rounded-4"></div>
            <div class="bouncing-blobs">
                <div class="bouncing-blob bouncing-blob--green"></div>
                <div class="bouncing-blob bouncing-blob--primary"></div>
                <div class="bouncing-blob bouncing-blob--infor bouncing-blob--infor-2"></div>
            </div>
        </div>
    </div>
</section>
