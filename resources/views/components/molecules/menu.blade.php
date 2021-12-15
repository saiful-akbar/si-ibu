@php
    /**
     * NB:
     * divisi_akses diisi sesuai nama_divisi pada database
     * 
     * @var Array
     */
    $menu_list = [
        [
            'title' => 'Utama',
            'divisi_akses' => 'all',
            'menu' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'uil-home-alt',
                    'href' => 'dashboard',
                    'active' => '/',
                    'divisi_akses' => 'all',
                    'submenu' => [],
                ],
            ],
        ],
        [
            'title' => 'Data Master'
        ]
    ];
@endphp


<ul class="metismenu side-nav">

    @foreach($menu_list as $heading)
        <li class="side-nav-title side-nav-item">{{ $heading['title'] }}</li>

        @foreach($heading['menu'] as $menu)
            <li class="side-nav-item {{ Request::is($menu['active']) ? 'mm-active' : null }}">
                <a href="{{ route($menu['href']) }}" class="side-nav-link">
                    <i class="{{ $menu['icon'] }}"></i>
                    <span>{{ $menu['title'] }}</span>
                </a>
            </li>
        @endforeach
    @endforeach

    <li class="side-nav-title side-nav-item">Apps</li>

    <li class="side-nav-item">
        <a href="apps-chat.html" class="side-nav-link">
            <i class="uil-comments-alt"></i>
            <span> Chat </span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="javascript: void(0);" class="side-nav-link">
            <i class="uil-store"></i>
            <span> Ecommerce </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level" aria-expanded="false">
            <li>
                <a href="apps-ecommerce-products.html">Products</a>
            </li>
            <li>
                <a href="apps-ecommerce-products-details.html">Products Details</a>
            </li>
        </ul>
    </li>
</ul>
