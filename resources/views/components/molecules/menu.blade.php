@php

// data user login
$authUser = App\Models\User::find(Auth::user()->id);

// menu headers
$menuHeaders = $authUser
    ->menuHeader()
    ->orderBy('no_urut', 'asc')
    ->get();

// menu items
$menuItems = $authUser
    ->menuItem()
    ->orderBy('nama_menu', 'asc')
    ->get();

@endphp

<ul class="metismenu side-nav">
    @foreach ($menuHeaders as $menuHeader)

        {{-- cek akses read menu_header --}}
        @if (isset($menuHeader->pivot->read) && $menuHeader->pivot->read == 1)
            <li class="side-nav-title side-nav-item mt-3">{{ ucwords($menuHeader->nama_header) }}</li>

            @foreach ($menuItems as $menuItem)

                {{-- Cek akses read menu_items --}}
                @if ($menuItem->menu_header_id == $menuHeader->id && $menuItem->pivot->read == 1)
                    <li class="side-nav-item {{ Request::is(trim($menuItem->href, '/') . '*') ? 'mm-active' : null }}">
                        <a href="{{ url($menuItem->href) }}" class="side-nav-link">
                            <i class="{{ $menuItem->icon }}" style="font-size: 1em;"></i>
                            <span>{{ ucwords($menuItem->nama_menu) }}</span>
                        </a>
                    </li>
                @endif

            @endforeach
        @endif

    @endforeach
</ul>
