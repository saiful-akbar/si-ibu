<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ config('app.description') }}" />
    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="theme" content="light" />

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

    {{-- Theme CSS --}}
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="loading authentication-bg pb-0">
    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    {{ $slot }}

    {{-- Javascript --}}
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootbox.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Other javascript --}}
    @isset($script)
        {{ $script }}
    @endisset
</body>

</html>
