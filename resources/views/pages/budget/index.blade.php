@extends('templates.main')

@section('title', 'Budget')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Budget</h4>
                </div>

                <div class="card-body">

                    {{-- button tambah & form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->pivot->create == 1)
                                <a
                                    href="{{ route('budget.create') }}"
                                    class="btn btn-rounded btn-primary"
                                >
                                    <i class="mdi mdi-plus"></i>
                                    <span>Input Budget</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <form
                                action="{{ route('budget') }}"
                                method="GET"
                                autocomplete="off"
                            >
                                <div class="input-group">
                                    <input
                                        type="search"
                                        name="search"
                                        placeholder="Cari budget..."
                                        class="form-control"
                                        value="{{ request('search') }}"
                                    />

                                    <div class="input-group-append">
                                        <button
                                            class="btn btn-secondary"
                                            type="submit"
                                        >
                                            <i class="uil-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- end button tambah & form search --}}

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun Anggaran</th>
                                            <th>Akun Belanja</th>
                                            <th>Nominal</th>
                                            <th>Dibuat / Diperbarui</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($budgets as $data)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $budgets->count() * ($budgets->currentPage() - 1) + $loop->iteration }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $data->tahun_anggaran }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ ucwords($data->nama_divisi) }} - {{ $data->kategori_belanja }}
                                                </td>
                                                <td class="align-middle">
                                                    Rp. {{ number_format($data->nominal) }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $data->updated_at }}
                                                </td>
                                                <td class="align-middel text-center">
                                                    <button
                                                        onclick="budget.handleShowModalDetail({{ $data->id }})"
                                                        data-toggle="tooltip"
                                                        data-original-title="Detail"
                                                        data-placement="top"
                                                        class="btn btn-sm btn-info btn-icon mr-1"
                                                    >
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </button>

                                                    @if ($userAccess->pivot->update == 1)
                                                        <a
                                                            href="{{ route('budget.switch', ['budget' => $data->id]) }}"
                                                            class="btn btn-sm btn-primary btn-icon mr-1"
                                                            data-toggle="tooltip"
                                                            data-original-title="Switch Budget"
                                                            data-placement="top"
                                                        >
                                                            <i class="mdi mdi-code-tags"></i>
                                                        </a>

                                                        <a
                                                            href="{{ route('budget.edit', ['budget' => $data->id]) }}"
                                                            class="btn btn-sm btn-success btn-icon mr-1"
                                                            data-toggle="tooltip"
                                                            data-original-title="Edit"
                                                            data-placement="top"
                                                        >
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                    @endif

                                                    @if ($userAccess->pivot->delete == 1)
                                                        <button
                                                            onclick="budget.handleDelete({{ $data->id }}, '{{ $data->nama_divisi }}')"
                                                            data-toggle="tooltip"
                                                            data-original-title="Hapus"
                                                            data-placement="top"
                                                            class="btn btn-sm btn-danger btn-icon"
                                                        >
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
    <form
        method="POST"
        id="form-delete-budget"
    >
        @method('DELETE')
        @csrf
    </form>

    {{-- modal detail --}}
    <div
        class="modal fade"
        id="modal-detail"
        tabindex="-1"
        role="dialog"
        aria-labelledby="detail"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-dialog-scrollable"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="detail"
                    >
                        DETAIL BUDGET
                    </h5>

                    <button
                        type="button"
                        class="close"
                        aria-label="Close"
                        onclick="budget.handleCloseModalDetail()"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <div
                            id="loading-modal"
                            class="spinner-border text-primary"
                            role="status"
                        ></div>
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
                    <button
                        type="button"
                        class="btn btn-dark btn-sm btn-rounded"
                        onclick="budget.handleCloseModalDetail()"
                    >
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
