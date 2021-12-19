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
                                <a href="{{ route('budget.create') }}" class="btn btn-sm btn-primary">
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

                                            @if ($userAccess->pivot->update == 1 || $userAccess->pivot->delete == 1)
                                                <th class="text-center">Aksi</th>
                                            @endif
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

                                                @if ($userAccess->pivot->update == 1 || $userAccess->pivot->delete == 1)
                                                    <td class="align-middel text-center">
                                                        @if ($userAccess->pivot->update == 1)
                                                            <a href="{{ route('budget.edit', ['budget' => $data->id]) }}"
                                                                class="btn btn-sm btn-success mr-1">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->pivot->delete == 1)
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="handleDelete({{ $data->id }}, '{{ $data->nama_divisi }}')">
                                                                <i class="mdi mdi-delete"></i>
                                                                <span>Hapus</span>
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
@endsection

@section('js')
    <script>
        const main = new Main();

        /**
         * Fungsi handle hapus data budget
         *
         * @param {int} id
         * @param {string} divisi
         */
        const handleDelete = (id, divisi) => {
            bootbox.confirm({
                title: "Peringatan!",
                message: `
                    <ul>
                        <li>Yakin ingin menghapus budget pada divisi <strong>${divisi}</strong> ?</li>
                        <li>Semua data terkait atau data yang berelasi dengan budget divisi ini juga akan terhapus.</li>
                    </ul>
                `,
                buttons: {
                    confirm: {
                        label: "Hapus",
                        className: "btn-danger btn-sm"
                    },
                    cancel: {
                        label: "Batal",
                        className: "btn-secondary btn-sm"
                    },
                },
                callback: (result) => {
                    if (result) {
                        const form = $("#form-delete-budget");

                        form.attr("action", `${main.baseUrl}/budget/${id}`);
                        form.submit();
                    }
                },
            });
        }
    </script>
@endsection
