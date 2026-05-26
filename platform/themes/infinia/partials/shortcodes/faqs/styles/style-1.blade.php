<div {!! $shortcode->htmlAttributes() !!} class="accordion">
    @php
        $keyId = 'faq-' . uniqid();
    @endphp

    @foreach($faqs as $faq)
        <div class="px-0 card p-3 border-0 border-bottom bg-transparent rounded-0">
            <div class="px-0 card-header border-0 bg-gradient-1">
                <a class="collapsed text-900 fw-bold d-flex align-items-center" data-bs-toggle="collapse" href="#{{ $keyId }}-{{ $loop->iteration }}">
                    <span class="icon-shape icon-xs fs-7 rounded-circle d-none d-md-block me-3 bg-primary text-white">{{ $loop->iteration }}</span>
                    <strong class="d-block fs-6 m-0">{!! BaseHelper::clean($faq->question) !!}</strong>
                    <span class="ms-auto arrow me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none">
                            <path class="stroke-dark" d="M11.5 1L6.25 6.5L1 1" stroke="#111827" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </a>
            </div>
            <div id="{{ $keyId }}-{{ $loop->iteration }}" @class(['collapse', 'show' => $loop->first]) data-bs-parent=".accordion">
                <p class="px-0 card-body fs-6 text-600 mb-0">{!! BaseHelper::clean($faq->answer) !!}</p>
            </div>
        </div>
    @endforeach
</div>
