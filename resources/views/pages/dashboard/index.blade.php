@extends('templates.main')

@section('title', 'Dashboard')

@section('content')

    {{-- global budget chart --}}
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Global Budget Chart</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        {{-- Pie chart --}}
                        <div class="col-lg-8 col-md-6 col-sm-12 mb-3">
                            <div
                                id="global-chart"
                                class="apex-charts"
                            ></div>
                        </div>
                        {{-- end Pie chart --}}

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">

                            {{-- Form filter tahun periode --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="periode-divisi">Tahun Anggaran</label>
                                        <select
                                            id="periode-global"
                                            class="form-control form-control-sm select2"
                                            data-toggle="select2"
                                        >
                                            @foreach ($years as $year)
                                                <option
                                                    value="{{ $year }}"
                                                    @if ($year == date('Y')) selected @endif
                                                >
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <hr class="mt-3 mb-3">
                                </div>
                            </div>
                            {{-- end Form filter tahun periode --}}

                            {{-- deskripsi --}}
                            <div class="row">
                                <div class="col-12 chart-widget-list">
                                    <p>
                                        Bagian
                                        <span
                                            class="float-right"
                                            id="global-divisi"
                                        ></span>
                                    </p>
                                    <p>
                                        Total Budget
                                        <span
                                            class="float-right"
                                            id="global-total-budget"
                                        ></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-success"></i> Total Belanja
                                        <span
                                            class="float-right"
                                            id="global-total-belanja"
                                        ></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-primary"></i> Sisa Budget
                                        <span
                                            class="float-right"
                                            id="global-sisa-budget"
                                        ></span>
                                    </p>
                                </div>
                            </div>
                            {{-- end deskripsi chart global --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- global budget chart --}}

    @if ($isAdmin)

        {{-- chart budget per bagian (divisi) --}}
        <div class="row">
            <div class="col-sm-12 mb-3 border-bottom">
                <h4 class="header-title">
                    Budget Chart per Bagian
                </h4>
            </div>

            @foreach ($divisi as $data)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-header pt-3">
                            <h4 class="header-title">{{ $data->nama_divisi }}</h4>
                        </div>

                        <div class="card-body">

                            {{-- donut chart --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div
                                        class="apex-charts divisi-chart"
                                        data-divisi-id="{{ $data->id }}"
                                        id="divisi-{{ $data->id }}"
                                    ></div>
                                </div>
                            </div>
                            {{-- end donut chart --}}

                            {{-- form filter --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <select
                                            id="periode-divisi-{{ $data->id }}"
                                            class="form-control form-control-sm select2 periode-divisi"
                                            data-toggle="select2"
                                            data-divisi-id="{{ $data->id }}"
                                        >
                                            @foreach ($years as $year)
                                                <option
                                                    value="{{ $year }}"
                                                    @if ($year == date('Y')) selected @endif
                                                >
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- end form filter --}}

                            {{-- deskripsi --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="chart-widget-list">
                                        <p>
                                            Total Budget
                                            <span
                                                class="float-right"
                                                id="total-budget-divisi-{{ $data->id }}"
                                            ></span>
                                        </p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-square text-success"></i>
                                            Total Belanja
                                            <span
                                                class="float-right"
                                                id="total-belanja-divisi-{{ $data->id }}"
                                            ></span>
                                        </p>
                                        <p>
                                            <i class="mdi mdi-square text-danger"></i>
                                            Sisa Budget
                                            <span
                                                class="float-right"
                                                id="sisa-budget-divisi-{{ $data->id }}"
                                            ></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- end descripsi --}}

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- end chart budget per bagian (divisi) --}}

        {{-- Budget chart per akun_belanja --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Budget Chart per Akun Belanja</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- chart per akun belanja (jenis_belanja) --}}
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div
                                    id="admin__chart-by-akun-belanja"
                                    class="apex-charts"
                                ></div>
                            </div>

                            <div class="col-md-6 col-sm-12">

                                {{-- input filter --}}
                                <div class="row">

                                    {{-- select tahun anggaran --}}
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label for="admin__chart-by-akun-belanja__select-tahun-anggaran">Tahun Anggaran</label>

                                        <select
                                            id="admin__chart-by-akun-belanja__select-tahun-anggaran"
                                            class="form-control form-control-sm select2"
                                            data-toggle="select2"
                                        >
                                            @foreach ($years as $year)
                                                <option
                                                    value="{{ $year }}"
                                                    @if ($year == date('Y')) selected @endif
                                                >
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- select bagian (divisi) --}}
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label for="admin__chart-by-akun-belanja__select-divisi">Bagian</label>

                                        <select
                                            id="admin__chart-by-akun-belanja__select-divisi"
                                            class="form-control form-control-sm select2"
                                            data-toggle="select2"
                                        >

                                            <option value="{{ null }}">Semua Bagian</option>

                                            @foreach ($divisi as $divChartByAkunBelanja)
                                                <option value="{{ $divChartByAkunBelanja->id }}">
                                                    {{ $divChartByAkunBelanja->nama_divisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="row mb-3">

                                    {{-- select akun belanja --}}
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label for="admin__chart-by-akun-belanja__select-akun-belanja">Akun Belanja</label>

                                        <select
                                            id="admin__chart-by-akun-belanja__select-akun-belanja"
                                            class="form-control form-control-sm select2"
                                            data-toggle="select2"
                                        >

                                            <option value="{{ null }}">Semua Akun Belanja</option>

                                            @foreach ($akunBelanja as $aBelanja)
                                                <option value="{{ $aBelanja->id }}">
                                                    {{ $aBelanja->nama_akun_belanja }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- select jenis_belanja --}}
                                    <div class="form-group col-lg-6 col-sm-12">
                                        <label for="admin__chart-by-akun-belanja__select-jenis-belanja">Jenis Belanja</label>

                                        <select
                                            id="admin__chart-by-akun-belanja__select-jenis-belanja"
                                            class="form-control form-control-sm select2"
                                            data-toggle="select2"
                                        >

                                            <option value="{{ null }}">Semua Jenis Belanja</option>

                                            @foreach ($jenisBelanja as $jBelanja)
                                                <option value="{{ $jBelanja->id }}">
                                                    {{ $jBelanja->kategori_belanja }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                {{-- end input filter --}}

                                {{-- deskripsi --}}
                                <div class="row">
                                    <div class="col-12 chart-widget-list">
                                        <p>
                                            Total Budget
                                            <span
                                                class="float-right"
                                                id="admin__chart-by-akun-belanja__total-budget"
                                            ></span>
                                        </p>
                                        <p>
                                            <i class="mdi mdi-square text-info"></i> Total Belanja
                                            <span
                                                class="float-right"
                                                id="admin__chart-by-akun-belanja__total-transaksi"
                                            ></span>
                                        </p>
                                        <p>
                                            <i class="mdi mdi-square text-warning"></i> Sisa Budget
                                            <span
                                                class="float-right"
                                                id="admin__chart-by-akun-belanja__sisa-budget"
                                            ></span>
                                        </p>
                                    </div>
                                </div>
                                {{-- end deskripsi chart global --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end Budget chart per akun_belanja --}}

    @else

        {{-- chart line per bagian (divisi) --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Grafik Transaksi Belanja per Akun Belanja</h4>
                    </div>

                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="divisi__transaksi-chart-line__select-tahun-anggaran">Periode Tahun</label>

                                    <select
                                        id="divisi__transaksi-chart-line__select-tahun-anggaran"
                                        class="form-control select2"
                                        data-toggle="select2"
                                    >
                                        @foreach ($years as $year)
                                            <option
                                                value="{{ $year }}"
                                                @if ($year == date('Y')) selected @endif
                                            >
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div
                                    id="divisi__transaksi-chart-line"
                                    class="apex-charts"
                                    data-colors="#727cf5,#0acf97"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- chart line per bagian (divisi) --}}

    @endif

@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endsection
