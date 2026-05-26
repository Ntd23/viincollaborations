@php
    $projectSidebar = dynamic_sidebar('project_sidebar');
@endphp

{!! apply_filters('ads_render', null, 'project_before', ['class' => 'my-2 text-center']) !!}

<section class="container section-padding">
    <div class="row">
        <h5 class="ds-5 mt-3 mb-8">
            {!! BaseHelper::clean($project->name) !!}
        </h5>
        <div @class(['col-12', 'col-lg-8' => $projectSidebar])>
            @if($project->image)
                <div class="mb-9">
                    {{ RvMedia::image($project->image, $project->name, attributes: ['class' => 'w-100 rounded-3']) }}
                </div>
            @endif
            @if($project->client || $project->start_date || $project->author || $project->place)
                <div class="d-flex flex-column flex-md-row text-center align-items-center justify-content-between border-top border-bottom mb-7">
                    @if($project->client)
                        <div class="py-3">
                            <span class="text-500 fs-6">{{ __('Client') }}</span>
                            <p class="text-900 mb-0">{{ $project->client }}</p>
                        </div>
                    @endif
                    @if($project->start_date)
                        <div class="py-3">
                            <span class="text-500 fs-6">{{ __('Start') }}</span>
                            <p class="text-900 mb-0">{{ Theme::formatDate($project->start_date) }}</p>
                        </div>
                    @endif
                    @if($project->author)
                        <div class="py-3">
                            <span class="text-500 fs-6">{{ __('Author') }}</span>
                            <p class="text-900 mb-0">{{ $project->author }}</p>
                        </div>
                    @endif
                    @if($project->place)
                        <div class="py-3">
                            <span class="text-500 fs-6">{{ __('Place') }}</span>
                            <p class="text-900 mb-0">{{ $project->place }}</p>
                        </div>
                    @endif
                </div>
            @endif
            @if($project->description)
                <p class="fs-5 text-900">{!! BaseHelper::clean($project->description) !!}
            @endif
            <div class="ck-content">
                {!! BaseHelper::clean($project->content) !!}
            </div>
            <div class="d-flex align-items-center justify-content-end mt-5 py-3">
                <div class="d-lg-flex align-items-center">
                    <p class="fw-bold text-500 mb-0 me-2">{{ __('Share this service') }}:</p>
                    {!! Theme::renderSocialSharing($project->url, SeoHelper::getDescription(), $project->image) !!}
                </div>
            </div>
            {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $project) !!}
        </div>
        @if($projectSidebar)
            <div class="col-lg-4 d-flex flex-column gap-5">
                {!! $projectSidebar !!}
            </div>
        @endif
    </div>
</section>

{!! apply_filters('ads_render', null, 'project_after', ['class' => 'my-2 text-center']) !!}
