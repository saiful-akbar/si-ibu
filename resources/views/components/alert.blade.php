@props([
    'color' => 'primary',
    'dismissible' => true,
    'title',
])

<div {{ $attributes->merge(['class' => "alert alert-{$color} alert-dismissible fade show"]) }} role="alert">
    @if ($dismissible)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif

    @isset($title)
        <h4 class="alert-heading">{{ $title }}</h4>
        <hr>
    @endisset

    <p class="mb-0">{{ $slot }}</p>
</div>
