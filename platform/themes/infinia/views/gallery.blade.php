<section class="section pt-50 pb-100">
    <div class="container">
        <div class="page-content">
            <article class="post post--single">
                <div class="post__content">
                    <div class="ck-content">
                        {!! BaseHelper::clean($gallery->description) !!}
                    </div>
                    <div id="list-photo">
                        @foreach (gallery_meta_data($gallery) as $image)
                            @continue(! $image)

                            <div
                                class="item"
                                data-src="{{ RvMedia::getImageUrl($imageUrl = Arr::get($image, 'img')) }}"
                                data-sub-html="{{ $description = BaseHelper::clean(Arr::get($image, 'description')) }}"
                            >
                                <div class="photo-item">
                                    <div class="thumb">
                                        <a href="{{ $description }}">
                                            {{ RvMedia::image($imageUrl, $description) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $gallery) !!}
                </div>
            </article>
        </div>
    </div>
</section>
