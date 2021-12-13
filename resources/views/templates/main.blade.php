<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Multipurpose Admin & Dashboard Template" />
    <meta name="author" content="Saiful Akbar" />
    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>

    {{-- App favicon --}}
    <link href="{{ asset('assets/images/favicon.ico') }}" rel="shortcut icon" />

    {{-- Vendor css --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" id="bootstrap-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" id="app-style" />

    {{-- Main Css --}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />

    {{-- Css page --}}
    @yield('css')
</head>

<body data-sidebar="dark">

    {{-- Preloader --}}
    <div id="pre-loader">
        <h5>Loading...</h5>
    </div>

    {{-- layout-wrapper --}}
    <div id="layout-wrapper">

        {{-- Top bar --}}
        @include('components.organisms.topbar')

        {{-- Left Sidebar Start --}}
        @include('components.organisms.sidebar-left')

        {{-- Main content here --}}
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="page-title-box">
                                <h4 class="font-size-18">
                                    @yield('title')
                                </h4>
                            </div>
                        </div>
                    </div>

                    {{-- content --}}
                    @yield('content')
                </div>
            </div>

            {{-- Footer --}}
            @include('components.organisms.footer')
        </div>
        {{-- End main content --}}

    </div>
    {{-- End layout-wrapper --}}

    {{-- Right Sidebar --}}
    @include('components.organisms.sidebar-right')

    {{-- Javascript --}}
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- Main JS --}}
    <script src="{{ asset('js/main.js') }}"></script>

    {{-- Javascript page --}}
    @yield('js')
</body>

</html>
