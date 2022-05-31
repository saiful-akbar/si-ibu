@if ($paginator->hasPages())
    <div class="btn-group">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="btn btn-sm btn-light btn-rounded disabled" disabled>
                <i class="mdi mdi-chevron-double-left mr-1"></i>
                <span>@lang('pagination.previous')</span>
            </button>
        @else
            <a class="btn btn-sm btn-light btn-rounded" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i class="mdi mdi-chevron-double-left mr-1"></i>
                <span>@lang('pagination.previous')</span>
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn btn-sm btn-light btn-rounded" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <span>@lang('pagination.next')</span>
                <i class="mdi mdi-chevron-double-right ml-1"></i>
            </a>
        @else
            <button disabled class="btn btn-sm btn-light btn-rounded">
                <span>@lang('pagination.next')</span>
                <i class="mdi mdi-chevron-double-right"></i>
            </button>
        @endif

    </div>
@endif
