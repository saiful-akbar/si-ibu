<x-layouts.auth title="Tambah Akun Belanja" back-button="{{ route('akun-belanja') }}">
    <x-form method="POST" action="{{ route('akun-belanja.store') }}">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">
                            Form tambah akun belanja
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label for="nama_akun_belanja" class="col-md-3 col-sm-12 col-form-label">
                                Nama Akun Belanja <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input type="text" id="nama_akun_belanja" name="nama_akun_belanja"
                                    placeholder="Masukan nama akun belanja..." value="{{ old('nama_akun_belanja') }}"
                                    class="form-control @error('nama_akun_belanja') is-invalid @enderror" required />

                                @error('nama_akun_belanja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-md-9 col-sm-12">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="active" class="custom-control-input form-control-lg" id="active"
                                        @if (old('active', 1)) checked @endif value="1" />

                                    <label class="custom-control-label" for="active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-sm mr-2">
                            <i class="mdi mdi-content-save"></i>
                            <span>Simpan</span>
                        </button>

                        <button type="reset" class="btn btn-dark btn-sm">
                            <i class="mdi mdi-close"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-form>
</x-layouts.auth>
