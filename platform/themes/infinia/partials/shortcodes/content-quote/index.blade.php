<div {!! $shortcode->htmlAttributes() !!} class="bg-primary-light position-relative m-lg-7 rounded-4 text-center">
    <svg class="mt-7" xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 52 52" fill="none">
        <g clip-path="url(#clip0_617_33458)">
            <path d="M0 29.7142H11.1428L3.71422 44.5712H14.8571L22.2857 29.7142V7.42847H0V29.7142Z" fill="white" />
            <path d="M29.7109 7.42822V29.7139H40.8538L33.4252 44.571H44.568L51.9966 29.7139V7.42822H29.7109Z" fill="white" />
        </g>
        <defs>
            <clipPath>
                <rect width="52" height="52" fill="white" />
            </clipPath>
        </defs>
    </svg>
    <blockquote class="mt-6 px-lg-0 px-5">
        {!! BaseHelper::clean($shortcode->quote) !!}
    </blockquote>
    @if($shortcode->author)
        <div class="d-inline-flex align-items-center mt-5 mb-8">
            @if($shortcode->author_image)
                {{ RvMedia::image($shortcode->author_image, $shortcode->author, attributes: ['class' => 'avatar-lg rounded-circle', 'width' => 48]) }}
            @endif
            <div class="d-flex flex-column">
                <strong class="d-block ms-3 fs-6 mb-0 text-white">{{ $shortcode->author }}</strong>
                @if($shortcode->author_description)
                    <div class="flag ms-3">
                        <span class="fs-8 text-white">{{ $shortcode->author_description }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
