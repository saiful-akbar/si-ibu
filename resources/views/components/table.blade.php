@props(['paginator' => null, 'thead', 'tbody', 'tfoot'])

<div class="table-responsive">
    <table
        {{ $attributes->merge(['class' => 'table-sm table-bordered table-hover table-centered table-nowrap w-100 mb-2 table']) }}>
        @isset($thead)
            <thead class="thead-{{ auth()->user()->pengaturan->tema }}" {{ $thead->attributes }}>
                {{ $thead }}
            </thead>
        @endisset

        @isset($tbody)
            <tbody {{ $tbody->attributes }}>
                {{ $tbody }}
            </tbody>
        @endisset

        @isset($tfoot)
            <tfoot {{ $tfoot->attributes }}>
                {{ $tfoot }}
            </tfoot>
        @endisset
    </table>
</div>

@isset($paginator)
    {{ $paginator->links() }}
@endisset
