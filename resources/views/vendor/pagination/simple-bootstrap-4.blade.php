@if ($paginator->hasPages())
    {{-- <nav>
        <ul class="pagination">

            @if ($paginator->onFirstPage())
                <li
                    class="page-item disabled"
                    aria-disabled="true"
                >
                    <span class="page-link">
                        <i class="mdi mdi-chevron-double-left"></i>
                        <span>@lang('pagination.previous')</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a
                        class="page-link"
                        href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                    >
                        <i class="mdi mdi-chevron-double-left"></i>
                        <span>@lang('pagination.previous')</span>
                    </a>
                </li>
            @endif

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a
                        class="page-link"
                        href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                    >
                        <span>@lang('pagination.next')</span>
                        <i class="mdi mdi-chevron-double-right"></i>
                    </a>
                </li>
            @else
                <li
                    class="page-item disabled"
                    aria-disabled="true"
                >
                    <span class="page-link">
                        <span>@lang('pagination.next')</span>
                        <i class="mdi mdi-chevron-double-right"></i>
                    </span>
                </li>
            @endif

        </ul>
    </nav> --}}

    <div class="btn-group">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="btn btn-sm btn-dark btn-rounded disabled" disabled>
                <i class="mdi mdi-chevron-double-left mr-1"></i>
                <span>@lang('pagination.previous')</span>
            </button>
        @else
            <a class="btn btn-sm btn-dark btn-rounded" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i class="mdi mdi-chevron-double-left mr-1"></i>
                <span>@lang('pagination.previous')</span>
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn btn-sm btn-dark btn-rounded" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <span>@lang('pagination.next')</span>
                <i class="mdi mdi-chevron-double-right ml-1"></i>
            </a>
        @else
            <button disabled class="btn btn-sm btn-dark btn-rounded">
                <span>@lang('pagination.next')</span>
                <i class="mdi mdi-chevron-double-right"></i>
            </button>
        @endif
    </div>
@endif
