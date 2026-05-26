<section class="section-team-detail-1 pt-80px pb-120">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex flex-lg-row flex-column align-items-center p-5 rounded-4 bg-white shadow-2">
                    {{ RvMedia::image($team->photo, $team->name, attributes: ['class' => 'team-detail-avatar rounded-3 mb-lg-0 mb-5']) }}
                    <div class="mx-lg-8">
                        <h3>{{ $team->name }}</h3>
                        @if ($teamTitle = $team->title)
                            <p class="fs-5 mb-4">{{ $teamTitle }}</p>
                        @endif

                        @if ($teamDescription = $team->description)
                            <p class="fs-5 text-900 mb-5">
                                "{!! BaseHelper::clean($teamDescription) !!}"
                            </p>
                        @endif

                        <div @class(['pt-5 mt-4 d-flex flex-md-row flex-column align-items-center', 'border-top' => ($team->phone || $team->email || $team->address || $team->website) || ! empty($team->socials)])>
                            @if($team->phone || $team->email || $team->address || $team->website)
                                <div class="p team-detail-contact">
                                    @if($team->phone)
                                        <div class="d-flex mb-3">
                                            <x-core::icon name="ti ti-phone" />
                                            <a class="ms-2 text-decoration-underline text-900 fs-7" href="tel:{{ $team->phone }}">{{ $team->phone }}</a>
                                        </div>
                                    @endif
                                    @if($team->email)
                                        <div class="d-flex mb-3">
                                            <x-core::icon name="ti ti-mail" />
                                            <a class="ms-2 text-decoration-underline text-900 fs-7" href="mailto:{{ $team->email }}">{{ $team->email }}</a>
                                        </div>
                                    @endif
                                    @if($team->address)
                                        <div class="d-flex mb-3">
                                            <x-core::icon name="ti ti-location-pin" />
                                            <span class="ms-2 text-decoration-underline text-900 fs-7">{!! BaseHelper::clean($team->address) !!}</span>
                                        </div>
                                    @endif
                                    @if($team->website)
                                        <a href="{{ $team->website }}" class="d-flex">
                                            <x-core::icon name="ti ti-world" />
                                            <span class="ms-2 text-decoration-underline text-900 fs-7">{{ $team->website }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                            @if(! empty($team->socials))
                                <div class="ps-md-10 ms-md-10 mt-md-0 mt-5">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-8">
            <div @class(['mt-lg-0 mt-8 content-left', 'col-lg-7 pe-lg-5' => $teamSidebar, 'col-12' => ! $teamSidebar])>
                <div class="ck-content">
                    {!! BaseHelper::clean($team->content) !!}
                </div>
            </div>

            @if($teamSidebar)
                <div class="col-lg-5 ps-lg-8 content-right mt-lg-0 mt-5">
                    {!! $teamSidebar !!}
                </div>
            @endif
        </div>
    </div>
</section>
