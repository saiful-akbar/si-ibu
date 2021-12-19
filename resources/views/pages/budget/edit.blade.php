@extends('templates.main')

@section('title', 'Edit Budget')

@section('content')

    {{-- button kembali --}}
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a href="{{ route('budget') }}" class="btn btn-sm btn-dark">
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- card form edit budget --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- title --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">Form Edit Budget</h4>
                        </div>
                    </div>
                    {{-- end title --}}

                    {{-- Form input budget --}}
                    <form action="{{ route('budget.update', ['budget' => $budget->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf

                        {{-- Input divisi --}}
                        <div class="form-group row mb-3">
                            <label for="divisi_id" class="col-md-3 col-sm-12 col-form-label">
                                Divisi <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select required name="divisi_id" id="divisi_id"
                                    class="custom-select @error('divisi_id') is-invalid @enderror">
                                    <option disabled>-- Pilih Divisi --</option>

                                    @foreach ($divisions as $divisi)
                                        <option value="{{ $divisi->id }}" @if (old('divisi_id', $budget->divisi->id) == $divisi->id) selected @endif>
                                            {{ ucwords($divisi->nama_divisi) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('divisi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input tahun anggaran --}}
                        <div class="form-group row mb-3">
                            <label for="tahun_anggaran" class="col-md-3 col-sm-12 col-form-label">
                                Tahun Anggaran <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required type="number" id="tahun_anggaran" name="tahun_anggaran"
                                    placeholder="Masukan tahun anggaran..." max="9999"
                                    value="{{ old('tahun_anggaran', $budget->tahun_anggaran) }}"
                                    class="form-control @error('tahun_anggaran') is-invalid @enderror" />

                                @error('tahun_anggaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input nominal --}}
                        <div class="form-group row mb-3">
                            <label for="nominal" class="col-md-3 col-sm-12 col-form-label">
                                Nominal <small class="text-danger ml-1">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>

                                <input required type="number" id="nominal" name="nominal" placeholder="Masukan nominal..."
                                    value="{{ old('nominal', $budget->nominal) }}"
                                    class="form-control @error('nominal') is-invalid @enderror" />

                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- button submit & reset --}}
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-md-9 col-sm-12">
                                <button type="submit" class="btn btn-info btn-sm mr-2">
                                    <i class="mdi mdi-content-save"></i>
                                    <span>Simpan</span>
                                </button>

                                <button type="reset" class="btn btn-sm btn-secondary">
                                    <i class="mdi mdi-close"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>

                    </form>
                    {{-- end form input budget --}}

                </div>
            </div>
        </div>
    </div>
    {{-- end card form edit budget --}}

@endsection
