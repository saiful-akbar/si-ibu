@if ($paginator->hasPages())
    <div class="row">
        <div class="col-md-6 col-sm-12 d-flex justify-content-md-start justify-content-center align-items-center mb-3">
            Hal {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </div>

        <div class="col-md-6 col-sm-12 d-flex justify-content-md-end justify-content-center align-items-center mb-3">
            <nav>
                <ul class="pagination mb-0">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">
                                <i class="uil-left-arrow-to-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url(1) }}" rel="prev"
                                aria-label="@lang('pagination.previous')">
                                <i class="uil-left-arrow-to-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @elseif($url == $paginator->nextPageUrl() || $url == $paginator->previousPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next"
                                aria-label="@lang('pagination.next')">
                                <i class="uil-arrow-to-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">
                                <i class="uil-arrow-to-right"></i>
                            </span>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </div>
@endif
