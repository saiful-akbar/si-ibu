@extends('templates.profil')

@section('title', 'Akun')

@section('content-profil')

    {{-- form ubah username --}}
    <div class="row">
        <div class="col-12 mb-3">

            <form
                action="{{ route('profil.akun.username.update') }}"
                method="POST"
            >
                @method('PATCH') @csrf

                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Username</h4>
                    </div>

                    <div class="card-body">
                        <div class="row form-group">
                            <label
                                for="username"
                                class="col-md-4 col-sm-12 col-form-label"
                            >
                                Username <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-8 col-sm-12">
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
                    </div>

                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-sm btn-info btn-rounded mr-2"
                        >
                            <i class="mdi mdi-content-save"></i>
                            <span>Simpan</span>
                        </button>

                        <button
                            type="reset"
                            class="btn btn-sm btn-rounded btn-dark"
                        >
                            <i class="mdi mdi-close-circle"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- form ubah password --}}
    <div class="row">
        <div class="col-12">
            <form
                action="{{ route('profil.akun.password.update') }}"
                method="POST"
            >
                @method('PATCH') @csrf

                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Password</h4>
                    </div>

                    <div class="card-body">

                        {{-- input password lama --}}
                        <div class="row form-group mb-3">
                            <label
                                for="passwordLama"
                                class="col-md-4 col-sm-12 col-form-label"
                            >
                                Passwod Lama <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-8 col-sm-12">
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
                        <div class="row form-group mb-3">
                            <label
                                for="passwordBaru"
                                class="col-md-4 col-sm-12 col-form-label"
                            >
                                Passwod Baru <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-8 col-sm-12">
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

                        {{-- input password konfirmasi --}}
                        <div class="row form-group">
                            <label
                                for="passwordKonfirmasi"
                                class="col-md-4 col-sm-12 col-form-label"
                            >
                                Konfirmasi Password <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-8 col-sm-12">
                                <input
                                    required
                                    type="password"
                                    id="passwordKonfirmasi"
                                    name="passwordKonfirmasi"
                                    placeholder="Masukan ulang password baru..."
                                    class="form-control @error('passwordKonfirmasi') is-invalid @enderror"
                                />

                                @error('passwordKonfirmasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div> {{-- end card-body --}}

                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-sm btn-info btn-rounded mr-2"
                        >
                            <i class="mdi mdi-content-save"></i>
                            <span>Simpan</span>
                        </button>

                        <button
                            type="reset"
                            class="btn btn-sm btn-rounded btn-dark"
                        >
                            <i class="mdi mdi-close-circle"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
