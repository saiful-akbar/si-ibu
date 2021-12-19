@extends('templates.main')

@section('title', 'Transaksi')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- title & btn tambah --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">Tabel Transaksi</h4>

                            @if ($userAccess->pivot->create == 1)
                                <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-rounded">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah Transaksi Baru</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{-- end itle & btn tambah --}}

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('transaksi') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari transaksi..." class="form-control"
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
                                            <th>Tanggal</th>
                                            <th>Submitter</th>
                                            <th>Divisi</th>
                                            <th>Kegiatan</th>
                                            <th>No. Dokumen</th>
                                            <th>Approval</th>
                                            <th>Diperbarui</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $data)
                                            <tr>
                                                <td class="align-middle">{{ $transactions->currentPage() + $loop->iteration - 1 }}
                                                </td>
                                                <td class="align-middle">{{ $data->tanggal }}</td>
                                                <td class="align-middle">{{ ucwords($data->nama_lengkap) }}</td>
                                                <td class="align-middle">{{ ucwords($data->nama_divisi) }}</td>
                                                <td class="align-middle">{{ $data->kegiatan }}</td>
                                                <td class="align-middle">{{ $data->no_dokumen }}</td>
                                                <td class="align-middle">{{ ucwords($data->approval) }}</td>
                                                <td class="align-middle">{{ $data->updated_at }}</td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-sm btn-info mr-1 btn-rounded">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                        <span>Detail</span>
                                                    </button>

                                                    @if ($userAccess->pivot->update == 1)
                                                        <a href="{{ route('transaksi.edit', ['transaksi' => $data->id]) }}"
                                                            class="btn btn-sm btn-success btn-rounded mr-1">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                    @endif

                                                    @if ($userAccess->pivot->delete == 1)
                                                        <button class="btn btn-sm btn-danger btn-rounded">
                                                            <i class="mdi mdi-delete"></i>
                                                            <span>Hapus</span>
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
@endsection
