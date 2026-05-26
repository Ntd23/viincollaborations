<section class="section-team-detail-2 pt-80 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                {{ RvMedia::image($team->photo, $team->name, attributes: ['class' => 'team-detail-avatar rounded-3 mb-lg-0 mb-5']) }}
            </div>
            <div class="col-lg-8">
                <div class="ps-lg-5 mt-lg-0 mt-5">
                    <h3>{{ $team->name }}</h3>

                    @if ($teamTitle = $team->title)
                        <p class="fs-5 mb-4">{{ $teamTitle }}</p>
                    @endif

                    @if ($teamDescription = $team->description)
                        <p class="fs-5 text-900 mb-4">"{!! BaseHelper::clean($teamDescription) !!}"</p>
                    @endif

                    @if(! empty($team->socials))
                        <div class="mt-5 mb-5">
                            <p class="fw-bold text-900">{{ __('Social Networks') }}</p>
                            <div class="d-flex social-icons">
                                @foreach($team->socials as $key => $value)
                                    @php
                                        $key = $key === 'twitter' ? 'x' : $key;
                                    @endphp
                                    <a href="{{ $value }}" @class(['text-900 border border-opacity-10 icon-shape icon-md', 'border-end-0' => ! $loop->last])>
                                        <x-core::icon name="ti ti-brand-{{ $key }}" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="ck-content">
                        {!! BaseHelper::clean($team->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
