@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="mdi mdi-chevron-double-left"></i>
                        <span>@lang('pagination.previous')</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="mdi mdi-chevron-double-left"></i>
                        <span>@lang('pagination.previous')</span>
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span>@lang('pagination.next')</span>
                        <i class="mdi mdi-chevron-double-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <span>@lang('pagination.next')</span>
                        <i class="mdi mdi-chevron-double-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
