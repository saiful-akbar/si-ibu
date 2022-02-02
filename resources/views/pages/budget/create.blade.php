@extends('templates.main')

@section('title', 'Input Budget')

@section('btn-kembali')
    <a href="{{ route('budget') }}" class="btn btn-rounded btn-dark btn-sm">
        <i class="mdi mdi-chevron-double-left mr-1"></i>
        <span>Kembali</span>
    </a>
@endsection

@section('content')
    <form action="{{ route('budget.store') }}" method="POST" id="form-budget">
        @method('POST')
        @csrf

        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Form Input Budget</h4>
                    </div>

                    <div class="card-body">

                        {{-- Input akun bagian (divisi_id) --}}
                        <div class="form-group row mb-3">
                            <label for="divisi_id" class="col-md-3 col-sm-12 col-form-label">
                                Bagian <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select name="divisi_id" id="divisi_id" data-toggle="select2"
                                    class="form-control select2 @error('divisi_id') is-invalid @enderror" required>
                                    <option disabled value="{{ null }}" @if (!old('divisi_id')) selected @endif>
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

                        {{-- Input akun belanja (jenis_belanja_id) --}}
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-sm-12 col-form-label">
                                Akun Belanja <small class="text-danger">*</small>
                            </label>

                            <div class="input-group col-md-9 col-sm-12">
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" data-toggle="tooltip"
                                        data-original-title="Pilih akun belanja" data-placement="top"
                                        onclick="budget.modalTableAkunBelanja(true)">
                                        <i class="mdi mdi-table-large"></i>
                                    </button>
                                </div>

                                <input type="hidden" id="jenis_belanja_id" name="jenis_belanja_id" class="d-none"
                                    value="{{ old('jenis_belanja_id') }}" required>

                                <input type="text" id="nama_akun_belanja" name="nama_akun_belanja"
                                    class="form-control @error('jenis_belanja_id') is-invalid @enderror"
                                    value="{{ old('nama_akun_belanja') }}" placeholder="Akun belanja..." readonly />

                                <input type="text" id="kategori_belanja" name="kategori_belanja"
                                    class="form-control @error('jenis_belanja_id') is-invalid @enderror"
                                    value="{{ old('kategori_belanja') }}" placeholder="Kategori belanja..." readonly />

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
                                    placeholder="Masukan tahun anggaran..." max="9999" min="0" value="{{ old('tahun_anggaran') }}"
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

                                <input required type="number" id="nominal" name="nominal" placeholder="Masukan nominal..."
                                    value="{{ old('nominal') }}" min="0"
                                    class="form-control @error('nominal') is-invalid @enderror" />

                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- input keterangan --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">
                            Keterangan
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

                    {{-- button submit & reset --}}
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
            </div>
        </div>

    </form>

    {{-- modal table akun belanja --}}
    @include('components.molecules.modal-table-akun-belanja')

@endsection

@push('css')
    {{-- custom editor --}}
    <link href="{{ asset('assets/css/vendor/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />

    {{-- datatables --}}
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('js')
    {{-- custom edito --}}
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>

    {{-- datatables --}}
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>

    {{-- page budget js --}}
    <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
@endsection
