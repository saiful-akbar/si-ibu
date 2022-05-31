@php

$tabs = [
    [
        'name' => 'Master Kategori',
        'route' => route('arsip.master.category'),
        'active' => Request::is('arsip/master') ? 'active show' : '',
        'icon' => 'uil-layer-group',
    ],
    [
        'name' => 'Master Type',
        'route' => route('arsip.master.type'),
        'active' => Request::is('arsip/master/type') ? 'active show' : '',
        'icon' => 'uil-layers-alt',
    ],
];

@endphp

<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
        <div class="nav flex-column nav-pills" id="tabs-akun-belanja" role="tablist" aria-orientation="vertical">
            @foreach ($tabs as $tab)
                <a href="{{ $tab['route'] }}" class="nav-link border-bottom {{ $tab['active'] }}">
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
