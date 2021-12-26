@extends('templates.main')

@section('title', 'Belanja')

@section('content')

    {{-- form filter --}}
    <div class="row">
        <div class="col-12 mb-3">
            <form
                action="{{ route('belanja') }}"
                method="GET"
                autocomplete="off"
            >
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Filter</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- input periode tanggal --}}
                            <div class="col-lg-8 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>
                                        Periode <small class="ml-1 text-danger">*</small>
                                    </label>

                                    <div
                                        class="input-group @error('periodeAwal') is-invalid @else @error('periodeAkhir') is-invalid @enderror @enderror">
                                        <input
                                            type="date"
                                            name="periodeAwal"
                                            class="form-control @error('periodeAwal') is-invalid @enderror"
                                            id="periodeAwal"
                                            placeholder="Masukan periode awal..."
                                            value="{{ old('periodeAwal', request('periodeAwal')) }}"
                                            required
                                        />

                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text"
                                                id="basic-addon1"
                                            >
                                                <i class="mdi mdi-chevron-double-right"></i>
                                            </span>
                                        </div>

                                        <input
                                            type="date"
                                            name="periodeAkhir"
                                            value="{{ old('periodeAkhir', request('periodeAkhir')) }}"
                                            class="form-control @error('periodeAkhir') is-invalid @enderror"
                                            id="periodeAkhir"
                                            placeholder="Masukan periode akhir..."
                                            required
                                        />
                                    </div>

                                    @error('periodeAwal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        @error('periodeAkhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @enderror
                                </div>
                            </div>
                            {{-- end input periode tanggal --}}

                            {{-- input nama divisi --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="divisi">
                                        Bagian
                                    </label>

                                    <select
                                        id="divisi"
                                        name="divisi"
                                        data-toggle="select2"
                                        class="form-control select2 @error('divisi') is-invalid @enderror"
                                    >
                                        <option value="{{ null }}">Semua Bagian</option>

                                        @foreach ($divisi as $div)
                                            <option
                                                value="{{ $div->nama_divisi }}"
                                                @if (old('divisi', request('divisi')) == $div->nama_divisi) selected @endif
                                            >
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
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="jenisBelanja">
                                        Jenis Belanja
                                    </label>

                                    <select
                                        id="jenisBelanja"
                                        name="jenisBelanja"
                                        data-toggle="select2"
                                        class="form-control select2 @error('jenisBelanja') is-invalid @enderror"
                                    >
                                        <option value="{{ null }}">Semua Jenis Belanja</option>

                                        @foreach ($jenisBelanja as $jBelanja)
                                            <option
                                                value="{{ $jBelanja->kategori_belanja }}"
                                                @if (old('jenisBelanja', request('jenisBelanja')) == $jBelanja->kategori_belanja) selected @endif
                                            >
                                                {{ $jBelanja->kategori_belanja }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('jenisBelanja')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input jenis belanja --}}

                            {{-- input no dokumen --}}
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="noDokumen">
                                        No. Dokumen
                                    </label>

                                    <input
                                        type="search"
                                        name="noDokumen"
                                        value="{{ old('noDokumen', request('noDokumen')) }}"
                                        class="form-control @error('noDokumen') is-invalid @enderror"
                                        id="noDokumen"
                                        placeholder="Masukan no dokumen..."
                                    />

                                    @error('noDokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end input no dokumen --}}

                        </div>

                        {{-- button submit & reset --}}
                        <div class="row">
                            <div class="col-12">
                                <button
                                    type="submit"
                                    class="btn btn-info btn-rounded mr-2"
                                >
                                    <i class="mdi mdi-filter-variant"></i>
                                    <span>Filter</span>
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-rounded btn-secondary"
                                >
                                    <i class="mdi mdi-close"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>
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
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->pivot->create == 1)
                                <a
                                    href="{{ route('belanja.create') }}"
                                    class="btn btn-primary btn-rounded"
                                >
                                    <i class="mdi mdi-plus"></i>
                                    <span>Tambah Belanja</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3 d-flex justify-content-md-end">
                            <div class="btn-group btn-block">
                                <button
                                    type="submit"
                                    class="btn btn-success btn-rounded btn-export"
                                    data-route="{{ route('belanja.excel') }}"
                                    @if (count($transactions) <= 0) disabled @endif
                                >
                                    <span>Export Excel</span>
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-rounded btn-export"
                                    data-route="{{ route('belanja.pdf') }}"
                                    @if (count($transactions) <= 0) disabled @endif
                                >
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
                                <table class="table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Bagian</th>
                                            <th>Submitter</th>
                                            <th>Jenis Belanja</th>
                                            <th>Kegiatan</th>
                                            <th>Jumlah Nominal</th>
                                            <th>Approval</th>
                                            <th>No. Dokumen</th>
                                            <th class="text-center">Unduh File</th>
                                            <th>Diperbarui</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($transactions) > 0)
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td class="align-middle">
                                                        {{ $transactions->currentPage() + $loop->iteration - 1 }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->tanggal }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->divisi->nama_divisi }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->user->profil->nama_lengkap }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->jenisBelanja->kategori_belanja }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->kegiatan }}
                                                    </td>
                                                    <td class="align-middle">
                                                        Rp. {{ number_format($transaction->jumlah_nominal) }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->approval }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->no_dokumen }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if ($transaction->file_dokumen)
                                                            <a
                                                                href="{{ route('belanja.download', ['transaksi' => $transaction->id]) }}"
                                                                class="btn btn-sm btn-primary btn-icon"
                                                                data-toggle="tooltip"
                                                                data-original-title="Unduh"
                                                                data-placement="top"
                                                            >
                                                                <i class="mdi mdi-download"></i>
                                                            </a>
                                                        @else
                                                            File tidak tersedia
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $transaction->updated_at }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button
                                                            class="btn btn-sm btn-info btn-icon mr-1"
                                                            data-toggle="tooltip"
                                                            data-original-title="Detail"
                                                            data-placement="top"
                                                            onclick="transaksi.showDetail({{ $transaction->id }})"
                                                        >
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </button>

                                                        @if ($userAccess->pivot->update == 1)
                                                            <a
                                                                href="{{ route('belanja.edit', ['transaksi' => $transaction->id]) }}"
                                                                class="btn btn-sm btn-success btn-icon mr-1"
                                                                data-toggle="tooltip"
                                                                data-original-title="Edit"
                                                                data-placement="top"
                                                            >
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->pivot->delete == 1)
                                                            <button
                                                                class="btn btn-sm btn-icon btn-danger"
                                                                data-toggle="tooltip"
                                                                data-original-title="Hapus"
                                                                data-placement="top"
                                                                onclick="transaksi.delete({{ $transaction->id }}, '{{ $transaction->no_dokumen }}')"
                                                            >
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td
                                                    colspan="12"
                                                    class="text-center align-middle"
                                                >
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
    <form
        method="post"
        id="form-delete-transaksi"
    >
        @method('DELETE') @csrf
    </form>

    {{-- form export excel & print pdf --}}
    <form id="form-export">
        @method('GET') @csrf

        <input
            type="hidden"
            name="periodeAwal"
            value="{{ old('periodeAwal', request('periodeAwal')) }}"
        />

        <input
            type="hidden"
            name="periodeAkhir"
            value="{{ old('periodeAkhir', request('periodeAkhir')) }}"
        />

        <input
            type="hidden"
            name="divisi"
            value="{{ old('divisi', request('divisi')) }}"
        />
    </form>

    {{-- modal detail --}}
    @include('pages.transaksi.detail')
@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/transaksi.js') }}"></script>
@endsection
