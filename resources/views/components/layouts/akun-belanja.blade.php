@php

$tabs = [
    [
        'name' => 'Akun Belanja',
        'route' => 'akun-belanja',
        'active' => Request::is('akun-belanja') ? 'active show' : '',
        'icon' => 'uil-store-alt',
    ],
    [
        'name' => 'Jenis Belanja',
        'route' => 'jenis-belanja',
        'active' => Request::is('akun-belanja/jenis-belanja') ? 'active show' : '',
        'icon' => 'uil-cart',
    ],
];

@endphp

<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
        <div class="nav flex-column nav-pills" id="tabs-akun-belanja" role="tablist" aria-orientation="vertical">
            @foreach ($tabs as $tab)
                <a href="{{ route($tab['route']) }}" class="nav-link border-bottom {{ $tab['active'] }}">
                    <i class="{{ $tab['icon'] }} mr-2"></i>
                    <span>{{ $tab['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="col-lg-9 col-md-8 col-sm-12">
        <div class="row">
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
