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
                            <a
                                href="{{ route('divisi.create') }}"
                                class="btn btn-sm btn-primary"
                            >
                                <i class="mdi mdi-plus"></i>
                                <span>Buat Divisi Baru</span>
                            </a>
                        </div>
                    </div>
                    {{-- end itle & btn tambah --}}

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form
                                action="{{ route('divisi') }}"
                                method="GET"
                                autocomplete="off"
                            >
                                <div class="input-group">
                                    <input
                                        type="search"
                                        name="search"
                                        placeholder="Cari divisi..."
                                        class="form-control"
                                        value="{{ $search }}"
                                    />
                                    <div class="input-group-append">
                                        <button
                                            class="btn btn-secondary"
                                            type="submit"
                                        >
                                            <i class="dripicons-search"></i>
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
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($divisi as $data)
                                            <tr>
                                                <td class="align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle">{{ $data->nama_divisi }}</td>
                                                <td class="align-middle text-center">
                                                    <a
                                                        href="{{ route('divisi.edit', ['divisi' => $data->id]) }}"
                                                        class="btn btn-sm btn-outline-success mr-1"
                                                    >
                                                        Edit
                                                    </a>
                                                    <button
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="handleDelete({{ $data->id }}, '{{ $data->nama_divisi }}')"
                                                    >
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            {{ $divisi->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>

    {{-- form delete divisi --}}
    <form
        id="form-delete"
        method="post"
        style="display: none"
    >
        @method('DELETE') @csrf
    </form>
@endsection

@section('js')
    <script src="{{ asset('assets/js/pages/divisi.js') }}"></script>
@endsection
