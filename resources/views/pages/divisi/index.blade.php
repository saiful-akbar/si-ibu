<x-layouts.auth title="Bagian">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Bagian</h4>
                </div>

                <div class="card-body">

                    {{-- Button tambah & form search --}}
                    <div class="row align-items-center">
                        <div class="col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->create)
                                <a href="{{ route('divisi.create') }}" class="btn btn-sm btn-primary">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah Bagian</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <x-form action="{{ route('divisi') }}" method="GET">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari bagian..." class="form-control"
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

                    {{-- Tabel divisi (bagian) --}}
                    <div class="row">
                        <div class="col-12">
                            <x-table :paginator="$divisi">
                                <x-slot name="thead">
                                    <tr>
                                        <th>Nama Bagian</th>
                                        <th class="text-center">Aktif</th>
                                        <th>Dibuat</th>
                                        <th>Diperbarui</th>

                                        @if ($userAccess->update || $userAccess->delete)
                                            <th class="text-center">Aksi</th>
                                        @endif
                                    </tr>
                                </x-slot>

                                <x-slot name="tbody">
                                    @foreach ($divisi as $data)
                                        <tr>
                                            <td>{{ $data->nama_divisi }}</td>
                                            <td class="text-center">
                                                <x-active-check :active="$data->active" />
                                            </td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->updated_at }}</td>

                                            @if ($userAccess->update || $userAccess->delete)
                                                <td class="text-center">
                                                    @if ($userAccess->update)
                                                        <a href="{{ route('divisi.edit', ['divisi' => $data->id]) }}"
                                                            class="btn btn-sm btn-secondary btn-icon mx-1" data-toggle="tooltip"
                                                            data-original-title="Edit" data-placement="top">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                    @endif

                                                    @if ($userAccess->delete)
                                                        <button
                                                            onclick="handleDelete({{ $data->id }}, '{{ $data->nama_divisi }}')"
                                                            class="btn btn-sm btn-secondary btn-icon mx-1" data-toggle="tooltip"
                                                            data-original-title="Hapus" data-placement="top">
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
                    {{-- End tabel divisi (bagian) --}}

                </div>
            </div>
        </div>
    </div>

    {{-- Form delete --}}
    <x-form class="d-none" method="DELETE" id="form-delete"></x-form>

    <x-slot name="script">
        <script src="{{ asset('assets/js/pages/divisi.js') }}"></script>
    </x-slot>
</x-layouts.auth>
