<x-layouts.auth title="Akun">
    <x-layouts.profile>

        {{-- Form update username --}}
        <div class="row">
            <div class="col-12 mb-3">
                <x-form action="{{ route('profil.akun.username.update') }}" method="PATCH">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title mt-2">Ubah Username</h4>
                        </div>

                        <div class="card-body">
                            <div class="row form-group">
                                <label for="username" class="col-md-4 col-sm-12 col-form-label">
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
                            <button type="submit" class="btn btn-sm btn-info mr-2">
                                <i class="mdi mdi-content-save"></i>
                                <span>Simpan</span>
                            </button>

                            <button type="reset" class="btn btn-sm btn-dark">
                                <i class="mdi mdi-close"></i>
                                <span>Reset</span>
                            </button>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
        {{-- End form update username --}}

        {{-- Form update password --}}
        <div class="row">
            <div class="col-12">
                <x-form action="{{ route('profil.akun.password.update') }}" method="PATCH">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title mt-3">Ubah Password</h4>
                        </div>

                        <div class="card-body">
                            <div class="row form-group mb-3">
                                <label for="password_lama" class="col-md-4 col-sm-12 col-form-label">
                                    Passwod Lama <small class="text-danger">*</small>
                                </label>

                                <div class="col-md-8 col-sm-12">
                                    <input
                                        required
                                        type="password"
                                        id="password_lama"
                                        name="password_lama"
                                        placeholder="Masukan password lama..."
                                        class="form-control @error('password_lama') is-invalid @enderror"
                                    />

                                    @error('password_lama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group mb-3">
                                <label for="password_baru" class="col-md-4 col-sm-12 col-form-label">
                                    Passwod Baru <small class="text-danger">*</small>
                                </label>

                                <div class="col-md-8 col-sm-12">
                                    <input
                                        required
                                        type="password"
                                        id="password_baru"
                                        name="password_baru"
                                        placeholder="Masukan password baru..."
                                        class="form-control @error('password_baru') is-invalid @enderror"
                                    />

                                    @error('password_baru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="password_konfirmasi" class="col-md-4 col-sm-12 col-form-label">
                                    Konfirmasi Password <small class="text-danger">*</small>
                                </label>

                                <div class="col-md-8 col-sm-12">
                                    <input
                                        required
                                        type="password"
                                        id="password_konfirmasi"
                                        name="password_konfirmasi"
                                        placeholder="Masukan ulang password baru..."
                                        class="form-control @error('password_konfirmasi') is-invalid @enderror"
                                    />

                                    @error('password_konfirmasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-info mr-2">
                                <i class="mdi mdi-content-save"></i>
                                <span>Simpan</span>
                            </button>

                            <button type="reset" class="btn btn-sm btn-dark">
                                <i class="mdi mdi-close"></i>
                                <span>Reset</span>
                            </button>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
        {{-- Form update password --}}

    </x-layouts.profile>
</x-layouts.auth>
