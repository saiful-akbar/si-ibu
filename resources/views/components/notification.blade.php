@if (session('alert'))
    @php
        $color = session('alert')['type'];
        $title = session('alert')['type'] == 'danger' ? 'Error' : ucwords(session('alert')['type']);
        $message = session('alert')['message'];
    @endphp

    <div class="row">
        <div class="col-12 mb-3">
            <x-alert color="{{ $color }}" title="{{ $title }}">
                {!! $message !!}
            </x-alert>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="row">
        <div class="col-12 mb-3">
            <x-alert color="danger" title="Error">
                <ul class="ml-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        </div>
    </div>
@endif
