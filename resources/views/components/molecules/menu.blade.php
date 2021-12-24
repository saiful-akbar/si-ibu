@php
use App\Models\User;

$user = User::with('menuHeader', 'menuItem')->find(Auth::user()->id);
@endphp

<ul class="metismenu side-nav">
    @foreach ($user->menuHeader as $menuHeader)
        @if (isset($menuHeader->pivot->read) && $menuHeader->pivot->read == 1)
            <li class="side-nav-title side-nav-item mt-3">{{ $menuHeader->nama_header }}</li>

            @foreach ($user->menuItem as $menuItem)
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
