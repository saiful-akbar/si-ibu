@extends('templates.main')

@section('title', 'Divisi')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- title & btn tambah --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">Tabel Divisi</h4>

                            @if ($user_akses->pivot->create == 1)
                                <a href="{{ route('divisi.create') }}" class="btn btn-rounded btn-primary">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah Divisi Baru</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{-- end itle & btn tambah --}}

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('divisi') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari divisi..." class="form-control"
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
                                            <th>Nama Divisi</th>
                                            <th>Diperbarui</th>
                                            @if ($user_akses->pivot->update == 1 || $user_akses->pivot->delete == 1)
                                                <th class="text-center">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($divisi as $data)
                                            <tr>
                                                <td class="align-middle">{{ $divisi->currentPage() + $loop->iteration - 1 }}</td>
                                                <td class="align-middle">{{ ucwords($data->nama_divisi) }}</td>
                                                <td class="align-middle">{{ $data->updated_at }}</td>
                                                @if ($user_akses->pivot->update == 1 || $user_akses->pivot->delete == 1)
                                                    <td class="align-middle text-center">
                                                        @if ($user_akses->pivot->update == 1)
                                                            <a href="{{ route('divisi.edit', ['divisi' => $data->id]) }}"
                                                                class="btn btn-sm btn-success btn-icon mr-1" data-toggle="tooltip"
                                                                data-original-title="Edit">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($user_akses->pivot->delete == 1)
                                                            <button
                                                                onclick="handleDelete({{ $data->id }}, '{{ $data->nama_divisi }}')"
                                                                class="btn btn-sm btn-danger btn-icon" data-toggle="tooltip"
                                                                data-original-title="Hapus">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            {{ $divisi->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>

    {{-- form delete divisi --}}
    <form id="form-delete" method="post" style="display: none">
        @method('DELETE') @csrf
    </form>
@endsection

@section('js')
    <script src="{{ asset('assets/js/pages/divisi.js') }}"></script>
@endsection
