<x-layouts.auth title="Master Kategori Arsip">
    <x-layouts.arsip-master>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">
                            Table Master Kategori Arsip
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-lg-6 col-md-8 col-sm-12 mb-3">
                                <x-form action="{{ route('arsip.master.category') }}" method="GET">
                                    <div class="input-group">
                                        <input
                                            type="search"
                                            name="search"
                                            placeholder="Cari kategori..."
                                            class="form-control"
                                            value="{{ request('search') }}"
                                        />

                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="submit">
                                                <i class="uil-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </x-form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="table-responsive">
                                    <x-table :paginator="$arsCategories">
                                        <x-slot name="thead">
                                            <tr>
                                                <th>Nama Kategori</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </x-slot>

                                        <x-slot name="tbody">
                                            @foreach ($arsCategories as $arsCategory)
                                                <tr>
                                                    <td>{{ $arsCategory->Name }}</td>
                                                    <td>{{ $arsCategory->Description }}</td>
                                                </tr>
                                            @endforeach
                                        </x-slot>
                                    </x-table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.arsip-master>
</x-layouts.auth>
