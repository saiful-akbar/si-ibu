@extends('templates.arsip-master')

@section('title', 'Master Type Arsip')

@section('content-arsip-master')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">
                        Table Master Type Arsip
                    </h4>
                </div>

                <div class="card-body">

                    {{-- form search --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('arsip.master.type') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari type..." class="form-control"
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
                                <table class="table table table-centered nowrap w-100">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Nama Type</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($arsTypes as $arsType)
                                            <tr>
                                                <td>
                                                    {{ $arsTypes->perPage() * ($arsTypes->currentPage() - 1) + $loop->iteration }}
                                                </td>
                                                <td>{{ $arsType->MSARSCategory->Name }}</td>
                                                <td>{{ $arsType->Name }}</td>
                                                <td>{{ $arsType->Description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    {{-- table pagination --}}
                    <div class="row">
                        <div class="col-sm-12">
                            {{ $arsTypes->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
