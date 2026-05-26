<div class="row">
    @foreach($posts as $post)
        <div class="col-lg-4 text-start">
            @include(Theme::getThemeNamespace('views.templates.partials.post-item'))
        </div>
    @endforeach

    @if($posts->hasPages())
        <div class="container">
            <div class="row pt-5 text-start">
                <div class="d-flex justify-content-start align-items-center">
                    {{ $posts->links(Theme::getThemeNamespace('partials.pagination')) }}
                </div>
            </div>
        </div>
    @endif
</div>
