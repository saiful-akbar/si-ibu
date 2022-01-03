@extends('templates.main')

@section('title', 'Tambah Akun Belanja')

@section('content')
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a href="{{ route('jenis-belanja') }}" class="btn btn-rounded btn-dark">
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Form Tambah Akun Belanja</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal" action="{{ route('jenis-belanja.store') }}" method="post"
                                autocomplete="off">
                                @method('POST')
                                @csrf

                                {{-- input kategori belanja --}}
                                <div class="form-group row mb-3">
                                    <label for="kategori_belanja" class="col-md-3 col-sm-12 col-form-label">
                                        Kategori Belanja <small class="text-danger">*</small>
                                    </label>

                                    <div class="col-md-9 col-sm-12">
                                        <input type="text" id="kategori_belanja" name="kategori_belanja"
                                            placeholder="Masukan kategori belanja..."
                                            value="{{ old('kategori_belanja') }}"
                                            class="form-control @error('kategori_belanja') is-invalid @enderror" required />

                                        @error('kategori_belanja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- input jenis_belanja (akun belanja) aktif --}}
                                <div class="form-group row justify-content-end mb-3">
                                    <div class="col-md-9 col-sm-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="active"
                                                class="custom-control-input form-control-lg" id="active"
                                                @if (old('active', true)) checked @endif />

                                            <label class="custom-control-label" for="active">
                                                Aktif
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- button submit & reset --}}
                                <div class="form-group mb-0 justify-content-end row">
                                    <div class="col-md-9 col-sm-12">
                                        <button type="submit" class="btn btn-info btn-rounded mr-2">
                                            <i class="mdi mdi-content-save"></i>
                                            <span>Simpan</span>
                                        </button>

                                        <button type="reset" class="btn btn-rounded btn-secondary">
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
        </div>
    </div>
@endsection
