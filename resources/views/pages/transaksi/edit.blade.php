@extends('templates.main')

@section('title', 'Edit Belanja')

@push('css')
    <link
        href="{{ asset('assets/css/vendor/summernote-bs4.css') }}"
        rel="stylesheet"
        type="text/css"
    />
@endpush

@section('content')

    {{-- button kembali --}}
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a
                href="{{ route('belanja') }}"
                class="btn btn-dark btn-rounded"
            >
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- Form input budget --}}
    <form
        action="{{ route('belanja.update', ['transaksi' => $transaksi->id]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf

        {{-- form divisi, tanggal & approval --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Form Edit Belanja</h4>
                    </div>

                    <div class="card-body">

                        {{-- input tanggal --}}
                        <div class="form-group row mb-3">
                            <label
                                for="tanggal"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Tanggal <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    type="date"
                                    id="tanggal"
                                    name="tanggal"
                                    placeholder="Masukan tanggal..."
                                    value="{{ old('tanggal', $transaksi->tanggal) }}"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    required
                                />

                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input nama approval --}}
                        <div class="form-group row mb-3">
                            <label
                                for="approval"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Nama Approval <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    type="text"
                                    id="approval"
                                    name="approval"
                                    placeholder="Masukan nama approval..."
                                    value="{{ old('approval', $transaksi->approval) }}"
                                    class="form-control @error('approval') is-invalid @enderror"
                                    required
                                />

                                @error('approval')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- form divisi, tanggal & approval --}}

        {{-- input kegiatan, jumlah nominal & uraian --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Edit Kegiatan</h4>
                    </div>

                    <div class="card-body">

                        {{-- Input jenis belanja --}}
                        <div class="form-group row mb-3">
                            <label
                                for="jenis_belanja_id"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Jenis Belanja <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select
                                    name="jenis_belanja_id"
                                    id="jenis_belanja_id"
                                    class="custom-select @error('jenis_belanja_id') is-invalid @enderror"
                                    required
                                >
                                    <option
                                        disabled
                                        @if (!old('jenis_belanja_id')) selected @endif
                                    >
                                        -- Pilih Jenis Belanja --
                                    </option>

                                    @foreach ($jenisBelanja as $jBelanja)
                                        <option
                                            value="{{ $jBelanja->id }}"
                                            @if (old('jenis_belanja_id', $transaksi->jenis_belanja_id) == $jBelanja->id) selected @endif
                                        >
                                            {{ ucwords($jBelanja->kategori_belanja) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('jenis_belanja_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input kegiatan --}}
                        <div class="form-group row mb-3">
                            <label
                                for="kegiatan"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Kegiatan <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    type="text"
                                    id="kegiatan"
                                    name="kegiatan"
                                    placeholder="Masukan kegiatan..."
                                    value="{{ old('kegiatan', $transaksi->kegiatan) }}"
                                    class="form-control @error('kegiatan') is-invalid @enderror"
                                    required
                                />

                                @error('kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input jumlah_nominal --}}
                        <div class="form-group row mb-3">
                            <label
                                for="jumlah_nominal"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Jumlah Nominal <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    type="number"
                                    id="jumlah_nominal"
                                    name="jumlah_nominal"
                                    min="0"
                                    placeholder="Masukan jumlah nominal..."
                                    value="{{ old('jumlah_nominal', $transaksi->jumlah_nominal) }}"
                                    class="form-control @error('jumlah_nominal') is-invalid @enderror"
                                    required
                                />

                                @error('jumlah_nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input uraian --}}
                        <div class="form-group row mb-3">
                            <label
                                for="uraian"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Uraian
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <textarea
                                    name="uraian"
                                    id="uraian"
                                    class="form-control"
                                >{{ old('uraian', $transaksi->uraian) }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- end input kegiatan, jumlah nominal & uraian --}}

        {{-- input dokumen & file dokumen --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Edit Dokumen</h4>
                    </div>

                    <div class="card-body">

                        {{-- input no dokumen --}}
                        <div class="form-group row mb-3">
                            <label
                                for="no_dokumen"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                No Dokumen <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    type="text"
                                    id="no_dokumen"
                                    name="no_dokumen"
                                    placeholder="Masukan no dokumen..."
                                    value="{{ old('no_dokumen', $transaksi->no_dokumen) }}"
                                    class="form-control @error('no_dokumen') is-invalid @enderror"
                                    required
                                />

                                @error('no_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- upload file dokument --}}
                        <div class="form-group row mb-3">
                            <span class="col-md-3 col-sm-12 col-form-label">
                                File Dokumen
                            </span>

                            <div class="col-md-9 col-sm-12">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="file_dokumen">
                                            <span
                                                type="button"
                                                class="btn btn-primary btn-rounded"
                                            >
                                                <i class="mdi mdi-upload-outline"></i>
                                                <span>Unggah File</span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="col-12">
                                        <span
                                            id="file-name"
                                            class="text-nowrap h5"
                                            data-file="{{ str_replace('transaksi/', '', $transaksi->file_dokumen) }}"
                                            data-action="edit"
                                        >
                                            {{ str_replace('transaksi/', '', $transaksi->file_dokumen) }}
                                        </span>
                                    </div>
                                </div>

                                <input
                                    type="file"
                                    id="file_dokumen"
                                    name="file_dokumen"
                                    value="{{ old('file_dokumen') }}"
                                    class="d-none is-invalid @error('file_dokumen') is-invalid @enderror"
                                />

                                @error('file_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- end input dokumen & file dokumen --}}

        {{-- button submit & reset --}}
        <div class="row">
            <div class="col-12">
                <button
                    type="submit"
                    class="btn btn-info btn-rounded mr-2"
                >
                    <i class="mdi mdi-content-save"></i>
                    <span>Simpan</span>
                </button>

                <button
                    type="reset"
                    class="btn btn-secondary btn-rounded"
                >
                    <i class="mdi mdi-close"></i>
                    <span>Reset</span>
                </button>
            </div>
        </div>

    </form>
    {{-- end form input budget --}}

@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/transaksi.js') }}"></script>
@endsection
