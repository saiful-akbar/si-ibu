@extends('templates.main')

@section('title', 'Tambah Bagian')

@section('btn-kembali')
    <a
        href="{{ route('divisi') }}"
        class="btn btn-rounded btn-secondary btn-sm"
    >
        <i class="mdi mdi-chevron-double-left mr-1"></i>
        <span>Kembali</span>
    </a>
@endsection

@section('content')

    {{-- form tambah divisi --}}
    <div class="row">
        <div class="col-12">
            <form
                class="form-horizontal"
                action="{{ route('divisi.store') }}"
                method="post"
                autocomplete="off"
            >
                @method('POST') @csrf

                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Form Tambah Bagian</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                {{-- input nama divisi --}}
                                <div class="form-group row mb-3">
                                    <label
                                        for="nama_divisi"
                                        class="col-md-3 col-sm-12 col-form-label"
                                    >
                                        Nama Bagian <small class="text-danger">*</small>
                                    </label>

                                    <div class="col-md-9 col-sm-12">
                                        <input
                                            required
                                            type="text"
                                            id="nama_divisi"
                                            name="nama_divisi"
                                            placeholder="Masukan nama bagian..."
                                            value="{{ old('nama_divisi') }}"
                                            class="form-control @error('nama_divisi') is-invalid @enderror"
                                        />

                                        @error('nama_divisi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- input divisi (bagian) aktif --}}
                                <div class="form-group row justify-content-end">
                                    <div class="col-md-9 col-sm-12">
                                        <div class="custom-control custom-switch">
                                            <input
                                                type="checkbox"
                                                name="active"
                                                class="custom-control-input form-control-lg"
                                                id="active"
                                                @if (old('active', true)) checked @endif
                                            />

                                            <label
                                                class="custom-control-label"
                                                for="active"
                                            >
                                                Aktif
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-info btn-sm btn-rounded mr-2"
                        >
                            <i class="mdi mdi-content-save mr-1"></i>
                            <span>Simpan</span>
                        </button>

                        <button
                            type="reset"
                            class="btn btn-rounded btn-sm btn-dark"
                        >
                            <i class="mdi mdi-close-circle mr-1"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end form tambah divisi --}}

@endsection
