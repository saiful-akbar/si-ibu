<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistem informasi manajemen anggaran & arsip" />
    <meta name="author" content="Saiful Akbar" />

    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Title --}}
    <title>{{ config('app.name') }} : @yield('title')</title>

    {{-- App favicon --}}
    <link href="{{ asset('assets/images/logo/favicon.ico') }}" rel="shortcut icon" />

    {{-- icons --}}
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- costom vendor css --}}
    @stack('css')

    {{-- App css auth --}}
    @auth
        @if (auth()->user()->pengaturan->tema == 'dark')
            <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
        @else
            <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
        @endif
    @endauth

    {{-- App css guest --}}
    @guest
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    @endguest

    {{-- Main css --}}
    <link href="{{ asset('assets/css/main.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- Page css --}}
    @yield('css')
</head>

<body class="loading @guest authentication-bg pb-0 @endguest" @auth data-leftbar-theme="{{ auth()->user()->pengaturan->sidebar }}" @endauth>

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

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 py-2">
                                <div class="page-title-box d-flex justify-content-between align-items-center">
                                    <h4 class="page-title">
                                        @yield('title')
                                    </h4>

                                    @yield('btn-kembali')
                                </div>
                            </div>
                        </div>

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

        {{-- scroll to top --}}
        @include('components.molecules.scroll-to-top');
    @endauth
    {{-- End auth content --}}

    {{-- Javascript --}}
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    {{-- bootbos alert --}}
    <script src="{{ asset('assets/js/vendor/bootbox.all.min.js') }}"></script>

    {{-- Main JS --}}
    <script src="{{ asset('assets/js/main.min.js') }}"></script>

    {{-- Javascript page --}}
    @yield('js')

</body>

</html>
