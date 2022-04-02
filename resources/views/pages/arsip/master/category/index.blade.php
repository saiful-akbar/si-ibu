@extends('templates.arsip-master')

@section('title', 'Master Kategori Arsip')

@section('content-arsip-master')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">
                        Table Master Kategori Arsip
                    </h4>
                </div>

                <div class="card-body">

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('arsip.master.category') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari kategori..." class="form-control"
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

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table table-centered table-hover nowrap w-100">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($arsCategories as $arsCategory)
                                            <tr>
                                                <td>
                                                    {{ $arsCategories->perPage() * ($arsCategories->currentPage() - 1) + $loop->iteration }}
                                                </td>
                                                <td>{{ $arsCategory->Name }}</td>
                                                <td>{{ $arsCategory->Description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- table pagination --}}
                    <div class="row">
                        <div class="col-12">
                            {{ $arsCategories->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
