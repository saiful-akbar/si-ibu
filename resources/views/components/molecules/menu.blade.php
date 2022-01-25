@php

$user = App\Models\User::with([
    'menuHeader' => fn($query) => $query->orderBy('no_urut', 'asc'),
    'menuItem' => fn($query) => $query->orderBy('nama_menu', 'asc'),
])->find(auth()->user()->id);

@endphp

<ul class="metismenu side-nav">
    @foreach ($user->menuHeader as $menuHeader)

        {{-- cek akses read menu_header --}}
        @if ($menuHeader->pivot->read == 1)
            <li class="side-nav-title side-nav-item mt-3">{{ strtoupper($menuHeader->nama_header) }}</li>

            @foreach ($user->menuItem as $menuItem)

                {{-- cek akses read menu items --}}
                @if ($menuItem->menu_header_id == $menuHeader->id && $menuItem->pivot->read == 1)
                    <li class="side-nav-item {{ Request::is(trim($menuItem->href, '/') . '*') ? 'mm-active' : null }}">
                        <a href="{{ url($menuItem->href) }}" class="side-nav-link">
                            <i class="{{ $menuItem->icon }}"></i>
                            <span>{{ ucwords($menuItem->nama_menu) }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        @endif

    @endforeach
</ul>
