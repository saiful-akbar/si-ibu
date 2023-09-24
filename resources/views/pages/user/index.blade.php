<x-layouts.auth title="User">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">
                        Tabel User
                    </h4>
                </div>

                <div class="card-body">

                    {{-- Button tambah & form search --}}
                    <div class="row align-items-center">
                        <div class="col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->create)
                                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah User</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <x-form action="{{ route('user') }}" method="GET">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari user..." class="form-control"
                                        value="{{ request('search') }}" />

                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
                                            <i class="uil-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </x-form>
                        </div>
                    </div>
                    {{-- End button tambah & form search --}}

                    {{-- Table user --}}
                    <div class="row">
                        <div class="col-12">
                            <x-table :paginator="$users">
                                <x-slot name="thead">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Bagian</th>
                                        <th>Seksi</th>
                                        <th class="text-center">Aktif</th>
                                        <th>Dibuat</th>
                                        <th>Diperbarui</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </x-slot>

                                <x-slot name="tbody">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="table-user align-middle">
                                                @isset($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                                        class="rounded-circle mr-2" />
                                                @else
                                                    <img src="{{ asset('assets/images/avatars/avatar_default.webp') }}" alt="avatar"
                                                        class="rounded-circle mr-2" />
                                                @endisset

                                                {{ $user->nama_lengkap }}
                                            </td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->nama_divisi }}</td>
                                            <td>{{ $user->seksi }}</td>
                                            <td class="text-center">
                                                <x-active-check :active="$user->active" />
                                            </td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>{{ $user->updated_at }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.menu-akses.detail', ['user' => $user->id]) }}"
                                                    class="btn btn-sm btn-secondary btn-icon mx-1" data-toggle="tooltip"
                                                    data-original-title="Menu Akses">
                                                    <i class="mdi mdi-key"></i>
                                                </a>

                                                @if ($userAccess->update == 1)
                                                    <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                                                        class="btn btn-sm btn-secondary btn-icon mx-1" data-toggle="tooltip"
                                                        data-original-title="Edit">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                @endif

                                                @if ($userAccess->delete == 1)
                                                    <button onclick="handleDelete({{ $user->id }})"
                                                        class="btn btn-sm btn-secondary btn-icon mx-1" data-toggle="tooltip"
                                                        data-original-title="Hapus">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-table>
                        </div>
                    </div>
                    {{-- End table user --}}

                </div>
            </div>
        </div>
    </div>

    {{-- Form delete --}}
    <x-form method="DELETE" id="form-delete" class="d-none"></x-form>

    <x-slot name="script">
        <script src="{{ asset('assets/js/pages/user.js') }}"></script>
    </x-slot>
</x-layouts.auth>
