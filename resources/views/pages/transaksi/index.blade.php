@extends('templates.main')

@section('title', 'Belanja')

@section('content')

    {{-- form filter --}}
    <div class="row">
        <div class="col-12 mb-3">
            <form action="{{ route('belanja') }}" method="GET" autocomplete="off">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Filter</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- input periode tanggal --}}
                            <div class="col-lg-8 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label> Periode <small class="text-danger">*</small></label>

                                    <div
                                        class="input-group @error('periode_awal') is-invalid @else @error('periode_akhir') is-invalid @enderror @enderror">
                                        <input type="date" name="periode_awal"
                                            class="form-control @error('periode_awal') is-invalid @enderror"
                                            id="periode_awal" placeholder="Masukan periode awal..."
                                            value="{{ old('periode_awal', request('periode_awal')) }}" required />

                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="mdi mdi-chevron-double-right"></i>
                                            </span>
                                        </div>

                                        <input type="date" name="periode_akhir"
                                            value="{{ old('periode_akhir', request('periode_akhir')) }}"
                                            class="form-control @error('periode_akhir') is-invalid @enderror"
                                            id="periode_akhir" placeholder="Masukan periode akhir..." required />
                                    </div>

                                    @error('periode_awal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        @error('periode_akhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @enderror
                                </div>
                            </div>
                            {{-- end input periode tanggal --}}

                            {{-- input nama divisi --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="divisi">Bagian</label>

                                    <select id="divisi" name="divisi" data-toggle="select2"
                                        class="form-control select2 @error('divisi') is-invalid @enderror">
                                        <option value="{{ null }}">Semua Bagian</option>

                                        @foreach ($divisi as $div)
                                            <option value="{{ $div->nama_divisi }}" @if (old('divisi', request('divisi')) == $div->nama_divisi) selected @endif>
                                                {{ $div->nama_divisi }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('divisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input nama divisi --}}

                            {{-- input jenis belanja --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="jenis_belanja">
                                        Akun Belanja
                                    </label>

                                    <select id="jenis_belanja" name="jenis_belanja" data-toggle="select2"
                                        class="form-control select2 @error('jenis_belanja') is-invalid @enderror">
                                        <option value="{{ null }}">Semua Akun Belanja</option>

                                        @foreach ($jenisBelanja as $jBelanja)
                                            <option value="{{ $jBelanja->kategori_belanja }}" @if (old('jenis_belanja', request('jenis_belanja')) == $jBelanja->kategori_belanja) selected @endif>
                                                {{ $jBelanja->kategori_belanja }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('jenis_belanja')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input jenis belanja --}}

                            {{-- input no dokumen --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="no_dokumen">
                                        No. Dokumen
                                    </label>

                                    <input type="search" name="no_dokumen"
                                        value="{{ old('no_dokumen', request('no_dokumen')) }}"
                                        class="form-control @error('no_dokumen') is-invalid @enderror" id="no_dokumen"
                                        placeholder="Masukan no dokumen..." />

                                    @error('no_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input no dokumen --}}

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-rounded btn-sm mr-2">
                            <i class="mdi mdi-filter-variant"></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end form filter --}}

    {{-- table belanja --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Belanja</h4>
                </div>

                <div class="card-body">

                    {{-- button tambah & form search --}}
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->pivot->create == 1)
                                <a href="{{ route('belanja.create') }}" class="btn btn-primary btn-sm btn-rounded">
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah Belanja</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3 d-flex justify-content-md-end">
                            <div class="btn-group btn-block">
                                <button type="submit" class="btn btn-success btn-sm btn-rounded btn-export"
                                    data-route="{{ route('belanja.excel') }}" @if (count($transactions) <= 0) disabled @endif>
                                    <span>Export Excel</span>
                                </button>

                                <button type="submit" class="btn btn-danger btn-sm btn-rounded btn-export"
                                    data-route="{{ route('belanja.pdf') }}" @if (count($transactions) <= 0) disabled @endif>
                                    <span>Cetak PDF</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- end button tambah & form search --}}

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-centered w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bagian</th>
                                            <th>Jenis Belanja</th>
                                            <th>Submitter</th>
                                            <th>Tanggal</th>
                                            <th>Kegiatan</th>
                                            <th>Jumlah Nominal</th>
                                            <th>Approval</th>
                                            <th>No. Dokumen</th>
                                            <th>Dibuat</th>
                                            <th>Diperbarui</th>
                                            <th class="text-center">Unduh File</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($transactions) > 0)
                                            @foreach ($transactions as $data)
                                                <tr>
                                                    <td>
                                                        {{ $transactions->count() * ($transactions->currentPage() - 1) + $loop->iteration }}
                                                    </td>
                                                    <td>{{ $data->nama_divisi }}</td>
                                                    <td>{{ $data->kategori_belanja }}</td>
                                                    <td>{{ $data->nama_lengkap }}</td>
                                                    <td>{{ $data->tanggal }}</td>
                                                    <td>{{ $data->kegiatan }}</td>
                                                    <td>Rp. {{ number_format($data->jumlah_nominal) }}</td>
                                                    <td>{{ $data->approval }}</td>
                                                    <td>{{ $data->no_dokumen }}</td>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->updated_at }}</td>
                                                    <td class="text-center">
                                                        @if ($data->file_dokumen)
                                                            <a href="{{ route('belanja.download', ['transaksi' => $data->id]) }}"
                                                                class="btn btn-sm btn-light btn-icon" data-toggle="tooltip"
                                                                data-original-title="Unduh" data-placement="top">
                                                                <i class="mdi mdi-download"></i>
                                                            </a>
                                                        @else
                                                            File tidak tersedia
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-light btn-icon mr-1"
                                                            data-toggle="tooltip" data-original-title="Detail"
                                                            data-placement="top"
                                                            onclick="transaksi.showDetail({{ $data->id }})">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </button>

                                                        @if ($userAccess->pivot->update == 1)
                                                            <a href="{{ route('belanja.edit', ['transaksi' => $data->id]) }}"
                                                                class="btn btn-sm btn-light btn-icon mr-1"
                                                                data-toggle="tooltip" data-original-title="Edit"
                                                                data-placement="top">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->pivot->delete == 1)
                                                            <button class="btn btn-sm btn-icon btn-light"
                                                                data-toggle="tooltip" data-original-title="Hapus"
                                                                data-placement="top"
                                                                onclick="transaksi.delete({{ $data->id }}, '{{ $data->no_dokumen }}')">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center align-middle">
                                                    Tidak ada data belanja
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>
    {{-- end table belanja --}}

    {{-- form delete transaksi --}}
    <form method="post" id="form-delete-transaksi">
        @method('DELETE') @csrf
    </form>

    {{-- form export excel & print pdf --}}
    <form id="form-export">
        @method('GET') @csrf
        <input type="hidden" name="periode_awal" value="{{ old('periode_awal', request('periode_awal')) }}" />
        <input type="hidden" name="periode_akhir" value="{{ old('periode_akhir', request('periode_akhir')) }}" />
        <input type="hidden" name="divisi" value="{{ old('divisi', request('divisi')) }}" />
    </form>

    {{-- modal detail --}}
    @include('pages.transaksi.detail')
@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/transaksi.js') }}"></script>
@endsection
