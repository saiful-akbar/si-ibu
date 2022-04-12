<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="{{ $user->pengaturan->tema }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ config('app.description') }}" />
    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="theme" content="{{ $user->pengaturan->tema }}" />

    {{-- Title --}}
    <title>
        {{ $title }} - {{ config('app.name') }}
    </title>

    {{-- Favicon & icons --}}
    <link href="{{ asset('assets/images/logo/favicon.ico') }}" rel="shortcut icon" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- Custom vendor css --}}
    @isset($style)
        {{ $style }}
    @endisset

    {{-- Theme css --}}
    @if (auth()->user()->pengaturan->tema == 'dark')
        <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    @else
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    @endif

    {{-- Main css --}}
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="loading" data-leftbar-theme="{{ $user->pengaturan->sidebar }}">
    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <x-sidebar></x-sidebar>

        <div class="content-page">
            <div class="content">
                <x-topbar></x-topbar>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 py-2">
                            <div class="page-title-box d-flex justify-content-between align-items-center">
                                <h4 class="page-title">
                                    {{ $title }}
                                </h4>

                                @isset($backButton)
                                    <a href="{{ $backButton }}" class="btn btn-dark btn-sm">
                                        <i class="mdi mdi-arrow-left"></i>
                                        <span>Kembali</span>
                                    </a>
                                @endisset
                            </div>
                        </div>
                    </div>

                    <x-notification></x-notification>

                    {{ $slot }}
                </div>
            </div>

            <x-footer></x-footer>
        </div>
    </div>

    {{-- Button scroll to top --}}
    <x-scroll-to-top></x-scroll-to-top>

    {{-- Javascript --}}
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootbox.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Other Javascript --}}
    @isset($script)
        {{ $script }}
    @endisset
</body>

</html>
