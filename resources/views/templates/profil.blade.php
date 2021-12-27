@extends('templates.main')

@section('title', 'Profil')

@section('content')

    {{-- profil view --}}
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="media">
                        <span class="float-left m-2 mr-4">
                            @if (Auth::user()->profil->avatar != null)
                                <img
                                    src="{{ asset('storage/' . Auth::user()->profil->avatar) }}"
                                    style="height: 100px;"
                                    alt="Avatar"
                                    class="rounded-circle avatar-lg img-thumbnail"
                                />
                            @else
                                <img
                                    src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                    style="height: 100px;"
                                    alt="Avatar"
                                    class="rounded-circle avatar-lg img-thumbnail"
                                />
                            @endif
                        </span>

                        <div class="media-body">
                            <h4 class="mt-1 mb-1 text-white">{{ Auth::user()->profil->nama_lengkap }}</h4>
                            <p class="font-13 text-white-50">{{ Auth::user()->username }}</p>

                            <ul class="mb-0 list-inline text-light">
                                <li class="list-inline-item mr-3">
                                    <h5 class="mb-1 text-white">{{ Auth::user()->active == 1 ? 'Aktif' : 'Tidak Aktif' }}</h5>
                                    <p class="mb-0 font-13 text-white-50">Status</p>
                                </li>
                                <li class="list-inline-item">
                                    <h5 class="mb-1 text-white">{{ Auth::user()->divisi->nama_divisi }}</h5>
                                    <p class="mb-0 font-13 text-white-50">{{ Auth::user()->seksi }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end profil view --}}

    <div class="row">

        {{-- tabs setting --}}
        <div class="col-md-4 col-sm-12 mb-3">
            <div
                class="nav flex-column nav-pills"
                id="tabs-profil"
                role="tablist"
                aria-orientation="vertical"
            >
                <a
                    href="{{ route('profil') }}"
                    class="nav-link mb-2 {{ Request::is('profil') ? 'active show' : null }}"
                >
                    <i class="mdi mdi-account-circle mr-2"></i>
                    <span>Profil</span>
                </a>
                <a
                    href="{{ route('profil.akun') }}"
                    class="nav-link mb-2 {{ Request::is('profil/akun') ? 'active show' : null }}"
                >
                    <i class="mdi mdi-account-box-multiple-outline mr-2"></i>
                    <span>Akun</span>
                </a>
                <a
                    {{-- href="{{ route('profil/tema') }}" --}}
                    class="nav-link mb-2 {{ Request::is('profil/tema') ? 'active show' : null }}"
                >
                    <i class="mdi mdi-settings mr-2"></i>
                    <span>Tema</span>
                </a>
            </div>

            <hr>
        </div>
        {{-- tabs setting --}}

        {{-- setting --}}
        <div class="col-md-8 col-sm-12">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">

                            {{-- profil content --}}
                            @yield('content-profil')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end setting --}}

    </div>
@endsection

@section('js')
    @yield('js-profil')
@endsection
