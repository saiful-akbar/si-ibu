@props(['method' => 'GET'])

<form autocomplete="off" method="{{ $method == 'GET' ? 'GET' : 'POST' }}" {{ $attributes }}>
    @csrf
    @method($method)

    {{ $slot }}
</form>
