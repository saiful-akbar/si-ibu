@extends('templates.main')

@section('title', 'Budget')

@section('content')

    {{-- form filter --}}
    <div class="row">
        <div class="col-12 mb-3">
            <form action="{{ route('budget') }}" method="GET">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Filter</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- input periode tahun --}}
                            <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label>Periode Tahun <small class="text-danger">*</small></label>

                                    <div class="input-group">
                                        <input required name="periode_awal" type="number" id="periode_awal"
                                            placeholder="Awal periode tahun..." min="1900" max="9999"
                                            value="{{ old('periode_awal', request('periode_awal')) }}"
                                            class="form-control" />

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-chevron-double-right"></i>
                                            </span>
                                        </div>

                                        <input required name="periode_akhir" type="number" id="periode_akhir"
                                            placeholder="Akhir periode tahun..." min="1900" max="9999"
                                            value="{{ old('periode_akhir', request('periode_akhir')) }}"
                                            class="form-control @error('periode_akhir') is-invalid @enderror" />
                                    </div>
                                </div>
                            </div>

                            {{-- input bagian (divisi) --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="divisi">Bagian</label>

                                    <select id="divisi" name="divisi" data-toggle="select2" class="form-control select2">
                                        <option value="{{ null }}">Semua Bagian</option>

                                        @foreach ($divisi as $div)
                                            <option value="{{ $div->nama_divisi }}" @if (request('divisi') == $div->nama_divisi) selected @endif>
                                                {{ $div->nama_divisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- input akun belanja (jenis_belanja) --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="jenis_belanja">Akun Belanja</label>

                                    <select id="jenis_belanja" name="jenis_belanja" data-toggle="select2"
                                        class="form-control select2">
                                        <option value="{{ null }}">Semua Akun Belanja</option>

                                        @foreach ($jenisBelanja as $jBelanja)
                                            <option value="{{ $jBelanja->kategori_belanja }}" @if (request('jenis_belanja') == $jBelanja->kategori_belanja) selected @endif>
                                                {{ $jBelanja->kategori_belanja }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-rounded btn-sm">
                            <i class="mdi mdi-filter-variant"></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end form filter --}}

    {{-- table budget --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Budget</h4>
                </div>

                <div class="card-body">

                    {{-- button tambah --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            @if ($userAccess->pivot->create == 1)
                                <a href="{{ route('budget.create') }}" class="btn btn-sm btn-rounded btn-primary">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Input Budget</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table nowrap w-100 table-centered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun Anggaran</th>
                                            <th>Bagian</th>
                                            <th>Akun Belanja</th>
                                            <th>Nominal</th>
                                            <th>Sisa Nominal</th>
                                            <th>Dibuat</th>
                                            <th>Diperbarui</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($budgets) > 0)
                                            @foreach ($budgets as $data)
                                                <tr>
                                                    <td>
                                                        {{ $budgets->count() * ($budgets->currentPage() - 1) + $loop->iteration }}
                                                    </td>
                                                    <td>{{ $data->tahun_anggaran }}</td>
                                                    <td>{{ ucwords($data->nama_divisi) }}</td>
                                                    <td>{{ $data->kategori_belanja }}</td>
                                                    <td>Rp. {{ number_format($data->nominal) }}</td>
                                                    <td>Rp. {{ number_format($data->sisa_nominal) }}</td>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->updated_at }}</td>
                                                    <td class="table-action text-center">
                                                        <button onclick="budget.handleShowModalDetail({{ $data->id }})"
                                                            data-toggle="tooltip" data-original-title="Detail"
                                                            data-placement="top" class="btn btn-sm btn-light btn-icon mr-1">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </button>

                                                        @if ($userAccess->pivot->update == 1)
                                                            <a href="{{ route('budget.switch', ['budget' => $data->id]) }}"
                                                                class="btn btn-sm btn-light btn-icon mr-1"
                                                                data-toggle="tooltip" data-original-title="Switch Budget"
                                                                data-placement="top">
                                                                <i class="mdi mdi-code-tags"></i>
                                                            </a>

                                                            <a href="{{ route('budget.edit', ['budget' => $data->id]) }}"
                                                                class="btn btn-sm btn-light btn-icon mr-1"
                                                                data-toggle="tooltip" data-original-title="Edit"
                                                                data-placement="top">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->pivot->delete == 1)
                                                            <button
                                                                onclick="budget.handleDelete({{ $data->id }})"
                                                                data-toggle="tooltip" data-original-title="Hapus"
                                                                data-placement="top" class="btn btn-sm btn-light btn-icon">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data budget.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- table pagination --}}
                        <div class="col-12 d-flex justify-content-end">
                            {{ $budgets->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>
    {{-- end table budget --}}

    {{-- form delete data budget --}}
    <form method="POST" id="form-delete-budget">
        @method('DELETE') @csrf
    </form>

    {{-- modal detail --}}
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detail">
                        DETAIL BUDGET
                    </h5>

                    <button type="button" class="close" aria-label="Close"
                        onclick="budget.handleCloseModalDetail()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <div id="loading-modal" class="spinner-border text-primary" role="status"></div>
                    </div>

                    {{-- modal detail conten --}}
                    <div id="modal-detail-content">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <strong class="mr-2">Divisi :</strong>
                                <span id="detail-divisi"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <strong class="mr-2">Akun Belanja :</strong>
                                <span id="detail-akun-belanja"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <strong class="mr-2">Tahun Anggaran :</strong>
                                <span id="detail-tahun-anggaran"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <strong class="mr-2">Nominal :</strong>
                                <span id="detail-nominal"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <strong class="mr-2">Dibuat :</strong>
                                <span id="detail-created"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <strong class="mr-2">Diperbarui :</strong>
                                <span id="detail-updated"></span>
                            </div>
                        </div>

                        <hr class="mb-3">

                        <div class="row">
                            <div class="col-sm-12">
                                <p id="detail-keterangan"></p>
                            </div>
                        </div>
                    </div>
                    {{-- end modal detail conten --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm btn-rounded" onclick="budget.handleCloseModalDetail()">
                        <i class=" mdi mdi-close"></i>
                        <span>Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal detail --}}

@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
@endsection
