@extends('templates.main')

@section('content')

    <div class="row">

        {{-- tabs setting --}}
        <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
            <div
                class="nav flex-column nav-pills"
                id="tabs-akun-belanja"
                role="tablist"
                aria-orientation="vertical"
            >
                <a
                    href="{{ route('akun-belanja') }}"
                    class="nav-link mb-2 {{ Request::is('akun-belanja') ? 'active show' : null }}"
                >
                    <i class="uil-store-alt mr-2"></i>
                    <span>Akun Belanja</span>
                </a>
                <a
                    href="{{ route('jenis-belanja') }}"
                    class="nav-link mb-2 {{ Request::is('akun-belanja/jenis-belanja') ? 'active show' : null }}"
                >
                    <i class="uil-cart mr-2"></i>
                    <span>Jenis Belanja</span>
                </a>
            </div>

            <hr>
        </div>
        {{-- tabs setting --}}

        {{-- content --}}
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">

                            {{-- akun belanja content --}}
                            @yield('content-akun-belanja')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end content --}}

    </div>
@endsection

@section('js')
    @yield('js-akun-belanja')
@endsection
