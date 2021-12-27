@extends('templates.main')

@section('title', 'Profil')

@section('content')
    <div class="row">

        {{-- profil view --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card text-center">
                <div class="card-body bg-primary text-white">
                    @if (Auth::user()->profil->avatar != null)
                        <img
                            src="{{ asset('storage/' . Auth::user()->profil->avatar) }}"
                            class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image"
                        />
                    @else
                        <img
                            src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                            class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image"
                        />
                    @endif

                    <h4 class="mb-0 mt-2">{{ Auth::user()->profil->nama_lengkap }}</h4>
                    <p class="text-white font-14">{{ Auth::user()->divisi->nama_divisi }}</p>
                </div>
            </div>
        </div>
        {{-- end profil view --}}

        {{-- setting profil --}}
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a
                                        href="{{ route('profil') }}"
                                        class="nav-link rounded-0 {{ Request::is('profil') ? 'active' : null }}"
                                    >
                                        Profil
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="#timeline"
                                        class="nav-link rounded-0 {{ Request::is('profil/akun') ? 'active' : null }}"
                                    >
                                        Akun
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="#settings"
                                        class="nav-link rounded-0 {{ Request::is('profil/tema') ? 'active' : null }}"
                                    >
                                        Tema
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane show active">

                            {{-- profil content --}}
                            @yield('profil-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end setting profil --}}

    </div>
@endsection
