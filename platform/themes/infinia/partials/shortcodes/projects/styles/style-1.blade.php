<section {!! $shortcode->htmlAttributes() !!} class="shortcode-projects shortcode-projects-style-1 section-case-studies pt-120">
    @if($shortcode->title || $shortcode->subtitle || $shortcode->description)
        <div class="container position-relative z-2">
            <div class="text-center">
                @if($shortcode->subtitle)
                    <div class="d-flex align-items-center justify-content-center bg-primary-soft border border-2 border-white d-inline-flex rounded-pill px-4 py-2" data-aos="zoom-in" data-aos-delay="50">
                        <img src="{{ Theme::asset()->url('images/icons/dots.png') }}" alt="dots">
                        <span class="tag-spacing fs-7 fw-bold text-linear-2 ms-2 text-primary">{{ $shortcode->subtitle }}</span>
                    </div>
                @endif
                @if($shortcode->title)
                    <h3 class="ds-3 my-3">{!! BaseHelper::clean($shortcode->title) !!}</h3>
                @endif
                @if($shortcode->description)
                    <p class="fs-5">{!! BaseHelper::clean($shortcode->description) !!}</p>
                @endif
            </div>
        </div>
    @endif
    <div class="container mt-4 pt-7">
        <div class="row">
            @foreach($projects as $project)
                <div class="text-center col-lg-4 col-md-6">
                    <div class="zoom-img position-relative mb-4 d-inline-block z-1">
                        <div class="rounded-3 fix">
                            {{ RvMedia::image($project->image, $project->name, 'vertical_thumb', attributes: ['class' => 'img-fluid w-100']) }}
                        </div>
                        <a href="{{ $project->url }}" class="card-team text-start rounded-3 position-absolute bottom-0 start-0 end-0 z-1 backdrop-filter w-auto p-4 m-4 hover-up">
                            @if($project->client)
                                <p class="fs-7 text-primary mb-1">{{ $project->client }}</p>
                            @endif
                            <strong class="d-block fs-6">{{ $project->name }}</strong>
                            @if($project->description)
                                <p class="text-900">{!! Str::limit(BaseHelper::clean($project->description), 75) !!}</p>
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if($projects instanceof \Illuminate\Pagination\LengthAwarePaginator && $projects->hasPages())
        <div class="container">
            <div class="row pt-5 text-start">
                <div class="d-flex justify-content-start align-items-center">
                    {{ $projects->links(Theme::getThemeNamespace('partials.pagination')) }}
                </div>
            </div>
        </div>
    @endif
</section>
