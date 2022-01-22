<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistem informasi manajemen anggaran & arsip" />
    <meta name="author" content="Saiful Akbar" />

    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- PWA --}}
    @laravelPWA

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
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css" />

    {{-- Page css --}}
    @yield('css')
</head>

<body class="loading">

    {{-- content --}}
    @yield('content')

    {{-- Javascript --}}
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Javascript page --}}
    @yield('js')

</body>

</html>
