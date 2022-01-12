@extends('templates.akun-belanja')

@section('title', 'Akun Belanja')

@section('content-akun-belanja')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Tabel Akun Belanja</h4>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">

                        {{-- button tambah --}}
                        <div class="col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->create == 1)
                                <a href="{{ route('akun-belanja.create') }}" class="btn btn-rounded btn-primary btn-sm">
                                    <i class="mdi mdi-plus-circle mr-1"></i>
                                    <span>Tambah Akun Belanja</span>
                                </a>
                            @endif
                        </div>
                        {{-- end button tambah --}}

                        {{-- form pencarian --}}
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('akun-belanja') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari akun belanja..."
                                        class="form-control" value="{{ request('search') }}" />

                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
                                            <i class="uil-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- end form pencarian --}}

                    </div>

                    {{-- table akun_belanja --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-centered w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Akun Belanja</th>
                                            <th class="text-center">Aktif</th>

                                            @if ($isAdmin)
                                                <th>Dibuat</th>
                                                <th>Diperbarui</th>
                                            @endif

                                            @if ($userAccess->update == 1 || $userAccess->delete == 1)
                                                <th class="text-center">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($akunBelanja as $data)
                                            <tr>
                                                <td>
                                                    {{ $akunBelanja->count() * ($akunBelanja->currentPage() - 1) + $loop->iteration }}
                                                </td>
                                                <td>{{ $data->nama_akun_belanja }}</td>
                                                <td class="text-center">
                                                    @if ($data->active == 1)
                                                        <i class="mdi mdi-check text-success h4"></i>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h4"></i>
                                                    @endif
                                                </td>

                                                @if ($isAdmin)
                                                    <th>{{ $data->created_at }}</th>
                                                    <th>{{ $data->updated_at }}</th>
                                                @endif

                                                @if ($userAccess->update == 1 || $userAccess->delete == 1)
                                                    <td class="text-center">
                                                        @if ($userAccess->update == 1)
                                                            <a href="{{ route('akun-belanja.edit', ['akunBelanja' => $data->id]) }}"
                                                                class="btn btn-sm btn-light btn-icon mr-1"
                                                                data-toggle="tooltip" data-original-title="Edit"
                                                                data-placement="top">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->delete == 1)
                                                            <button class="btn btn-sm btn-light btn-icon"
                                                                data-toggle="tooltip" data-original-title="Hapus"
                                                                data-placement="top"
                                                                onclick="handleDelete({{ $data->id }})">
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
                    </div>
                    {{-- end table akun_belanja --}}

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end mt-3">
                            {{ $akunBelanja->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- form delete akun data akun belanja --}}
    <form id="form-delete-akun-belanja" method="POST">
        @csrf @method('DELETE')
    </form>
@endsection

@section('js-akun-belanja')
    <script>
        function handleDelete(id) {
            bootbox.confirm({
                title: `Anda ingin menghapus akun belanja ?`,
                message: `
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">
                            <i class="dripicons-warning mr-1"></i>
                            Peringatan!
                        </h4>

                        <ul>
                            <li>Tindakan ini tidak dapat dibatalkan.</li>
                            <li>Akun belanja yang dihapus tidak dapat dikembalikan.</li>
                            <li>Pastikan anda berhati-hati dalam menghapus.</li>
                        </ul>

                        <p>
                            <b>NB:</b> Akun belanja tidak dapat dihapus jika memilikin data pada relasi <b>Jenis Belanja</b>!
                        </p>
                    </div>
                `,
                buttons: {
                    confirm: {
                        label: "<i class='mdi mdi-delete mr-1'></i> Hapus",
                        className: "btn btn-danger btn-sm btn-rounded",
                    },
                    cancel: {
                        label: "<i class='mdi mdi-close-circle mr-1'></i> Batal",
                        className: "btn btn-sm btn-dark btn-rounded mr-2",
                    },
                },
                callback: (result) => {
                    if (result) {
                        const form = $("#form-delete-akun-belanja");

                        form.attr("action", `${main.baseUrl}/akun-belanja/${id}`);
                        form.submit();
                    }
                },
            });
        }
    </script>
@endsection
