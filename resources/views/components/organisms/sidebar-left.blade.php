<div class="left-side-menu">

    <!-- LOGO -->
    <a
        href="{{ route('dashboard') }}"
        class="logo text-center logo-light"
    >
        <span class="logo-lg">
            <img
                src="{{ asset('assets/images/logo/logo.png') }}"
                alt=""
                height="16"
            />
        </span>
        <span class="logo-sm">
            <img
                src="{{ asset('assets/images/logo/logo_sm.png') }}"
                alt=""
                height="16"
            />
        </span>
    </a>

    <!-- LOGO -->
    <a
        href="{{ route('dashboard') }}"
        class="logo text-center logo-dark"
    >
        <span class="logo-lg">
            <img
                src="{{ asset('assets/images/logo/logo-dark.png') }}"
                alt=""
                height="16"
            />
        </span>
        <span class="logo-sm">
            <img
                src="{{ asset('assets/images/logo/logo_sm_dark.png') }}"
                alt=""
                height="16"
            />
        </span>
    </a>

    <div
        class="h-100"
        id="left-side-menu-container"
        data-simplebar
    >

        {{-- Menu --}}
        @include('components.molecules.menu')

        <div class="clearfix"></div>
    </div>
</div>
