<x-layouts.auth title="Edit Realisasi" back-button="{{ route('belanja') }}">
    <x-slot name="style">
        <link href="{{ asset('assets/css/vendor/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>

    {{-- Form edit transaksi (pagu) --}}
    <x-form action="{{ route('belanja.update', ['transaksi' => $transaksi->id]) }}" method="PATCH" enctype="multipart/form-data">
        
        {{-- input budget_id --}}
        <input
            required
            type="hidden"
            name="budget_id"
            id="budget_id"
            value="{{ old('budget_id', $transaksi->budget->id) }}"
        />

        {{-- input akun belanja (jenis_belanja) & bagian (divisi) --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Pagu</h4>
                    </div>

                    <div class="card-body">

                        {{-- Input jenis belanja (akun belanja) --}}
                        <div class="form-group row mb-3">
                            <label for="jenis_belanja" class="col-md-3 col-sm-12 col-form-label">
                                Akun Belanja <small class="text-danger">*</small>
                            </label>

                            <div class="input-group col-md-9 col-sm-12">
                                <div class="input-group-prepend">
                                    <button
                                        class="btn btn-sm btn-info"
                                        data-toggle="tooltip"
                                        data-original-title="Pilih akun belanja"
                                        data-placement="top"
                                        onclick="transaksi.showModalTableBudget(true)"
                                    >
                                        <i class="mdi mdi-table-large"></i>
                                    </button>
                                </div>

                                <input
                                    readonly
                                    required
                                    type="text"
                                    name="nama_akun_belanja"
                                    id="nama_akun_belanja"
                                    placeholder="Akun belanja..."
                                    class="form-control @error('budget_id') is-invalid @else @error('nama_akun_belanja') is-invalid @enderror @enderror"
                                    value="{{ old('nama_akun_belanja', $transaksi->budget->jenisBelanja->akunBelanja->nama_akun_belanja) }}"
                                />

                                <input
                                    readonly
                                    required
                                    type="text"
                                    name="kategori_belanja"
                                    id="kategori_belanja"
                                    placeholder="Jenis belanja..."
                                    class="form-control @error('budget_id') is-invalid @else @error('kategori_belanja') is-invalid @enderror @enderror"
                                    value="{{ old('kategori_belanja', $transaksi->budget->jenisBelanja->kategori_belanja) }}"
                                />

                                @error('budget_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    @error('nama_akun_belanja')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        @error('kategori_belanja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @enderror
                                @enderror
                            </div>
                        </div>

                        {{-- input bagian (divisi) --}}
                        <div class="form-group row mb-3">
                            <label for="nama_divisi" class="col-md-3 col-sm-12 col-form-label">
                                Bagian <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    readonly
                                    required
                                    type="text"
                                    id="nama_divisi"
                                    name="nama_divisi"
                                    placeholder="Bagian..."
                                    class="form-control @error('nama_divisi') is-invalid @enderror"
                                    value="{{ old('nama_divisi', $transaksi->budget->divisi->nama_divisi) }}"
                                />

                                @error('nama_divisi')
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
                                <input
                                    readonly
                                    type="number"
                                    id="tahun_anggaran"
                                    name="tahun_anggaran"
                                    placeholder="Tahun Anggaran..."
                                    class="form-control @error('tahun_anggaran') is-invalid @enderror"
                                    value="{{ old('tahun_anggaran', $transaksi->budget->tahun_anggaran) }}"
                                />

                                @error('tahun_anggaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input sisa budget --}}
                        <div class="form-group row mb-3">
                            <label for="sisa_budget" class="col-md-3 col-sm-12 col-form-label">
                                Sisa Budget <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        Rp.
                                    </span>
                                </div>

                                <input
                                    readonly
                                    type="text"
                                    id="sisa_budget"
                                    name="sisa_budget"
                                    placeholder="Sisa budget..."
                                    class="form-control @error('sisa_budget') is-invalid @enderror"
                                    value="{{ old('sisa_budget', $transaksi->budget->sisa_nominal) }}"
                                />

                                @error('sisa_budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- end input akun belanja (jenis_belanja) & bagian (divisi) --}}

        {{-- input kegiatan --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Kegiatan</h4>
                    </div>

                    <div class="card-body">

                        {{-- input tanggal --}}
                        <div class="form-group row mb-3">
                            <label for="tanggal" class="col-md-3 col-sm-12 col-form-label">
                                Tanggal <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    required
                                    type="date"
                                    id="tanggal"
                                    name="tanggal"
                                    placeholder="Masukan tanggal transaksi belanja..."
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', $transaksi->tanggal) }}"
                                />

                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input kegiatan --}}
                        <div class="form-group row mb-3">
                            <label for="kegiatan" class="col-md-3 col-sm-12 col-form-label">
                                Kegiatan <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    required
                                    type="text"
                                    id="kegiatan"
                                    name="kegiatan"
                                    placeholder="Masukan kegiatan..."
                                    class="form-control @error('kegiatan') is-invalid @enderror"
                                    value="{{ old('kegiatan', $transaksi->kegiatan) }}"
                                />

                                @error('kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input jumlah_nominal --}}
                        <div class="form-group row mb-3">
                            <label for="jumlah_nominal" class="col-md-3 col-sm-12 col-form-label">
                                Jumlah Nominal <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        Rp.
                                    </span>
                                </div>

                                <input
                                    required
                                    type="number"
                                    id="jumlah_nominal"
                                    name="jumlah_nominal"
                                    min="0"
                                    placeholder="Masukan jumlah nominal..."
                                    class="form-control @error('jumlah_nominal') is-invalid @enderror"
                                    value="{{ old('jumlah_nominal', $transaksi->jumlah_nominal) }}"
                                />

                                @error('jumlah_nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input nama approval --}}
                        <div class="form-group row mb-3">
                            <label for="approval" class="col-md-3 col-sm-12 col-form-label">
                                Nama Approval <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    required
                                    type="text"
                                    id="approval"
                                    name="approval"
                                    placeholder="Masukan nama approval..."
                                    class="form-control @error('approval') is-invalid @enderror"
                                    value="{{ old('approval', $transaksi->approval) }}"
                                />

                                @error('approval')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input Outstanding --}}
                        <div class="form-group row justify-content-end">
                            <div class="col-md-9 col-sm-12">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        name="outstanding"
                                        class="custom-control-input form-control-lg"
                                        id="outstanding"
                                        @if (old('outstanding', $transaksi->outstanding)) checked @endif
                                    />

                                    <label class="custom-control-label" for="outstanding">
                                        Outstanding
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- end input kegiatan --}}

        {{-- input dokumen & file dokumen --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Dokumen</h4>
                    </div>

                    <div class="card-body">

                        {{-- input no dokumen --}}
                        <div class="form-group row mb-3">
                            <label for="no_dokumen" class="col-md-3 col-sm-12 col-form-label">
                                No Dokumen <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    required
                                    type="text"
                                    id="no_dokumen"
                                    name="no_dokumen"
                                    placeholder="Masukan no dokumen..."
                                    class="form-control @error('no_dokumen') is-invalid @enderror"
                                    value="{{ old('no_dokumen', $transaksi->no_dokumen) }}"
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
                                            <span type="button" class="btn btn-success btn-sm btn-rounded">
                                                <i class="mdi mdi-upload mr-1"></i>
                                                <span>Unggah File</span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="col-12">
                                        <span
                                            id="file-name"
                                            class="badge badge-light py-1 px-1 mt-1 @if (!$transaksi->file_dokumen) d-none @endif"
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

        {{-- input uraian --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h3 class="header-title">
                            Uraian
                        </h3>
                    </div>

                    <div class="card-body">
                        <textarea name="uraian" id="uraian" class="form-control @error('uraian') is-invalid @enderror">{{ old('uraian', $transaksi->uraian) }}</textarea>

                        @error('uraian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
        {{-- end input uraian --}}

    </x-form>
    {{-- End form edit transaksi (pagu) --}}

    {{-- Modal table budget --}}
    <x-transaksi.modal-table-budget />

    <x-slot name="script">
        <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
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
        <script src="{{ asset('assets/js/pages/transaksi.js') }}"></script>
    </x-slot>
</x-layouts.auth>
