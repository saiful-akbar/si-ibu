@extends('templates.main')

@section('title', 'Dashboard')

@section('content')

    {{-- chart global dvisi --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Global Chart Budget</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        {{-- chart global --}}
                        <div class="col-lg-6 col-sm-12 mb-3">
                            <div
                                id="global-chart"
                                class="apex-charts"
                            ></div>
                        </div>
                        {{-- end chart global --}}

                        <div class="col-lg-6 col-sm-12 mb-3">

                            {{-- form select periode chart global --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="periode-global">Periode Tahun</label>
                                        <select
                                            id="periode-global"
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

                                    <hr class="mt-3 mb-3">
                                </div>
                            </div>
                            {{-- end form select periode chart global --}}

                            {{-- descripsi chart global --}}
                            <div class="row">
                                <div class="col-12 chart-widget-list">
                                    <p>
                                        Divisi
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
    {{-- chart global divisi --}}

    {{-- chart per divisi --}}
    @if ($isAdmin)
        <div class="row">
            @foreach ($divisi as $data)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-header pt-3">
                            <h4 class="header-title">{{ $data->nama_divisi }}</h4>
                        </div>

                        <div class="card-body">

                            {{-- chart per divisi --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div
                                        class="apex-charts divisi-chart"
                                        data-divisi-id="{{ $data->id }}"
                                        id="divisi-{{ $data->id }}"
                                    ></div>
                                </div>
                            </div>
                            {{-- end chart per divisi --}}

                            {{-- form select periode per divisi --}}
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
                            {{-- end form select periode per divisi --}}

                            {{-- deskripsi per divisi --}}
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
                            {{-- end descripsi perdivisi --}}

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Grafik Per Jenis Belanja</h4>
                    </div>

                    <div class="card-body">
                        <div class="chart-content-bg">
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <p class="text-muted mb-0 mt-3">Current Week</p>
                                    <h2 class="font-weight-normal mb-3">
                                        <small class="mdi mdi-checkbox-blank-circle text-primary align-middle mr-1"></small>
                                        <span>$58,254</span>
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-0 mt-3">Previous Week</p>
                                    <h2 class="font-weight-normal mb-3">
                                        <small class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1"></small>
                                        <span>$69,524</span>
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <div
                            id="chart-jenis-belanja"
                            data-divisi-id="{{ Auth::user()->divisi->id }}"
                            class="apex-charts mt-3"
                            data-colors="#727cf5,#0acf97"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- end chart per divisi --}}

@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script>
        /**
         * Fungsi set chart global divisi
         *
         * @param {int} year
         */
        function setGlobalChart(year) {
            $.ajax({
                type: "get",
                url: `${main.baseUrl}/dashboard/${year}`,
                dataType: "json",
                success: function(res) {
                    $("#global-divisi").text(res.divisi);
                    $("#global-total-budget").text(main.formatRupiah(res.totalBudget));
                    $("#global-sisa-budget").text(main.formatRupiah(res.sisaBudget));
                    $("#global-total-belanja").text(
                        main.formatRupiah(res.totalTransaksi)
                    );

                    // chart options
                    const options = {
                        chart: {
                            height: 350,
                            width: 350,
                            type: "pie"
                        },
                        legend: {
                            show: false
                        },
                        fill: {
                            type: "gradient"
                        },
                        series: [res.totalTransaksi, res.sisaBudget],
                        labels: ["Total Transaksi", "Sisa Budget"],
                        colors: ["#0acf97", "#727cf5"],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: "100%",
                                    width: "100%",
                                },
                            },
                        }, ],
                    };

                    const chart = new ApexCharts(
                        document.querySelector("#global-chart"),
                        options
                    );

                    chart.render();
                    chart.updateSeries([res.totalTransaksi, res.sisaBudget]);
                },
            });
        }

        /**
         * Fungsi set chart per divisi
         *
         * @param {int} id
         * @param {int} year
         */
        function setDivisiChart(id, year) {
            $.ajax({
                type: "get",
                url: `${main.baseUrl}/dashboard/divisi/${id}/${year}`,
                dataType: "json",
                success: (res) => {
                    $(`#total-budget-divisi-${id}`).text(
                        main.formatRupiah(res.totalBudget)
                    );

                    $(`#sisa-budget-divisi-${id}`).text(
                        main.formatRupiah(res.sisaBudget)
                    );

                    $(`#total-belanja-divisi-${id}`).text(
                        main.formatRupiah(res.totalTransaksi)
                    );

                    const options = {
                        chart: {
                            height: 230,
                            width: 230,
                            type: "donut"
                        },
                        legend: {
                            show: false
                        },
                        series: [res.totalTransaksi, res.sisaBudget],
                        labels: ["Total Transaksi", "Sisa Budget"],
                        colors: ["#0acf97", "#fa5c7c"],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: "100%",
                                    width: "100%",
                                },
                            },
                        }, ],
                    };

                    const chart = new ApexCharts(
                        document.querySelector(`#divisi-${id}`),
                        options
                    );

                    chart.render();
                    chart.updateSeries([res.totalTransaksi, res.sisaBudget]);
                },
            });
        }

        /**
         * Fungsi set chart per jenis kategori
         * @param mixed idDivisi
         * @param mixed year
         *
         * @return void
         */
        function setChartPerJenisBelanja(idDivisi, year) {
            $.ajax({
                type: "get",
                url: `${main.baseUrl}/dashboard/jenis-belanja/${idDivisi}/${year}`,
                dataType: "json",
                success: (res) => {
                    const options = {
                        chart: {
                            height: 364,
                            type: "line",
                            dropShadow: {
                                enabled: !0,
                                opacity: 0.2,
                                blur: 7,
                                left: -7,
                                top: 7,
                            },
                        },
                        dataLabels: {
                            enabled: !1
                        },
                        stroke: {
                            curve: "smooth",
                            width: 4
                        },
                        series: res.data,
                        zoom: {
                            enabled: !1
                        },
                        legend: {
                            show: !1
                        },
                        xaxis: {
                            type: "string",
                            categories: [
                                "Jan",
                                "Feb",
                                "Mar",
                                "Apr",
                                "Mei",
                                "Jun",
                                "Jul",
                                'Agus',
                                "Sep",
                                'Okt',
                                "Nov",
                                "Des"
                            ],
                            tooltip: {
                                enabled: !1
                            },
                            axisBorder: {
                                show: !1
                            },
                        },
                        yaxis: {
                            labels: {
                                formatter: function(e) {
                                    return main.formatRupiah(e);
                                },
                                offsetX: -15,
                            },
                        },
                    };

                    const chart = new ApexCharts(
                        document.querySelector("#chart-jenis-belanja"),
                        options
                    );

                    chart.render();
                }
            });
        }

        /**
         * Jalankan fungsi ketika document selsai dimuat
         */
        $(document).ready(function() {
            setGlobalChart(new Date().getFullYear());
            setChartPerJenisBelanja($('#chart-jenis-belanja').data('divisi-id'), new Date().getFullYear());

            /**
             * handle change form select global period
             */
            $("#periode-global").change(function(e) {
                e.preventDefault();
                setGlobalChart($(this).val());
            });

            /**
             * set chart divisi
             */
            $.each($(".divisi-chart"), function(index, el) {
                const chartEl = $(el);
                const id = chartEl.data("divisi-id");

                setDivisiChart(id, new Date().getFullYear());
            });



            /**
             * handle jika periode per divisi dirubah
             */
            $(".periode-divisi").change(function(e) {
                e.preventDefault();
                setDivisiChart($(this).data("divisi-id"), $(this).val());
            });
        });
    </script>
@endsection
