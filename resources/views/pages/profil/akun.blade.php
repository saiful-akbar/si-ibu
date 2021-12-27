@extends('templates.profil')

@section('title', 'Akun')

@section('content-profil')

    {{-- form ubah username --}}
    <div class="row">
        <div class="col-12 mb-3">

            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Ubah Username</h4>
                </div>

                <div class="card-body">
                    <form
                        action="{{ route('profil.akun.username.update') }}"
                        method="POST"
                    >
                        @method('PATCH')
                        @csrf

                        {{-- input username --}}
                        <div class="row">
                            <div class="col-12 form-group mb-3">
                                <label for="username">
                                    Username <small class="text-danger">*</small>
                                </label>

                                <input
                                    required
                                    type="text"
                                    id="username"
                                    name="username"
                                    placeholder="Masukan username..."
                                    value="{{ old('username', Auth::user()->username) }}"
                                    class="form-control @error('username') is-invalid @enderror"
                                />

                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end input nama lengkap --}}

                        {{-- button submit & reset --}}
                        <div class="row">
                            <div class="col-12">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-info btn-rounded mr-2"
                                >
                                    <i class="mdi mdi-content-save"></i>
                                    <span>Simpan</span>
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-sm btn-rounded btn-secondary"
                                >
                                    <i class="mdi mdi-close"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- form ubah password --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Ubah Password</h4>
                </div>

                <div class="card-body">
                    <form
                        action="{{ route('profil.akun.password.update') }}"
                        method="POST"
                    >
                        @method('PATCH')
                        @csrf

                        {{-- input password lama --}}
                        <div class="row">
                            <div class="col-12 form-group mb-3">
                                <label for="passwordLama">
                                    Passwod Lama <small class="text-danger">*</small>
                                </label>

                                <input
                                    required
                                    type="password"
                                    id="passwordLama"
                                    name="passwordLama"
                                    placeholder="Masukan password lama..."
                                    class="form-control @error('passwordLama') is-invalid @enderror"
                                />

                                @error('passwordLama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input password baru --}}
                        <div class="row">
                            <div class="col-12 form-group mb-3">
                                <label for="passwordBaru">
                                    Passwod Baru <small class="text-danger">*</small>
                                </label>

                                <input
                                    required
                                    type="password"
                                    id="passwordBaru"
                                    name="passwordBaru"
                                    placeholder="Masukan password baru..."
                                    class="form-control @error('passwordBaru') is-invalid @enderror"
                                />

                                @error('passwordBaru')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input password confirm --}}
                        <div class="row">
                            <div class="col-12 form-group mb-3">
                                <label for="passwordKonfirmasi">
                                    Konfirmasi Password <small class="text-danger">*</small>
                                </label>

                                <input
                                    required
                                    type="password"
                                    id="passwordKonfirmasi"
                                    name="passwordKonfirmasi"
                                    placeholder="Ketik ulang password baru..."
                                    class="form-control @error('passwordKonfirmasi') is-invalid @enderror"
                                />

                                @error('passwordKonfirmasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- button submit & reset --}}
                        <div class="row">
                            <div class="col-12">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-info btn-rounded mr-2"
                                >
                                    <i class="mdi mdi-content-save"></i>
                                    <span>Simpan</span>
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-sm btn-rounded btn-secondary"
                                >
                                    <i class="mdi mdi-close"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
