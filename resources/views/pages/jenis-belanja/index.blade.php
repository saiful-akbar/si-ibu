@extends('templates.akun-belanja')

@section('title', 'Jenis Belanja')

@section('content-akun-belanja')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Jenis Belanja</h4>
                </div>

                <div class="card-body">

                    {{-- button tambah & form search --}}
                    <div class="row align-items-center">
                        <div class="col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->create == 1)
                                <a
                                    href="{{ route('jenis-belanja.create') }}"
                                    class="btn btn-rounded btn-primary btn-sm"
                                >
                                    <i class="mdi mdi-plus-circle mr-1"></i>
                                    <span>Tambah Jenis Belanja</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <form
                                action="{{ route('jenis-belanja') }}"
                                method="GET"
                                autocomplete="off"
                            >
                                <div class="input-group">
                                    <input
                                        type="search"
                                        name="search"
                                        placeholder="Cari jenis belanja..."
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
                                <table class="table table-centered nowrap w-100">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Akun Belanja</th>
                                            <th>Kategori Belanja</th>
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
                                        @foreach ($jenisBelanja as $data)
                                            <tr>
                                                <td>
                                                    {{ $jenisBelanja->perPage() * ($jenisBelanja->currentPage() - 1) + $loop->iteration }}
                                                </td>

                                                <td>{{ $data->akunBelanja->nama_akun_belanja }}</td>
                                                <td>{{ $data->kategori_belanja }}</td>

                                                <td class="text-center">
                                                    @if ($data->active == 1)
                                                        <i class="mdi mdi-check text-success h4"></i>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h4"></i>
                                                    @endif
                                                </td>

                                                @if ($isAdmin)
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->updated_at }}</td>
                                                @endif

                                                @if ($userAccess->update == 1 || $userAccess->delete == 1)
                                                    <td class="text-cente">
                                                        @if ($userAccess->update == 1)
                                                            <a
                                                                href="{{ route('jenis-belanja.edit', ['jenisBelanja' => $data->id]) }}"
                                                                class="btn btn-sm btn-light btn-icon mx-1"
                                                                data-toggle="tooltip"
                                                                data-original-title="Edit"
                                                                data-placement="top"
                                                            >
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->delete == 1)
                                                            <button
                                                                class="btn btn-sm btn-light btn-icon mx-1"
                                                                data-toggle="tooltip"
                                                                data-original-title="Hapus"
                                                                data-placement="top"
                                                                onclick="akunBelanja.deleteJenisBelanja({{ $data->id }})"
                                                            >
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

                        {{-- paginasi --}}
                        <div class="col-12 d-flex justify-content-end">
                            {{ $jenisBelanja->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>

    {{-- form delete --}}
    <form
        method="POST"
        id="form-delete-jenis-belanja"
    >
        @method('DELETE') @csrf
    </form>
@endsection

@section('js-akun-belanja')
    <script src="{{ asset('assets/js/pages/akunBelanja.js') }}"></script>
@endsection
