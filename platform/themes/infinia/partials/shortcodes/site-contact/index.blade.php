@php
    $backgroundColor = $shortcode->background_color;
    $backgroundColor = $backgroundColor == 'transparent' ? null : $backgroundColor;
@endphp

<div {!! $shortcode->htmlAttributes() !!} class="position-relative d-none d-md-flex shortcode-site-contact">
    <div @class(['col-6 py-md-6', 'bg-primary' => ! $backgroundColor]) @style(["background-color: $backgroundColor !important;" => $backgroundColor])></div>
    <div @class(['col-6 py-md-6', 'bg-primary-dark' => ! $backgroundColor]) @style(["background-color: $backgroundColor !important;" => $backgroundColor])></div>
    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row">
            <div class="col-6 d-lg-flex gap-5">
                @foreach($tabs as $tab)
                    @php
                        $icon = Arr::get($tab, 'action_icon');
                        $actionLabel = Arr::get($tab, 'action_label');
                        $actionUrl = Arr::get($tab, 'action_url');
                    @endphp

                    @continue(!$actionLabel || !$actionUrl)

                    <a href="{{ $actionUrl }}" @class(['d-flex', 'mb-lg-0 mb-2' => $loop->first])>
                        @if ($icon)
                            <x-core::icon class="text-white" :name="$icon" />
                        @endif

                        <p class="text-white mb-0 ms-2">{!! BaseHelper::clean($actionLabel) !!}</p>
                    </a>
                @endforeach
            </div>

            @php
                $description = $shortcode->description;
                $actionLabel = $shortcode->action_label;
                $actionUrl = $shortcode->action_url;
            @endphp

            @if ($description || ($actionLabel && $actionUrl))
                <div class="col-6">
                    <div class="d-flex ms-md-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M13 16H12V12H11M12 8H12.01M21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3C14.3869 3 16.6761 3.94821 18.364 5.63604C20.0518 7.32387 21 9.61305 21 12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        @if ($description)
                            <p class="text-white mb-0 ms-2">{!! BaseHelper::clean($description) !!}</p>
                        @endif

                        @if ($actionLabel && $actionUrl)
                            <a href="{{ $actionUrl }}" class="text-white ms-2 link-hover-primary-dark">{!! BaseHelper::clean($actionLabel) !!}</a>
                        @endif

                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
