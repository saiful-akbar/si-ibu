@extends('templates.main')

@section('title', 'Jenis Belanja')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- title & btn tambah --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">Tabel Jenis Belanja</h4>

                            @if ($userAccess->pivot->create == 1)
                                <a href="{{ route('jenis-belanja.create') }}" class="btn btn-rounded btn-primary">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah Jenis Belanja</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{-- end itle & btn tambah --}}

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('jenis-belanja') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari jenis belanja..." class="form-control"
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

                    <div class="row">
                        <div class="col-12 mb-3">

                            {{-- tabel view jenis belanja --}}
                            <div class="table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ketergori Belanja</th>
                                            <th>Diperbarui</th>

                                            @if ($userAccess->pivot->update == 1 || $userAccess->pivot->delete == 1)
                                                <th class="text-center">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($jenisBelanja as $data)
                                            <tr>
                                                <td class="align-middel">
                                                    {{ $jenisBelanja->currentPage() + $loop->iteration - 1 }}
                                                </td>
                                                <td class="align-middle">{{ $data->kategori_belanja }}</td>
                                                <td class="align-middle">{{ $data->updated_at->format('d M Y H:i') }}</td>

                                                @if ($userAccess->pivot->update == 1 || $userAccess->pivot->delete == 1)
                                                    <td class="align-middle text-center">
                                                        @if ($userAccess->pivot->update == 1)
                                                            <a href="{{ route('jenis-belanja.edit', ['jenisBelanja' => $data->id]) }}"
                                                                class="btn btn-sm btn-success btn-icon mr-1" data-toggle="tooltip"
                                                                data-original-title="Edit" data-placement="top">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->pivot->delete == 1)
                                                            <button class="btn btn-sm btn-danger btn-icon" data-toggle="tooltip"
                                                                data-original-title="Hapus" data-placement="top"
                                                                onclick="handleDelete({{ $data->id }}, '{{ $data->kategori_belanja }}')">
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
                            {{-- end tabel view jenis belanja --}}

                        </div>

                        {{-- paginasi --}}
                        <div class="col-12 d-flex justify-content-end">
                            {{ $jenisBelanja->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- form delete --}}
    <form method="POST" id="form-delete-jenis-belanja">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('js')
    <script>
        /**
         * Fungsi handle hapus data user
         *
         * @param {int} id
         * @param {string} username
         */
        function handleDelete(id, jenisBelanja) {
            bootbox.confirm({
                title: "Peringatan!",
                message: `
                    <ul>
                        <li>Yakin ingin menghapus jenis belanja "<strong>${jenisBelanja}</strong>" ?</li>
                        <li>Semua data terkait atau data yang berelasi dengan data ini juga akan terhapus.</li>
                    </ul>
                `,
                buttons: {
                    confirm: {
                        label: "Hapus",
                        className: "btn-danger btn-rounded btn-sm",
                    },
                    cancel: {
                        label: "Batal",
                        className: "btn-secondary btn-rounded btn-sm",
                    },
                },
                callback: (result) => {
                    if (result) {
                        const form = $("#form-delete-jenis-belanja");

                        form.attr("action", `${main.baseUrl}/jenis-belanja/${id}`);
                        form.submit();
                    }
                },
            });
        }
    </script>
@endsection
