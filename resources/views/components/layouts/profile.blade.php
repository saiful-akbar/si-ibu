@php

$tabs = [
    [
        'name' => 'Profil',
        'route' => route('profil'),
        'active' => Request::is('profil') ? 'active show' : '',
        'icon' => 'mdi mdi-account-circle',
    ],
    [
        'name' => 'Akun',
        'route' => route('profil.akun'),
        'active' => Request::is('profil/akun') ? 'active show' : '',
        'icon' => 'mdi mdi-account-box-multiple-outline',
    ],
    [
        'name' => 'Pengaturan',
        'route' => route('profil.pengaturan'),
        'active' => Request::is('profil/pengaturan') ? 'active show' : '',
        'icon' => 'mdi mdi-settings',
    ],
];

@endphp

<div class="row">
    <div class="col-sm-12 col-mb-3">
        <div class="card bg-primary">
            <div class="card-body profile-user-box">
                <div class="media">
                    <span class="float-left m-2 mr-4">
                        @isset (auth()->user()->profil->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->profil->avatar) }}"
                                width="100"
                                height="100"
                                alt="Avatar"
                                loading="lazy"
                                class="rounded-circle avatar-lg img-thumbnail"
                            />
                        @else
                            <img
                                src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                width="100"
                                height="100"
                                alt="Avatar"
                                loading="lazy"
                                class="rounded-circle avatar-lg img-thumbnail"
                            />
                        @endisset
                    </span>

                    <div class="media-body">
                        <h4 class="mt-1 mb-1 text-white">
                            {{ auth()->user()->profil->nama_lengkap }}
                        </h4>

                        <p class="font-13 text-white-50">
                            {{ auth()->user()->username }}
                        </p>

                        <ul class="mb-0 list-inline text-light">
                            <li class="list-inline-item mr-3">
                                <h5 class="mb-1 text-white">
                                    {{ auth()->user()->active ? 'Aktif' : 'Tidak Aktif' }}
                                </h5>

                                <p class="mb-0 font-13 text-white-50">Status</p>
                            </li>

                            <li class="list-inline-item">
                                <h5 class="mb-1 text-white">
                                    {{ auth()->user()->divisi->nama_divisi }}
                                </h5>
                                
                                <p class="mb-0 font-13 text-white-50">
                                    {{ auth()->user()->seksi }}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabs --}}
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
        <div class="nav flex-column nav-pills" id="tabs-profil" role="tablist" aria-orientation="vertical">
            @foreach ($tabs as $tab)
                <a href="{{ $tab['route'] }}" class="nav-link border-bottom {{ $tab['active'] }}">
                    <i class="{{ $tab['icon'] }} mr-2"></i>
                    <span>{{ $tab['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="col-lg-9 col-md-8 col-sm-12 mb-3">
        <div class="tab-content">
            <div class="tab-pane fade show active">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>