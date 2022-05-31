<x-layouts.auth title="Switch Pagu" back-button="{{ route('budget') }}">
    <x-slot name="style">
        <link href="{{ asset('assets/css/vendor/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>

    {{-- Form switch budget --}}
    <x-form action="{{ route('budget.switch.update', ['budget' => $budget->id]) }}" method="PATCH">

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
                            <label class="col-md-3 col-sm-12 col-form-label">
                                Dari Akun Belanja
                            </label>

                            <div class="input-group col-md-9 col-sm-12">
                                <input type="text" id="dari_nama_akun_belanja" name="dari_nama_akun_belanja"
                                    class="form-control" value="{{ $budget->jenisBelanja->akunBelanja->nama_akun_belanja }}"
                                    placeholder="Akun belanja..." readonly />


                                <input type="text" id="dari_kategori_belanja" name="dari_kategori_belanja" class="form-control"
                                    value="{{ $budget->jenisBelanja->kategori_belanja }}" placeholder="Kategori belanja..."
                                    readonly />
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
                                Sisa Nominal Pagu
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
                                    <option value="{{ null }}" disabled
                                        @if (!old('divisi_id')) selected @endif>
                                        -- Pilih Bagian --
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
                                    placeholder="Tahun anggaran..." max="9999" min="0" value="{{ old('tahun_anggaran') }}"
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
                                    placeholder="Masukan nominal yang akan dialihkan..." value="{{ old('nominal') }}" min="0"
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
        {{-- end form untuk akun belanja --}}

        {{-- input keterangan --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">
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
        {{-- end input keterangan --}}

    </x-form>
    {{-- End form switch budget --}}

    {{-- Modal datatable akun belanja --}}
    <x-budget.modal-table-akun-belanja />

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
        <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
    </x-slot>
</x-layouts.auth>
