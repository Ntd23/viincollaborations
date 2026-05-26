@php
    Gallery::registerAssets();
@endphp

<section class="section pt-50 pb-100">
    <div class="container">
        <div class="page-content">
            <article class="post post--single">
                <div class="post__content">
                    @if (isset($galleries) && $galleries->isNotEmpty())
                        <div class="gallery-wrap">
                            @foreach ($galleries as $gallery)
                                <div class="gallery-item">
                                    <div class="img-wrap">
                                        <a href="{{ $gallery->url }}">
                                            {{ RvMedia::image($gallery->image, $gallery->name, 'medium') }}
                                        </a>
                                    </div>
                                    <div class="gallery-detail">
                                        <div class="gallery-title">
                                            <a href="{{ $gallery->url }}">{{ $gallery->name }}</a>
                                        </div>
                                        @if (trim($gallery->user->name))
                                            <div class="gallery-author">{{ __('By :name', ['name' => $gallery->user->name]) }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>
        </div>
    </div>
</section>
