<x-layouts.auth title="Dashboard">

    {{-- global budget chart --}}
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Global pagu chart</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        {{-- Pie chart --}}
                        <div class="col-lg-8 col-md-6 col-sm-12 my-3">
                            <div id="global-chart" class="apex-charts"></div>
                        </div>
                        {{-- end Pie chart --}}

                        <div class="col-lg-4 col-md-6 col-sm-12">

                            {{-- Form filter tahun periode --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="periode-divisi">Tahun Anggaran</label>
                                        <select id="periode-global" class="form-control form-control-sm select2"
                                            data-toggle="select2">
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}"
                                                    @if ($year == date('Y')) selected @endif>
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
                                        <span class="float-right" id="global-divisi"></span>
                                    </p>
                                    <p>
                                        Total Pagu
                                        <span class="float-right" id="global-total-budget"></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-success"></i> Total Realisasi
                                        <span class="float-right" id="global-total-belanja"></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-primary"></i> Sisa Pagu
                                        <span class="float-right" id="global-sisa-budget"></span>
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

    {{-- chart budget per bagian (divisi) --}}
    @if ($isAdmin)
        <div class="row">
            <div class="col-sm-12 border-bottom mb-3">
                <h4 class="header-title">
                    Pagu chart per bagian
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
                                    <div class="apex-charts divisi-chart" data-divisi-id="{{ $data->id }}"
                                        id="divisi-{{ $data->id }}"></div>
                                </div>
                            </div>

                            {{-- form filter --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <select id="periode-divisi-{{ $data->id }}"
                                            class="form-control form-control-sm select2 periode-divisi" data-toggle="select2"
                                            data-divisi-id="{{ $data->id }}">
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}"
                                                    @if ($year == date('Y')) selected @endif>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- deskripsi --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="chart-widget-list">
                                        <p>
                                            Total Pagu
                                            <span class="float-right" id="total-budget-divisi-{{ $data->id }}"></span>
                                        </p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-square text-success"></i>
                                            Total Realisasi
                                            <span class="float-right" id="total-belanja-divisi-{{ $data->id }}"></span>
                                        </p>
                                        <p>
                                            <i class="mdi mdi-square text-danger"></i>
                                            Sisa Pagu
                                            <span class="float-right" id="sisa-budget-divisi-{{ $data->id }}"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Budget chart per akun_belanja --}}
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Pagu chart per akun belanja</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        {{-- chart per akun belanja (jenis_belanja) --}}
                        <div class="col-md-6 col-sm-12 my-3">
                            <div id="chart-by-akun-belanja" class="apex-charts"></div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">

                                {{-- select tahun anggaran --}}
                                <div class="form-group col-lg-6 col-sm-12 mb-3">
                                    <label for="chart-by-akun-belanja__select-tahun-anggaran">Tahun Anggaran</label>

                                    <select id="chart-by-akun-belanja__select-tahun-anggaran"
                                        class="form-control form-control-sm select2" data-toggle="select2">
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                @if ($year == date('Y')) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- select bagian (divisi) --}}
                                @if ($isAdmin)
                                    <div class="form-group col-lg-6 col-sm-12 mb-3">
                                        <label for="chart-by-akun-belanja__select-divisi">Bagian</label>

                                        <select id="chart-by-akun-belanja__select-divisi"
                                            class="form-control form-control-sm select2" data-toggle="select2">
                                            <option value="{{ null }}">
                                                -- Semua --
                                            </option>

                                            @foreach ($divisi as $divChartByAkunBelanja)
                                                <option value="{{ $divChartByAkunBelanja->id }}">
                                                    {{ $divChartByAkunBelanja->nama_divisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                {{-- select akun belanja --}}
                                <div class="form-group col-lg-6 col-sm-12 mb-3">
                                    <label for="chart-by-akun-belanja__select-akun-belanja">Akun Belanja</label>

                                    <select id="chart-by-akun-belanja__select-akun-belanja"
                                        class="form-control form-control-sm select2" data-toggle="select2">
                                        <option value="{{ null }}">-- Semua --</option>

                                        @foreach ($akunBelanja as $aBelanja)
                                            <option value="{{ $aBelanja->id }}">
                                                {{ $aBelanja->nama_akun_belanja }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- select jenis_belanja --}}
                                <div class="form-group col-lg-6 col-sm-12 mb-3">
                                    <label for="chart-by-akun-belanja__select-jenis-belanja">Jenis Belanja</label>

                                    <select id="chart-by-akun-belanja__select-jenis-belanja"
                                        class="form-control form-control-sm select2" data-toggle="select2">
                                        <option value="{{ null }}">-- Semua --</option>
                                    </select>
                                </div>

                            </div>

                            {{-- deskripsi --}}
                            <div class="row">
                                <div class="col-12 chart-widget-list">
                                    <p>
                                        Total Pagu
                                        <span class="float-right" id="chart-by-akun-belanja__total-budget"></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-danger"></i> Realisasi Outstanding
                                        <span class="float-right" id="chart-by-akun-belanja__total-outstanding"></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-success"></i> Realisasi Ontstanding
                                        <span class="float-right" id="chart-by-akun-belanja__total-onstanding"></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-warning"></i> Sisa Pagu
                                        <span class="float-right" id="chart-by-akun-belanja__sisa-budget"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    </x-slot>
</x-layouts.auth>
