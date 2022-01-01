@extends('templates.main')

@section('title', 'Edit Budget')

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
                href="{{ route('budget') }}"
                class="btn btn-rounded btn-dark"
            >
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- card form edit budget --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Form Edit Budget</h4>
                </div>

                <div class="card-body">
                    <form
                        action="{{ route('budget.update', ['budget' => $budget->id]) }}"
                        method="POST"
                    >
                        @method('PATCH') @csrf

                        {{-- Input akun belanja (jenis_belanja_id) --}}
                        <div class="form-group row mb-3">
                            <label
                                for="jenis_belanja_id"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Akun Belanja <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select
                                    required
                                    name="jenis_belanja_id"
                                    id="jenis_belanja_id"
                                    data-toggle="select2"
                                    class="form-control select2 @error('jenis_belanja_id') is-invalid @enderror"
                                >
                                    <option
                                        disabled
                                        @if (!old('jenis_belanja_id')) selected @endif
                                    >
                                        -- Pilih Akun Belanja --
                                    </option>

                                    @foreach ($divisions as $divisi)
                                        <optgroup label="{{ $divisi->nama_divisi }}">
                                            @foreach ($divisi->jenisBelanja as $jenisBelanja)
                                                @if ($jenisBelanja->active == 1)
                                                    <option
                                                        value="{{ $jenisBelanja->id }}"
                                                        @if (old('jenis_belanja_id', $budget->jenis_belanja_id) == $jenisBelanja->id) selected @endif
                                                    >
                                                        {{ ucwords($divisi->nama_divisi) }} -
                                                        {{ $jenisBelanja->kategori_belanja }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>

                                @error('jenis_belanja_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input tahun anggaran --}}
                        <div class="form-group row mb-3">
                            <label
                                for="tahun_anggaran"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Tahun Anggaran <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    required
                                    type="number"
                                    id="tahun_anggaran"
                                    name="tahun_anggaran"
                                    placeholder="Masukan tahun anggaran..."
                                    max="9999"
                                    min="0"
                                    value="{{ old('tahun_anggaran', $budget->tahun_anggaran) }}"
                                    class="form-control @error('tahun_anggaran') is-invalid @enderror"
                                />

                                @error('tahun_anggaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input nominal --}}
                        <div class="form-group row mb-3">
                            <label
                                for="nominal"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Nominal <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text"
                                        id="basic-addon1"
                                    >
                                        Rp
                                    </span>
                                </div>

                                <input
                                    required
                                    type="number"
                                    id="nominal"
                                    name="nominal"
                                    placeholder="Masukan nominal..."
                                    min="0"
                                    value="{{ old('nominal', $budget->nominal) }}"
                                    class="form-control @error('nominal') is-invalid @enderror"
                                />

                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input Keterangan --}}
                        <div class="form-group row mb-3">
                            <label
                                for="keterangan"
                                class="col-md-3 col-sm-12 col-form-label"
                            >
                                Keterangan
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <textarea
                                    name="keterangan"
                                    id="keterangan"
                                    rows="10"
                                    placeholder="Masukan keterangan..."
                                    class="form-control"
                                >{{ old('keterangan', $budget->keterangan) }}</textarea>
                            </div>
                        </div>

                        {{-- button submit & reset --}}
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-md-9 col-sm-12">
                                <button
                                    type="submit"
                                    class="btn btn-info btn-rounded mr-2"
                                >
                                    <i class="mdi mdi-content-save"></i>
                                    <span>Simpan</span>
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-rounded btn-secondary"
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
    {{-- end card form edit budget --}}

@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
@endsection
