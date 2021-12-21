@extends('templates.main')

@section('title', 'Budget')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- title & btn tambah --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">Tabel Budget</h4>

                            @if ($userAccess->pivot->create == 1)
                                <a href="{{ route('budget.create') }}" class="btn btn-rounded btn-primary">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Input Budget</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{-- end itle & btn tambah --}}

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('budget') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari budget..." class="form-control"
                                        value="{{ request('search') }}" />

                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
                                            <i class="uil-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- end form search --}}

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun Anggaran</th>
                                            <th>Divisi</th>
                                            <th>Nominal</th>
                                            <th>Diperbarui</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($budgets as $data)
                                            <tr>
                                                <td class="align-middle">{{ $budgets->currentPage() + $loop->iteration - 1 }}
                                                </td>
                                                <td class="align-middle">{{ $data->tahun_anggaran }}</td>
                                                <td class="align-middle">{{ ucwords($data->nama_divisi) }}</td>
                                                <td class="align-middle">Rp. {{ number_format($data->nominal) }}</td>
                                                <td class="align-middle">{{ $data->updated_at }}</td>
                                                <td class="align-middel text-center">
                                                    <button class="btn btn-sm btn-info btn-icon mr-1" data-toggle="tooltip"
                                                        data-original-title="Detail"
                                                        onclick="handleShowModalDetail({{ $data->id }})">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </button>

                                                    @if ($userAccess->pivot->update == 1)
                                                        <a href="{{ route('budget.edit', ['budget' => $data->id]) }}"
                                                            class="btn btn-sm btn-success btn-icon mr-1" data-toggle="tooltip"
                                                            data-original-title="Edit">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                    @endif

                                                    @if ($userAccess->pivot->delete == 1)
                                                        <button
                                                            onclick="handleDelete({{ $data->id }}, '{{ $data->nama_divisi }}')"
                                                            class="btn btn-sm btn-danger btn-icon" data-toggle="tooltip"
                                                            data-original-title="Hapus">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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

    {{-- form delete data budget --}}
    <form method="POST" id="form-delete-budget">
        @method('DELETE')
        @csrf
    </form>

    {{-- modal detail --}}
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detail">DETAIL BUDGET</h5>
                    <button type="button" class="close" aria-label="Close" onclick="handleCloseModalDetail()">
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
                            <div class="col-md-6 col-sm-12 mb-3">
                                <strong>Divisi :</strong>
                                <div id="detail-divisi"></div>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3">
                                <strong>Tahun Anggaran :</strong>
                                <div id="detail-tahun-anggaran"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <strong>Nominal :</strong>
                                <div id="detail-nominal"></div>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3">
                                <strong>Dibuat Pada :</strong>
                                <div id="detail-created"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <strong>Diperbarui Pada :</strong>
                                <div id="detail-updated"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <strong>Keterangan :</strong>
                                <div class="mt-1" id="detail-keterangan"></div>
                            </div>
                        </div>
                    </div>
                    {{-- end modal detail conten --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" onclick="handleCloseModalDetail()">
                        <i class=" mdi mdi-close"></i>
                        <span>Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/budget.js') }}"></script>
@endsection
