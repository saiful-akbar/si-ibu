@extends('templates.main')

@section('title', 'Laporan Transaksi')

@section('content')

    {{-- form filter --}}
    <div class="row">
        <div class="col-12 mb-3">
            <form
                action="{{ route('laporan-transaksi') }}"
                method="GET"
                autocomplete="off"
            >
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Filter Transaksi</h4>
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
                                            id="periode-awal"
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
                                            id="periode-akhir"
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
                                        Divisi
                                    </label>

                                    <select
                                        id="divisi"
                                        name="divisi"
                                        data-toggle="select2"
                                        class="form-control select2 @error('divisi') is-invalid @enderror"
                                    >
                                        <option value="{{ null }}">Semua Divisi</option>

                                        @foreach ($divisi as $div)
                                            <option
                                                value="{{ $div->nama_divisi }}"
                                                @if (request('divisi') == $div->nama_divisi) selected @endif
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

    {{-- table laporan transaksi --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Table Laporan Transaksi</h4>
                </div>

                <div class="card-body">

                    {{-- button export --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="btn-group">
                                <button
                                    type="submit"
                                    class="btn btn-success btn-rounded btn-export"
                                    data-route="{{ route('laporan-transaksi.excel') }}"
                                    @if (count($laporanTransaksi) <= 0) disabled @endif
                                >
                                    <span>Export Excel</span>
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-rounded btn-export"
                                    data-route="{{ route('laporan-transaksi.pdf') }}"
                                    @if (count($laporanTransaksi) <= 0) disabled @endif
                                >
                                    <span>Cetak PDF</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- button export --}}

                    {{-- table laporan --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Divisi</th>
                                            <th>Submitter</th>
                                            <th>Jenis Belanja</th>
                                            <th>Kegiatan</th>
                                            <th>Jumlah Nominal</th>
                                            <th>No. Dokumen</th>
                                            <th>Approval</th>
                                            <th>Dibuat</th>
                                            <th>Diperbarui</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (count($laporanTransaksi) > 0)
                                            @foreach ($laporanTransaksi as $laporan)
                                                <tr>
                                                    <td class="align-minddle">
                                                        {{ $laporanTransaksi->currentPage() + $loop->iteration - 1 }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->tanggal }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->divisi->nama_divisi }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->user->profil->nama_lengkap }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->jenisBelanja->kategori_belanja }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->kegiatan }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        Rp. {{ number_format($laporan->jumlah_nominal) }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->no_dokumen }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->approval }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->created_at }}
                                                    </td>
                                                    <td class="align-minddle">
                                                        {{ $laporan->updated_at }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td
                                                    colspan="11"
                                                    class="text-center align-middle"
                                                >
                                                    Tidak ada data transaksi
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end tabel laporan --}}

                    {{-- pagination --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12 d-flex justify-content-end">
                                {{ $laporanTransaksi->links() }}
                            </div>
                        </div>
                    </div>
                    {{-- end pagination --}}

                </div>
            </div>
        </div>
    </div>
    {{-- end table laporan transaksi --}}

    {{-- export excel --}}
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

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.btn-export').click(function(e) {
                e.preventDefault();

                const route = $(this).data('route');
                const formExport = $('#form-export');

                formExport.attr('action', route);

                formExport.submit();
            });
        });
    </script>
@endsection
