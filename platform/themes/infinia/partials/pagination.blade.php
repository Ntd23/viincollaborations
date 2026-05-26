@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <ul class="pagination gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path class="stroke-dark" d="M9.49554 6.5L4.78125 11L9.49554 15.5" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                            <path class="stroke-dark" d="M17.2143 11H5" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path class="stroke-dark" d="M9.49554 6.5L4.78125 11L9.49554 15.5" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                            <path class="stroke-dark" d="M17.2143 11H5" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path class="stroke-dark" d="M12.5 6.5L17.2143 11L12.5 15.5" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                            <path class="stroke-dark" d="M16.9955 11H4.78125" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path class="stroke-dark" d="M12.5 6.5L17.2143 11L12.5 15.5" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                            <path class="stroke-dark" d="M16.9955 11H4.78125" stroke="#111827" stroke-width="1.28571" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
