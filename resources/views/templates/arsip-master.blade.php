@extends('templates.main')

@section('content')

    <div class="row">

        {{-- tabs setting --}}
        <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
            <div class="nav flex-column nav-pills" id="tabs-arsip-master" role="tablist" aria-orientation="vertical">
                <a href="{{ route('arsip.master.category') }}"
                    class="nav-link mb-2 {{ Request::is('arsip/master') ? 'active show' : null }}">
                    <i class="uil-layer-group mr-2"></i>
                    <span>Master Kategori</span>
                </a>
                <a href="{{ route('arsip.master.type') }}"
                    class="nav-link mb-2 {{ Request::is('arsip/master/type') ? 'active show' : null }}">
                    <i class="uil-layers-alt mr-2"></i>
                    <span>Master type</span>
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
                            @yield('content-arsip-master')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end content --}}

    </div>
@endsection

@section('js')
    @yield('js-arsip-master')
@endsection
