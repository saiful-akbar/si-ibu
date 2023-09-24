@if (session('alert'))
    @php
        $color = session('alert')['type'];
        $title = session('alert')['type'] == 'danger' ? 'Error' : ucwords(session('alert')['type']);
        $message = session('alert')['message'];
    @endphp

    <x-alert color="{{ $color }}" title="{{ $title }}" class="mb-4">
        {!! $message !!}
    </x-alert>
@endif

@if ($errors->any())
    <x-alert color="danger" title="Error" class="mb-4">
        <ul class="ml-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
