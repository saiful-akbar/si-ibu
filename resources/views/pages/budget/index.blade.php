<x-layouts.auth title="Pagu">

    {{-- form filter --}}
    <div class="row">
        <div class="col-12 mb-3">
            <x-form action="{{ route('budget') }}" method="GET">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Filter</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- input periode tahun --}}
                            <div class="col-lg-8 col-md-12 col-sm-12 mb-1">
                                <div class="form-group">
                                    <label>Periode Tahun <small class="text-danger">*</small></label>

                                    <div class="input-group">
                                        <input required name="periode_awal" type="number" id="periode_awal"
                                            placeholder="Awal periode tahun..." min="1900" max="9999"
                                            value="{{ request('periode_awal') ?? date('Y') }}" class="form-control" />

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-chevron-double-right"></i>
                                            </span>
                                        </div>

                                        <input required name="periode_akhir" type="number" id="periode_akhir"
                                            placeholder="Akhir periode tahun..." min="1900" max="9999"
                                            value="{{ request('periode_akhir') ?? date('Y') }}"
                                            class="form-control @error('periode_akhir') is-invalid @enderror" />
                                    </div>
                                </div>
                            </div>

                            {{-- input bagian (divisi) jika user sebagai admin --}}
                            @if ($isAdmin)
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                                    <div class="form-group">
                                        <label for="divisi">Bagian</label>

                                        <select id="divisi" name="divisi" data-toggle="select2" class="form-control select2">
                                            <option value="{{ null }}">-- Semua --</option>

                                            @foreach ($divisi as $div)
                                                <option value="{{ $div->nama_divisi }}"
                                                    @if (request('divisi') == $div->nama_divisi) selected @endif>
                                                    {{ $div->nama_divisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            {{-- input akun belanja (jenis_belanja) --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                                <div class="form-group">
                                    <label for="jenis_belanja">Akun Belanja</label>

                                    <select id="jenis_belanja" name="jenis_belanja" data-toggle="select2"
                                        class="form-control select2">
                                        <option value="{{ null }}">-- Semua --</option>

                                        @foreach ($akunBelanja as $aBelanja)
                                            <optgroup label="{{ $aBelanja->nama_akun_belanja }}">
                                                @foreach ($aBelanja->jenisBelanja as $jenisBelanja)
                                                    @if ($jenisBelanja->active == 1)
                                                        <option value="{{ $jenisBelanja->kategori_belanja }}"
                                                            @if (request('jenis_belanja') == $jenisBelanja->kategori_belanja) selected @endif>
                                                            {{ $jenisBelanja->kategori_belanja }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

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

    {{-- table budget --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Pagu</h4>
                </div>

                <div class="card-body">

                    {{-- button tambah --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            @if ($userAccess->create == 1)
                                <a href="{{ route('budget.create') }}" class="btn btn-sm btn-primary">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Input Pagu</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <x-table :paginator="$budgets">
                                <x-slot name="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Anggaran</th>
                                        <th>Bagian</th>
                                        <th>Akun Belanja</th>
                                        <th>Jenis Belanja</th>
                                        <th>Nominal</th>
                                        <th>Nominal Realisasi</th>
                                        <th>Sisa Nominal</th>
                                        <th>Dibuat</th>
                                        <th>Diperbarui</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </x-slot>

                                <x-slot name="tbody">
                                    @foreach ($budgets as $budget)
                                        <tr>
                                            <td>
                                                {{ number_format($budgets->perPage() * ($budgets->currentPage() - 1) + $loop->iteration) }}
                                            </td>
                                            <td>{{ $budget->tahun_anggaran }}</td>
                                            <td>{{ $budget->divisi->nama_divisi }}</td>
                                            <td>{{ $budget->jenisBelanja->akunBelanja->nama_akun_belanja }}</td>
                                            <td>{{ $budget->jenisBelanja->kategori_belanja }}</td>
                                            <td>Rp. {{ number_format($budget->nominal) }}</td>
                                            <td>Rp. {{ number_format($budget->nominal - $budget->sisa_nominal) }}</td>
                                            <td>Rp. {{ number_format($budget->sisa_nominal) }}</td>
                                            <td>{{ $budget->created_at }}</td>
                                            <td>{{ $budget->updated_at }}</td>
                                            <td class="table-action text-center">
                                                <button onclick="budget.detail(true, {{ $budget->id }})" data-toggle="tooltip"
                                                    data-original-title="Detail" data-placement="top"
                                                    class="btn btn-sm btn-secondary btn-icon mx-1">
                                                    <i class="mdi mdi-eye-outline"></i>
                                                </button>

                                                @if ($userAccess->update == 1)
                                                    <a href="{{ route('budget.switch', ['budget' => $budget->id]) }}"
                                                        class="btn btn-sm btn-secondary btn-icon mx-1" data-toggle="tooltip"
                                                        data-original-title="Switch Pagu" data-placement="top">
                                                        <i class="mdi mdi-code-tags"></i>
                                                    </a>

                                                    <a href="{{ route('budget.edit', ['budget' => $budget->id]) }}"
                                                        class="btn btn-sm btn-secondary btn-icon mx-1" data-toggle="tooltip"
                                                        data-original-title="Edit" data-placement="top">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                @endif

                                                @if ($userAccess->delete == 1)
                                                    <button onclick="budget.handleDelete({{ $budget->id }})"
                                                        data-toggle="tooltip" data-original-title="Hapus" data-placement="top"
                                                        class="btn btn-sm btn-secondary btn-icon mx-1">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-table>
                        </div>
                    </div>
                    {{-- end table --}}

                    {{-- total --}}
                    <div class="row justify-content-end">
                        <div class="col-lg-6 col-md-8 col-sm-12">
                            <div class="table-responsive">
                                <table class="table-sm table-hover table-nowrap w-100 table">
                                    <tbody>
                                        <tr>
                                            <th>Total Nominal :</th>
                                            <td class="text-right">
                                                Rp. {{ number_format($totalNominal) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Nominal Realisasi :</th>
                                            <td class="text-right">
                                                Rp. {{ number_format($totalNominal - $totalSisaNominal) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Sisa Nominal :</th>
                                            <td class="text-right">
                                                Rp. {{ number_format($totalSisaNominal) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end total --}}

                </div>
            </div>
        </div>
    </div>
    {{-- end table budget --}}

    {{-- modal detail budget --}}
    <x-budget.modal-detail />

    {{-- Form delete --}}
    <x-form method="DELETE" id="form-delete"></x-form>

    <x-slot name="script">
        <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
    </x-slot>
</x-layouts.auth>
