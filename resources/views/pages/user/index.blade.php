@extends('templates.main')

@section('title', 'User')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- title & btn tambah --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">Tabel User</h4>
                            <a
                                href="{{ route('user.create') }}"
                                class="btn btn-sm btn-primary"
                            >
                                <i class="mdi mdi-plus"></i>
                                <span>Tambah User</span>
                            </a>
                        </div>
                    </div>
                    {{-- end title & btn tambah --}}

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form
                                action="{{ route('user') }}"
                                method="GET"
                                autocomplete="off"
                            >
                                <div class="input-group">
                                    <input
                                        type="search"
                                        name="search"
                                        placeholder="Cari user..."
                                        class="form-control"
                                        value="{{ request('search') }}"
                                    />
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
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
                                            <th>Avatar</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Divisi</th>
                                            <th>Level</th>
                                            <th>Aktif</th>
                                            <th>Diperbarui</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $users->currentPage() + $loop->iteration - 1 }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($user->avatar != null)
                                                        <img
                                                            src="{{ asset('storage/' . $user->avatar) }}"
                                                            alt="avatar"
                                                            class="img-fluid avatar-sm rounded-circle"
                                                        />
                                                    @else
                                                        <img
                                                            src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                                            alt="avatar"
                                                            class="img-fluid avatar-sm rounded-circle"
                                                        />
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{ $user->username }}</td>
                                                <td class="align-middle">{{ ucwords($user->nama_lengkap) }}</td>
                                                <td class="align-middle">{{ ucwords($user->nama_divisi) }}</td>
                                                <td class="align-middle">{{ ucwords($user->level) }}</td>
                                                <td class="align-middle">
                                                    @if ($user->active == 1)
                                                        <i class="mdi mdi-check-bold text-success h3"></i>
                                                    @else
                                                        <i class="mdi mdi-close-circle-outline text-danger h3"></i>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{ $user->updated_at }}</td>
                                                <td class="align-middle text-center">
                                                    <a
                                                        href="{{ route('user.edit', ['user' => $user->id]) }}"
                                                        class="btn btn-sm btn-outline-success mr-1"
                                                    >
                                                        Edit
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            {{ $users->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>
@endsection
