<x-layouts.auth title="Edit Jenis Belanja" back-button="{{ route('jenis-belanja') }}">
    <x-form method="PATCH" action="{{ route('jenis-belanja.update', ['jenisBelanja' => $jenisBelanja->id]) }}">
        <div class="card">
            <div class="card-header">
                <h4 class="header-title mt-2">
                    Form Edit Jenis Belanja
                </h4>
            </div>

            <div class="card-body">

                {{-- input akun_belanja_id --}}
                <div class="form-group row mb-3">
                    <label for="akun_belanja_id" class="col-md-3 col-sm-12 col-form-label">
                        Akun Belanja <small class="text-danger">*</small>
                    </label>

                    <div class="col-md-9 col-sm-12">
                        <select name="akun_belanja_id" id="akun_belanja_id" data-toggle="select2"
                            class="form-control select2 @error('akun_belanja_id') is-invalid @enderror" required>
                            <option disabled value="{{ null }}" @if (!old('akun_belanja_id', $jenisBelanja->akun_belanja_id)) selected @endif>
                                -- Pilih Akun Belanja --
                            </option>

                            @foreach ($akunBelanja as $aBelanja)
                                <option value="{{ $aBelanja->id }}" @if (old('akun_belanja_id', $jenisBelanja->akun_belanja_id) == $aBelanja->id) selected @endif>
                                    {{ $aBelanja->nama_akun_belanja }}
                                </option>
                            @endforeach
                        </select>

                        @error('akun_belanja_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- input kategori belanja --}}
                <div class="form-group row mb-3">
                    <label for="kategori_belanja" class="col-md-3 col-sm-12 col-form-label">
                        Kategori Belanja <small class="text-danger">*</small>
                    </label>

                    <div class="col-md-9 col-sm-12">
                        <input type="text" id="kategori_belanja" name="kategori_belanja"
                            placeholder="Masukan kategori belanja..."
                            value="{{ old('kategori_belanja', $jenisBelanja->kategori_belanja) }}"
                            class="form-control @error('kategori_belanja') is-invalid @enderror" />

                        @error('kategori_belanja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- input jenis_belanja (akun belanja) aktif --}}
                <div class="form-group row justify-content-end">
                    <div class="col-md-9 col-sm-12">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="active" class="custom-control-input form-control-lg" id="active"
                                value="1" @if (old('active', $jenisBelanja->active) == 1) checked @endif />

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
                    <i class="mdi mdi-close-circle"></i>
                    <span>Reset</span>
                </button>
            </div>
        </div>
    </x-form>
</x-layouts.auth>
