@extends('templates.main')

@section('title', 'Edit Akun Belanja')

@section('btn-kembali')
    <a href="{{ route('jenis-belanja') }}" class="btn btn-rounded btn-light btn-sm">
        <i class="mdi mdi-chevron-double-left mr-1"></i>
        <span>Kembali</span>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form class="form-horizontal"
                action="{{ route('jenis-belanja.update', ['jenisBelanja' => $jenisBelanja->id]) }}" method="post"
                autocomplete="off">

                @method('PATCH') @csrf

                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">
                            Form Edit Akun Belanja
                        </h4>
                    </div>

                    <div class="card-body">

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
                                    <input type="checkbox" name="active" class="custom-control-input form-control-lg"
                                        id="active" value="1" @if (old('active', $jenisBelanja->active) == 1) checked @endif />

                                    <label class="custom-control-label" for="active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-rounded btn-sm mr-2">
                            <i class="mdi mdi-content-save mr-1"></i>
                            <span>Simpan</span>
                        </button>

                        <button type="reset" class="btn btn-rounded btn-dark btn-sm">
                            <i class="mdi mdi-close-circle mr-1"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
