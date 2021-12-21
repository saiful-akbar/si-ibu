<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Aplikasi anggarang berbasis web laravel" />
    <meta name="author" content="Saiful Akbar" />

    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') - {{ env('APP_NAME', 'Laravel') }}</title>

    {{-- App favicon --}}
    <link href="{{ asset('assets/images/favicon.ico') }}" rel="shortcut icon" />

    {{-- google icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    {{-- font awesome --}}
    <link href="{{ asset('assets/css/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />

    {{-- App css --}}
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" disabled />
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />

    {{-- Main css --}}
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css" />

    {{-- Page css --}}
    @yield('css')

</head>

<body class="loading @isset($is_login) authentication-bg pb-0 @endisset"
    data-layout-config='{ "leftSideBarTheme": "dark", "layoutBoxed": false, "leftSidebarCondensed": false, "leftSidebarScrollable": false, "darkMode": false, "showRightSidebarOnStart": false}'>

    {{-- Pre-loader --}}
    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    {{-- Guest content --}}
    @guest
        @yield('content')
    @endguest

    {{-- Auth content --}}
    @auth
        <div class="wrapper">

            {{-- Left Sidebar Start --}}
            @include('components.organisms.sidebar-left')

            {{-- Start Page Content --}}
            <div class="content-page">
                <div class="content">

                    {{-- Topbar Start --}}
                    @include('components.organisms.topbar')

                    <div class="container-fluid pt-4 pb-4">

                        {{-- alert notifikasi --}}
                        @include('components.organisms.alert')

                        {{-- Main Content --}}
                        @yield('content')
                    </div>
                </div>

                {{-- Footer --}}
                @include('components.organisms.footer')
            </div>
            {{-- End Page content --}}

        </div>
    @endauth
    {{-- End auth content --}}

    {{-- Javascript --}}
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    {{-- bootbos alert --}}
    <script src="{{ asset('assets/js/vendor/bootbox.all.min.js') }}"></script>

    {{-- Main JS --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Javascript page --}}
    @yield('js')
</body>

</html>
