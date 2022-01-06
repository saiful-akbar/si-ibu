@extends('templates.main')

@section('title', 'Switch Budget')

@section('btn-kembali')
    <a href="{{ route('budget') }}" class="btn btn-rounded btn-light btn-sm">
        <i class="mdi mdi-chevron-double-left"></i>
        <span>Kembali</span>
    </a>
@endsection

@section('content')
    <form action="{{ route('budget.switch.update', ['budget' => $budget->id]) }}" method="POST">
        @method('PATCH') @csrf

        {{-- input dari akun belanja --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Dari Akun Belanja</h4>
                    </div>

                    <div class="card-body">

                        {{-- input dari divisi --}}
                        <div class="form-group row mb-3">
                            <label for="dari_divisi" class="col-md-3 col-sm-12 col-form-label">
                                Dari Bagian
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input disabled type="text" id="dari_divisi" name="dari_divisi" class="form-control"
                                    value="{{ $budget->divisi->nama_divisi }}" />
                            </div>
                        </div>

                        {{-- input dari akun belanja (jenis_belanja) --}}
                        <div class="form-group row mb-3">
                            <label for="dari_jenis_belanja" class="col-md-3 col-sm-12 col-form-label">
                                Dari Akun Belanja
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input disabled type="text" id="dari_jenis_belanja" name="dari_jenis_belanja"
                                    class="form-control" value="{{ $budget->jenisBelanja->kategori_belanja }}" />
                            </div>
                        </div>

                        {{-- input dari tahun anggaran --}}
                        <div class="form-group row mb-3">
                            <label for="dariTahunAnggaran" class="col-md-3 col-sm-12 col-form-label">
                                Tahun Anggaran
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input disabled type="number" id="dariTahunAnggaran" name="dariTahunAnggaran"
                                    value="{{ $budget->tahun_anggaran }}" class="form-control" />
                            </div>
                        </div>

                        {{-- input dari jumlah nominal --}}
                        <div class="form-group row mb-3">
                            <label for="dari_sisa_nominal" class="col-md-3 col-sm-12 col-form-label">
                                Sisa Nominal Budget
                            </label>

                            <div class="col-md-9 col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        Rp
                                    </span>
                                </div>

                                <input disabled type="text" id="dariNominal" name="dariNominal"
                                    value="{{ number_format($budget->sisa_nominal) }}" class="form-control" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- end input dari akun belanja --}}

        {{-- form untuk akun belanja --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Untuk Akun Belanja</h4>
                    </div>

                    <div class="card-body">

                        {{-- input bagian (divisi_id) --}}
                        <div class="form-group row mb-3">
                            <label for="divisi_id" class="col-md-3 col-sm-12 col-form-label">
                                Bagian <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select name="divisi_id" id="divisi_id" data-toggle="select2"
                                    class="form-control select2 @error('divisi_id') is-invalid @enderror" required>
                                    <option value="{{ null }}" disabled @if (!old('divisi_id')) selected @endif>
                                        Pilih Bagian
                                    </option>

                                    @foreach ($divisions as $divisi)
                                        <option value="{{ $divisi->id }}" @if (old('divisi_id') == $divisi->id) selected @endif>
                                            {{ $divisi->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('divisi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input untuk akun belanja (jenis_belanja) --}}
                        <div class="form-group row mb-3">
                            <label for="jenis_belanja_id" class="col-md-3 col-sm-12 col-form-label">
                                Akun Belanja <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select name="jenis_belanja_id" id="jenis_belanja_id" data-toggle="select2"
                                    class="form-control select2 @error('jenis_belanja_id') is-invalid @enderror" required>
                                    <option value="{{ null }}" disabled @if (!old('jenis_belanja_id')) selected @endif>
                                        Pilih Akun Belanja
                                    </option>

                                    @foreach ($jenisBelanja as $jBelanja)
                                        <option value="{{ $jBelanja->id }}" @if (old('jenis_belanja_id') == $jBelanja->id) selected @endif>
                                            {{ $jBelanja->kategori_belanja }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('jenis_belanja_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input tahun anggaran --}}
                        <div class="form-group row mb-3">
                            <label for="tahun_anggaran" class="col-md-3 col-sm-12 col-form-label">
                                Tahun Anggaran <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required type="number" id="tahun_anggaran" name="tahun_anggaran"
                                    placeholder="Tahun anggaran..." max="9999" min="0"
                                    value="{{ old('tahun_anggaran') }}"
                                    class="form-control @error('tahun_anggaran') is-invalid @enderror" />

                                @error('tahun_anggaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input nominal --}}
                        <div class="form-group row mb-3">
                            <label for="nominal" class="col-md-3 col-sm-12 col-form-label">
                                Nominal <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        Rp
                                    </span>
                                </div>

                                <input required type="number" id="nominal" name="nominal"
                                    placeholder="Masukan nominal yang akan dialihkan..." value="{{ old('nominal') }}"
                                    min="0" class="form-control @error('nominal') is-invalid @enderror" />

                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- end form untuk akun belanja --}}

        {{-- input keterangan --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">
                            Keterangan <small class="text-danger">*</small>
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="keterangan" id="keterangan" rows="10" placeholder="Masukan keterangan..."
                                class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>

                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-rounded btn-sm mr-2">
                            <i class="mdi mdi-content-save"></i>
                            <span>Simpan</span>
                        </button>

                        <button type="reset" class="btn btn-rounded btn-outline-dark btn-sm">
                            <i class="mdi mdi-close"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end input keterangan --}}

    </form>
@endsection

@push('css')
    <link href="{{ asset('assets/css/vendor/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
@endsection
