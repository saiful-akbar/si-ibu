@php
    /**
     * NB:
     * user_akses diisi sesuai "nama_level" pada tabel "role" di database
     * 
     * @var Array
     */
    $menu_list = [
        [
            'title' => 'Utama',
            'user_akses' => ['admin', 'staff'],
            'menu' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'uil-home-alt',
                    'href' => 'dashboard',
                    'active' => '/',
                    'user_akses' => ['admin', 'staff'],
                ],
            ],
        ],
        [
            'title' => 'Data Master',
            'user_akses' => ['admin'],
            'menu' => [
                [
                    'title' => 'Divisi',
                    'icon' => 'uil-gold',
                    'href' => 'divisi',
                    'active' => 'divisi*',
                    'user_akses' => ['admin'],
                ],
                [
                    'title' => 'User',
                    'icon' => 'uil-users-alt',
                    'href' => 'dashboard',
                    'active' => '/',
                    'user_akses' => ['admin'],
                ],
            ],
        ],
    ];
@endphp


<ul class="metismenu side-nav">

    {{-- looping heading menu --}}
    @foreach($menu_list as $heading)

        {{-- Cek akses user pada heading --}}
        @if(in_array(Auth::user()->role->level, $heading['user_akses']))
            <li class="side-nav-title side-nav-item mt-3">{{ $heading['title'] }}</li>

            {{-- looping menu --}}
            @foreach($heading['menu'] as $menu)
                <li class="side-nav-item {{ Request::is($menu['active']) ? 'mm-active' : null }}">
                    <a href="{{ route($menu['href']) }}" class="side-nav-link">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span>{{ $menu['title'] }}</span>
                    </a>
                </li>
            @endforeach
        @endif

    @endforeach
</ul>
