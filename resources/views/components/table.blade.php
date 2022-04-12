@props(['paginator' => null])

<div class="table-responsive">
    <table {{ $attributes->merge(['class' => 'table-sm table-bordered table-hover table-centered table-nowrap w-100 table']) }}>
        @isset($thead)
            <thead class="thead-{{ auth()->user()->pengaturan->tema }}">
                {{ $thead }}
            </thead>
        @endisset

        @isset($tbody)
            <tbody>
                {{ $tbody }}
            </tbody>
        @endisset

        @isset($tfoot)
            <tfoot>
                {{ $tfoot }}
            </tfoot>
        @endisset
    </table>
</div>

@isset($paginator)
    {{ $paginator->links() }}
@endisset
