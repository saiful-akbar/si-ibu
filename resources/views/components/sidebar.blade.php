<div class="left-side-menu">

    {{-- logo light --}}
    <a href="{{ route('dashboard') }}" class="logo logo-light text-center">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo/logo-light.png') }}" alt="logo" width="130" />
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo/logo-sm.png') }}" alt="logo" width="35" />
        </span>
    </a>

    {{-- logo dark --}}
    <a href="{{ route('dashboard') }}" class="logo logo-dark text-center">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" width="130" />
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo/logo-sm.png') }}" alt="logo" width="35" />
        </span>
    </a>

    {{-- Menu --}}
    <div class="h-100" id="left-side-menu-container" data-simplebar>
        <ul class="metismenu side-nav">
            @foreach ($menu->menuHeader as $menuHeader)
                @if ($menuHeader->pivot->read == 1)
                    <li class="side-nav-title side-nav-item">
                        {{ strtoupper($menuHeader->nama_header) }}
                    </li>

                    @foreach ($menu->menuItem as $menuItem)
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

        <div class="clearfix"></div>
    </div>
    {{-- End menu --}}

</div>
