@extends('templates.main')

@section('title', 'Tambah Transaksi Baru')

@section('content')

    {{-- button kembali --}}
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a href="{{ route('transaksi') }}" class="btn btn-dark btn-rounded">
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- Form input budget --}}
    <form action="{{ route('transaksi.store') }}" method="POST">
        @method('POST')
        @csrf

        {{-- form divisi, tanggal & approval --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">

                        {{-- title --}}
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title">Form Tambah Transaksi</h4>
                            </div>
                        </div>
                        {{-- end title --}}

                        {{-- Input divisi --}}
                        <div class="form-group row mb-3">
                            <label for="divisi_id" class="col-md-3 col-sm-12 col-form-label">
                                Divisi <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select required name="divisi_id" id="divisi_id"
                                    class="custom-select @error('divisi_id') is-invalid @enderror">
                                    <option disabled @if (!old('divisi_id')) selected @endif>
                                        -- Pilih Divisi --
                                    </option>

                                    @foreach ($divisions as $divisi)
                                        <option value="{{ $divisi->id }}" @if (old('divisi_id') == $divisi->id) selected @endif>
                                            {{ ucwords($divisi->nama_divisi) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('divisi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input tanggal --}}
                        <div class="form-group row mb-3">
                            <label for="tanggal" class="col-md-3 col-sm-12 col-form-label">
                                Tanggal <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required type="date" id="tanggal" name="tanggal" placeholder="Masukan tanggal..."
                                    value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" />

                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input nama approval --}}
                        <div class="form-group row mb-3">
                            <label for="approval" class="col-md-3 col-sm-12 col-form-label">
                                Nama Approval <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input type="text" id="approval" name="approval" placeholder="Masukan nama approval..."
                                    value="{{ old('approval') }}" class="form-control @error('approval') is-invalid @enderror"
                                    required />

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
                    <div class="card-body">

                        {{-- title --}}
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title">Kegiatan</h4>
                            </div>
                        </div>
                        {{-- end title --}}

                        {{-- input kegiatan --}}
                        <div class="form-group row mb-3">
                            <label for="kegiatan" class="col-md-3 col-sm-12 col-form-label">
                                Kegiatan <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required type="text" id="kegiatan" name="kegiatan" placeholder="Masukan kegiatan..."
                                    value="{{ old('kegiatan') }}" class="form-control @error('kegiatan') is-invalid @enderror" />

                                @error('kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input jumlah --}}
                        <div class="form-group row mb-3">
                            <label for="jumlah" class="col-md-3 col-sm-12 col-form-label">
                                Jumlah Nominal <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required type="number" id="jumlah" name="jumlah" min="0"
                                    placeholder="Masukan jumlah nominal..." value="{{ old('jumlah') }}"
                                    class="form-control @error('jumlah') is-invalid @enderror" />

                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input uraian --}}
                        <div class="form-group row mb-3">
                            <label for="uraian" class="col-md-3 col-sm-12 col-form-label">
                                Uraian
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <textarea name="uraian" id="uraian" rows="5" placeholder="Masukan uraian..."
                                    class="form-control @error('uraian') is-invalid @enderror">{{ old('uraian') }}</textarea>

                                @error('uraian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                    <div class="card-body">

                        {{-- title --}}
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title">Dokumen</h4>
                            </div>
                        </div>
                        {{-- end title --}}

                        {{-- input no dokumen --}}
                        <div class="form-group row mb-3">
                            <label for="no_dokumen" class="col-md-3 col-sm-12 col-form-label">
                                No Dokumen <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input type="text" id="no_dokumen" name="no_dokumen" placeholder="Masukan no dokumen..."
                                    value="{{ old('no_dokumen', $noDocument) }}"
                                    class="form-control @error('no_dokumen') is-invalid @enderror" required />

                                @error('no_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input file dokument --}}
                        <div class="form-group row mb-3">
                            <span class="col-md-3 col-sm-12 col-form-label">
                                File Dokumen
                            </span>

                            <div class="col-md-9 col-sm-12">
                                <div class="row mb-0">
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <label for="file_dokumen">
                                            <span type="button" class="btn btn-primary btn-rounded">
                                                <i class="mdi mdi-upload-outline"></i>
                                                <span>Upload file</span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="col">
                                        <span id="file-name" class="text-nowrap d-none h5">nama file</span>
                                    </div>
                                </div>

                                <input type="file" id="file_dokumen" name="file_dokumen" value="{{ old('file_dokumen') }}"
                                    class="hidden @error('file_dokumen') is-invalid @enderror" />

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
                <button type="submit" class="btn btn-info btn-rounded mr-2">
                    <i class="mdi mdi-content-save"></i>
                    <span>Simpan</span>
                </button>

                <button type="reset" class="btn btn-secondary btn-rounded">
                    <i class="mdi mdi-close"></i>
                    <span>Reset</span>
                </button>
            </div>
        </div>

    </form>
    {{-- end form input budget --}}

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#file_dokumen').change(function(e) {
                const elFileName = $('#file-name');
                const {
                    files
                } = $(this)[0];

                if (files) {
                    const {
                        name
                    } = files[0];

                    elFileName.removeClass('d-none');
                    elFileName.text(name);
                }
            });

            $('button[type=reset]').click(function(e) {
                $('#file-name').addClass('d-none');;
            });
        });
    </script>
@endsection
