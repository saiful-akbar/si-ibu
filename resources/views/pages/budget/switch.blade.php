@extends('templates.main')

@section('title', 'Switch Budget')

@section('content')

    {{-- button kembali --}}
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a href="{{ route('budget') }}" class="btn btn-rounded btn-dark">
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('budget.switch.update', ['budget' => $budget->id]) }}" method="POST">
        @method('PATCH') @csrf

        {{-- form dari akun belanja --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Dari Akun Belanja</h4>
                    </div>

                    <div class="card-body">

                        {{-- input dari akun belanja --}}
                        <div class="form-group row mb-3">
                            <label for="dariJenisBelanja" class="col-md-3 col-sm-12 col-form-label">
                                Dari Akun belanja
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input disabled type="text" id="dariJenisBelanja" name="dariJenisBelanja"
                                    class="form-control"
                                    value="{{ $budget->jenisBelanja->divisi->nama_divisi }} - {{ $budget->jenisBelanja->kategori_belanja }}" />
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
                            <label for="dariNominal" class="col-md-3 col-sm-12 col-form-label">
                                Nominal
                            </label>

                            <div class="col-md-9 col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        Rp
                                    </span>
                                </div>

                                <input disabled type="text" id="dariNominal" name="dariNominal"
                                    value="{{ number_format($budget->nominal) }}" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- form untuk akun belanja --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Untuk Akun Belanja</h4>
                    </div>

                    <div class="card-body">
                        <input type="hidden" name="id" id="id" value="{{ old('id') }}" required />

                        <div class="form-group row mb-3">
                            <label for="jenis_belanja" class="col-md-3 col-sm-12 col-form-label">
                                Akun Belanja <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="input-group col-md-9 col-sm-12">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip"
                                        data-original-title="Pilih akun belanja" data-placement="top"
                                        onclick="budget.showModalTable(true, {{ $budget->id }})">
                                        <i class="mdi mdi-table-large"></i>
                                    </button>
                                </div>

                                <input type="text" name="jenis_belanja" id="jenis_belanja" class="form-control"
                                    placeholder="Pilih akun belanja..." value="{{ old('jenis_belanja') }}" readonly
                                    required />
                            </div>
                        </div>

                        {{-- input tahun anggaran --}}
                        <div class="form-group row mb-3">
                            <label for="tahun_anggaran" class="col-md-3 col-sm-12 col-form-label">
                                Tahun Anggaran <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required readonly type="number" id="tahun_anggaran" name="tahun_anggaran"
                                    placeholder="Masukan tahun anggaran..." max="9999" min="0"
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
                                Nominal yang ingin dialihkan <small class="text-danger ml-1">*</small>
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

                        {{-- input Keterangan --}}
                        <div class="form-group row mb-3">
                            <label for="keterangan" class="col-md-3 col-sm-12 col-form-label">
                                Keterangan
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <textarea name="keterangan" id="keterangan" rows="10"
                                    class="form-control">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- button submit & reset --}}
        <div class="row">
            <div class="col-12">
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

    {{-- modal table list budget per akun belanja --}}
    <div id="modal-table-budget" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Pilih Akun Belanja
                    </h4>

                    <button type="button" class="close" onclick="budget.showModalTable(false)"
                        aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <table id="datatable-budget"
                        class="table table-hover table-centered w-100 nowrap @if (auth()->user()->pengaturan->tema == 'dark') table-dark @endif">
                        <thead>
                            <tr>
                                <th class="text-center">Aksi</th>
                                <th>Bagian</th>
                                <th>Akun Belanja</th>
                                <th>Tahun Anggaran</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-rounded btn-sm" onclick="budget.showModalTable(false)">
                        <i class="mdi mdi-close"></i>
                        <span>Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
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

    {{-- budget page js --}}
    <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
@endsection
