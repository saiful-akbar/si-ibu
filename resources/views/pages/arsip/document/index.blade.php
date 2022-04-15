<x-layouts.auth title="Dokumen Arsip">

    {{-- form filter --}}
    <div class="row">
        <div class="col-12 mb-3">
            <x-form action="{{ route('arsip.document') }}" method="GET">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Filter</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- input periode tanggal --}}
                            <div class="col-lg-8 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label> Periode <small class="text-danger">*</small></label>

                                    <div class="input-group @error('first_period') is-invalid @enderror">
                                        <input required type="date" name="first_period" id="first_period"
                                            placeholder="Masukan periode awal..."
                                            class="form-control @error('first_period') is-invalid @enderror"
                                            value="{{ old('first_period', $firstPeriod) }}" />

                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="mdi mdi-chevron-double-right"></i>
                                            </span>
                                        </div>

                                        <input required type="date" name="last_period" id="last_period"
                                            placeholder="Masukan periode akhir..."
                                            class="form-control @error('last_period') is-invalid @enderror"
                                            value="{{ old('last_period', $lastPeriod) }}" />
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

                                    <select id="ars_category" name="ars_category" data-toggle="select2"
                                        class="form-control select2 @error('ars_category') is-invalid @enderror">
                                        <option value="{{ null }}">-- Semua --</option>

                                        @foreach ($arsCategories as $arsCategory)
                                            <option value="{{ $arsCategory->Name }}"
                                                @if (old('ars_category', request('ars_category')) == $arsCategory->Name) selected @endif>
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
                                    <label for="ars_type">Type Arsip</label>

                                    <select id="ars_type" name="ars_type" data-toggle="select2"
                                        class="form-control select2 @error('ars_type') is-invalid @enderror">
                                        <option value="{{ null }}">-- Semua --</option>

                                        @foreach ($arsCategories as $arsCategory)
                                            <optgroup label="{{ $arsCategory->Name }}">
                                                @foreach ($arsCategory->MSARSType as $arsType)
                                                    <option value="{{ $arsType->Name }}" class="pl-3"
                                                        @if (old('ars_type', request('ars_type')) == $arsType->Name) selected @endif>
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
                                    <label for="number">Nomor Dokumen</label>

                                    <input type="search" name="number" id="number" placeholder="Masukan nomor..."
                                        class="form-control @error('number') is-invalid @enderror"
                                        value="{{ old('number', request('number')) }}" />

                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input number --}}

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="mdi mdi-filter-variant"></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </x-form>
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
                    <div class="row">
                        <div class="col-12 mb-3">
                            <x-table :paginator="$arsDocuments">
                                <x-slot name="thead">
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
                                </x-slot>

                                <x-slot name="tbody">
                                    @foreach ($arsDocuments as $arsDocument)
                                        <tr>
                                            <td>
                                                {{ number_format($arsDocuments->perPage() * ($arsDocuments->currentPage() - 1) + $loop->iteration) }}
                                            </td>
                                            <td class="text-center">
                                                @if (!empty($arsDocument->Dokumen))
                                                    <a href="{{ route('arsip.document.download', ['arsDocument' => $arsDocument->ARSDocument_PK]) }}"
                                                        class="btn btn-sm btn-dark btn-icon mx-1" data-toggle="tooltip"
                                                        data-original-title="Unduh" data-placement="top">
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
                                </x-slot>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end table --}}

</x-layouts.auth>
