@extends('templates.main')

@section('title', 'Dokumen Arsip')

@section('content')

    {{-- form filter --}}
    <div class="row">
        <div class="col-12 mb-3">
            <form
                action="{{ route('arsip.document') }}"
                method="GET"
                autocomplete="off"
            >
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Filter</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- input periode tanggal --}}
                            <div class="col-lg-8 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label> Periode <small class="text-danger">*</small></label>

                                    <div class="input-group @error('first_period') is-invalid @enderror">
                                        <input
                                            type="date"
                                            name="first_period"
                                            class="form-control @error('first_period') is-invalid @enderror"
                                            id="first_period"
                                            placeholder="Masukan periode awal..."
                                            value="{{ old('first_period', $firstPeriod) }}"
                                            required
                                        />

                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text"
                                                id="basic-addon1"
                                            >
                                                <i class="mdi mdi-chevron-double-right"></i>
                                            </span>
                                        </div>

                                        <input
                                            type="date"
                                            name="last_period"
                                            class="form-control @error('last_period') is-invalid @enderror"
                                            id="last_period"
                                            value="{{ old('last_period', $lastPeriod) }}"
                                            placeholder="Masukan periode akhir..."
                                            required
                                        />
                                    </div>

                                    @error('first_period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        @error('last_period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @enderror
                                </div>
                            </div>
                            {{-- end input periode tanggal --}}

                            {{-- input kategori arsip --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="ars_category">Kategori Arsip</label>

                                    <select
                                        id="ars_category"
                                        name="ars_category"
                                        data-toggle="select2"
                                        class="form-control select2 @error('ars_category') is-invalid @enderror"
                                    >
                                        <option value="{{ null }}">Semua Kategori</option>

                                        @foreach ($arsCategories as $arsCategory)
                                            <option
                                                value="{{ $arsCategory->Name }}"
                                                @if (old('ars_category', request('ars_category')) == $arsCategory->Name) selected @endif
                                            >
                                                {{ $arsCategory->Name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('ars_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input kategori arsip --}}

                            {{-- input type arsip --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="ars_type">
                                        Type Arsip
                                    </label>

                                    <select
                                        id="ars_type"
                                        name="ars_type"
                                        data-toggle="select2"
                                        class="form-control select2 @error('ars_type') is-invalid @enderror"
                                    >
                                        <option value="{{ null }}">Semua Type</option>

                                        @foreach ($arsCategories as $arsCategory)
                                            <optgroup label="{{ $arsCategory->Name }}">
                                                @foreach ($arsCategory->MSARSType as $arsType)
                                                    <option
                                                        value="{{ $arsType->Name }}"
                                                        class="pl-3"
                                                        @if (old('ars_type', request('ars_type')) == $arsType->Name) selected @endif
                                                    >
                                                        {{ $arsType->Name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    @error('ars_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input type arsip --}}

                            {{-- input number --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="number">
                                        Nomor
                                    </label>

                                    <input
                                        type="search"
                                        name="number"
                                        value="{{ old('number', request('number')) }}"
                                        class="form-control @error('number') is-invalid @enderror"
                                        id="number"
                                        placeholder="Masukan nomor..."
                                    />

                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input number --}}

                        </div>
                    </div>

                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-info btn-rounded btn-sm mr-2"
                        >
                            <i class="mdi mdi-filter-variant mr-1"></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end form filter --}}

    {{-- table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Table Dokumen Arsip</h4>
                </div>

                <div class="card-body">

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-centered w-100 nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Unduh</th>
                                            <th>Tahun</th>
                                            <th>Tanggal</th>
                                            <th>Kategori</th>
                                            <th>Type</th>
                                            <th>Nomor</th>
                                            <th>Nama File</th>
                                            <th>Dibuat</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($arsDocuments as $arsDocument)
                                            <tr>
                                                <td>
                                                    {{ $arsDocuments->perPage() * ($arsDocuments->currentPage() - 1) + $loop->iteration }}
                                                </td>

                                                <td class="text-center">
                                                    @if (!empty($arsDocument->Dokumen))
                                                        <a
                                                            href="{{ route('arsip.document.download', ['arsDocument' => $arsDocument->ARSDocument_PK]) }}"
                                                            class="btn btn-sm btn-dark btn-icon mx-1"
                                                            data-toggle="tooltip"
                                                            data-original-title="Unduh"
                                                            data-placement="top"
                                                        >
                                                            <i class="mdi mdi-download"></i>
                                                        </a>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h4"></i>
                                                    @endif
                                                </td>

                                                <td>{{ $arsDocument->Years }}</td>
                                                <td>{{ $arsDocument->DateDoc }}</td>
                                                <td>{{ $arsDocument->MSARSType->MSARSCategory->Name }}</td>
                                                <td>{{ $arsDocument->MSARSType->Name }}</td>
                                                <td>{{ $arsDocument->Number }}</td>
                                                <td>{{ $arsDocument->NamaFile }}</td>
                                                <td>{{ date('d M Y H:i', strtotime($arsDocument->DateAdds)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end table --}}

                    {{-- table pagination --}}
                    <div class="row">
                        <div class="col-12">
                            {{ $arsDocuments->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- end table --}}

@endsection
