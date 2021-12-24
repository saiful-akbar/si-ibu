@extends('templates.main')

@section('title', 'Transaksi')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Transaksi</h4>
                </div>

                <div class="card-body">

                    {{-- button tambah & form search --}}
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->pivot->create == 1)
                                <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-rounded">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah Transaksi</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('transaksi') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input
                                        type="search"
                                        name="search"
                                        placeholder="Cari transaksi..."
                                        class="form-control"
                                        value="{{ request('search') }}"
                                    />

                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
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
                                            <th>Divisi</th>
                                            <th>Tanggal</th>
                                            <th>Kegiatan</th>
                                            <th>Jumlah Nominal</th>
                                            <th>No. Dokumen</th>
                                            <th>Diperbarui</th>
                                            <th class="text-center">Unduh File</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $data)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $transactions->currentPage() + $loop->iteration - 1 }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ ucwords($data->nama_divisi) }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $data->tanggal }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $data->kegiatan }}
                                                </td>
                                                <td class="align-middle">
                                                    Rp. {{ number_format($data->jumlah_nominal) }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $data->no_dokumen }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $data->updated_at }}
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ($data->file_dokumen)
                                                        <a
                                                            href="{{ route('transaksi.download', ['transaksi' => $data->id]) }}"
                                                            class="btn btn-sm btn-primary btn-icon"
                                                            data-toggle="tooltip"
                                                            data-original-title="Unduh"
                                                            data-placement="top"
                                                        >
                                                            <i class="mdi mdi-download"></i>
                                                        </a>
                                                    @else
                                                        File tidak tersedia
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button
                                                        class="btn btn-sm btn-info btn-icon mr-1"
                                                        data-toggle="tooltip"
                                                        data-original-title="Detail"
                                                        data-placement="top"
                                                        onclick="transaksi.showDetail({{ $data->id }})"
                                                    >
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </button>

                                                    @if ($userAccess->pivot->update == 1)
                                                        <a
                                                            href="{{ route('transaksi.edit', ['transaksi' => $data->id]) }}"
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
                                                            class="btn btn-sm btn-icon btn-danger"
                                                            data-toggle="tooltip"
                                                            data-original-title="Hapus"
                                                            data-placement="top"
                                                            onclick="transaksi.delete({{ $data->id }}, '{{ $data->no_dokumen }}')"
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

                        <div class="col-12 d-flex justify-content-end">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>

    {{-- form delete transaksi --}}
    <form method="post" id="form-delete-transaksi">
        @method('DELETE') @csrf
    </form>

    {{-- modal detail --}}
    @include('pages.transaksi.detail')
@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/transaksi.js') }}"></script>
@endsection
