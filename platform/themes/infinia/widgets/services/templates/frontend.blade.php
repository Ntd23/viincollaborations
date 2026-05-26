@if ($services->isNotEmpty())
    <div class="sidebar">
        @foreach($services as $service)
            <a href="{{ $service->url }}" class="btn btn-outline-secondary-2 w-100 text-start mb-2 fs-5 py-3 d-flex justify-content-between align-items-center">
                {{ $service->name }}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path class="fill-neutral-100" d="M17.4177 5.41772L16.3487 6.48681L21.1059 11.244H0V12.756H21.1059L16.3487 17.5132L17.4177 18.5822L24 12L17.4177 5.41772Z" fill="#f3f4f6" />
                </svg>
            </a>
        @endforeach
    </div>
@endif

