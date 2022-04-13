<x-layouts.auth title="Jenis Belanja">
    <x-layouts.akun-belanja>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Tabel Jenis Belanja</h4>
                    </div>

                    <div class="card-body">

                        {{-- Button tambah & form search --}}
                        <div class="row align-items-center">
                            <div class="col-md-6 col-sm-12 mb-3">
                                @if ($userAccess->create)
                                    <a href="{{ route('jenis-belanja.create') }}" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-plus"></i>
                                        <span>Tambah Jenis Belanja</span>
                                    </a>
                                @endif
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3">
                                <x-form action="{{ route('jenis-belanja') }}" method="GET">
                                    <div class="input-group">
                                        <input type="search" name="search" placeholder="Cari jenis belanja..."
                                            class="form-control" value="{{ request('search') }}" />

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

                        {{-- Table jenis belanja --}}
                        <div class="row">
                            <div class="col-12">
                                <x-table :paginator="$jenisBelanja">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>Akun Belanja</th>
                                            <th>Kategori Belanja</th>
                                            <th class="text-center">Aktif</th>
                                            <th>Dibuat</th>
                                            <th>Diperbarui</th>

                                            @if ($userAccess->update || $userAccess->delete)
                                                <th class="text-center">Aksi</th>
                                            @endif
                                        </tr>
                                    </x-slot>

                                    <x-slot name="tbody">
                                        @foreach ($jenisBelanja as $data)
                                            <tr>
                                                <td>{{ $data->akunBelanja->nama_akun_belanja }}</td>
                                                <td>{{ $data->kategori_belanja }}</td>
                                                <td class="text-center">
                                                    <x-active-check :active="$data->active" />
                                                </td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>{{ $data->updated_at }}</td>

                                                @if ($userAccess->update || $userAccess->delete)
                                                    <td class="text-cente">
                                                        @if ($userAccess->update)
                                                            <a href="{{ route('jenis-belanja.edit', ['jenisBelanja' => $data->id]) }}"
                                                                class="btn btn-sm btn-secondary btn-icon mx-1"
                                                                data-toggle="tooltip" data-original-title="Edit"
                                                                data-placement="top">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->delete)
                                                            <button class="btn btn-sm btn-secondary btn-icon mx-1"
                                                                data-toggle="tooltip" data-original-title="Hapus"
                                                                data-placement="top"
                                                                onclick="akunBelanja.deleteJenisBelanja({{ $data->id }})">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </x-slot>
                                </x-table>
                            </div>
                        </div>
                        {{-- End table jenis belanja --}}

                    </div>
                </div>
            </div>
        </div>
    </x-layouts.akun-belanja>

    {{-- Form delete --}}
    <x-form method="DELETE" id="form-delete"></x-form>

    <x-slot name="script">
        <script src="{{ asset('assets/js/pages/akunBelanja.js') }}"></script>
    </x-slot>
</x-layouts.auth>
