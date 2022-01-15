class Dashboard {
    constructor() {
        this.chartByAkunBelanja = {
            tahunAnggaran: new Date().getFullYear(),
            divisiId: "",
            akunBelanjaId: "",
            jenisBelanjaId: "",
        };
    }

    /**
     * Fungsi set chart global divisi
     *
     * @param {int} year
     */
    setGlobalBudgetChart(year) {
        $.ajax({
            type: "get",
            url: `${main.baseUrl}/dashboard/chart/${year}`,
            dataType: "json",
            success: function (res) {
                $("#global-divisi").text(res.namaDivisi);

                $("#global-total-budget").text(
                    "Rp. " + main.formatRupiah(res.totalBudget)
                );

                $("#global-sisa-budget").text(
                    "Rp. " + main.formatRupiah(res.sisaBudget)
                );

                $("#global-total-belanja").text(
                    "Rp. " + main.formatRupiah(res.totalTransaksi)
                );

                // chart options
                const options = {
                    chart: {
                        height: 300,
                        type: "pie",
                    },
                    legend: {
                        show: false,
                    },
                    fill: {
                        type: "gradient",
                    },
                    series: [res.totalTransaksi, res.sisaBudget],
                    labels: ["Total Belanja", "Sisa Budget"],
                    colors: ["#0acf97", "#727cf5"],
                    responsive: [
                        {
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: 220,
                                },
                            },
                        },
                    ],
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
    setBudgetChartByDivisi(id, year) {
        $.ajax({
            type: "get",
            url: `${main.baseUrl}/dashboard/chart/admin/${id}/${year}/divisi`,
            dataType: "json",
            success: (res) => {
                $(`#total-budget-divisi-${id}`).text(
                    "Rp. " + main.formatRupiah(res.totalBudget)
                );

                $(`#sisa-budget-divisi-${id}`).text(
                    "Rp. " + main.formatRupiah(res.sisaBudget)
                );

                $(`#total-belanja-divisi-${id}`).text(
                    "Rp. " + main.formatRupiah(res.totalTransaksi)
                );

                const options = {
                    chart: {
                        height: 230,
                        type: "donut",
                    },
                    legend: {
                        show: false,
                    },
                    series: [res.totalTransaksi, res.sisaBudget],
                    labels: ["Total Transaksi", "Sisa Budget"],
                    colors: ["#0acf97", "#fa5c7c"],
                    responsive: [
                        {
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: "100%",
                                },
                            },
                        },
                    ],
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
     * Fungsi set chart bar per akun belanja (jenis_belanja)
     *
     * @param {int} year Tahun periode
     * @param {int} jenisBelanjaId Jenis belanja id
     */
    setBudgetChartByAkunBelanja() {
        let url = `${main.baseUrl}/dashboard/chart/admin/akun-belanja`;
        url += `?tahun_anggaran=${this.chartByAkunBelanja.tahunAnggaran}`;
        url += `&divisi=${this.chartByAkunBelanja.divisiId}`;
        url += `&akun_belanja=${this.chartByAkunBelanja.akunBelanjaId}`;
        url += `&jenis_belanja=${this.chartByAkunBelanja.jenisBelanjaId}`;

        $.ajax({
            type: "get",
            url,
            dataType: "json",
            success: function (res) {
                $("#admin__chart-by-akun-belanja__total-budget").text(
                    "Rp. " + main.formatRupiah(res.totalBudget)
                );

                $("#admin__chart-by-akun-belanja__total-transaksi").text(
                    "Rp. " + main.formatRupiah(res.totalTransaksi)
                );

                $("#admin__chart-by-akun-belanja__sisa-budget").text(
                    "Rp. " + main.formatRupiah(res.sisaBudget)
                );

                const options = {
                    chart: {
                        height: 300,
                        type: "pie",
                    },
                    legend: {
                        show: false,
                    },
                    fill: {
                        type: "gradient",
                    },
                    series: [res.totalTransaksi, res.sisaBudget],
                    labels: ["Total Belanja", "Sisa Budget"],
                    colors: ["#39afd1", "#ffbc00"],
                    responsive: [
                        {
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: 220,
                                },
                            },
                        },
                    ],
                };

                const chart = new ApexCharts(
                    document.querySelector("#admin__chart-by-akun-belanja"),
                    options
                );

                chart.render();
                chart.updateSeries([res.totalTransaksi, res.sisaBudget]);
            },
        });
    }

    /**
     * Fungsi set chart per jenis kategori
     *
     * @param mixed idDivisi
     * @param mixed year
     *
     * @return void
     */
    setTransaksiChartLine(periode) {
        $.ajax({
            type: "get",
            url: `${main.baseUrl}/dashboard/chart/divisi/${periode}/jenis-belanja`,
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
                    title: {
                        text: "Grafik Transaksi Belanja per Akun Belanja",
                        align: "left",
                    },
                    stroke: { curve: "smooth", with: 4 },
                    series: res.data,
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
                            "Agus",
                            "Sep",
                            "Okt",
                            "Nov",
                            "Des",
                        ],
                        tooltip: { enabled: true },
                        axisBorder: { show: true },
                    },
                    yaxis: {
                        title: {
                            text: "Nominal Transaksi Belanja",
                        },
                        labels: {
                            formatter: function (yLabel) {
                                return "Rp. " + main.formatRupiah(yLabel);
                            },
                        },
                    },
                    legend: {
                        position: "bottom",
                        horizontalAlign: "center",
                        itemMargin: {
                            horizontal: 5,
                            vertical: 5,
                        },
                    },
                };

                const chart = new ApexCharts(
                    document.querySelector("#divisi__transaksi-chart-line"),
                    options
                );

                chart.render();
                chart.updateSeries(res.data);
            },
        });
    }
}

/**
 * Instansiasi class Dashboard
 */
const dashboard = new Dashboard();

/**
 * Jalankan fungsi ketika document selsai dimuat
 */
$(document).ready(function () {
    dashboard.setGlobalBudgetChart(new Date().getFullYear());

    const ElDivisiTransaksiChartLine = $("#divisi__transaksi-chart-line");
    const ElChartByAkunBelanja = $("#admin__chart-by-akun-belanja");

    /**
     * Jalankan fungsi setBudgetChartByAkunBelanja ketika user admin
     */
    if (ElChartByAkunBelanja.length > 0) {
        dashboard.setBudgetChartByAkunBelanja();

        /**
         * handle change select tahun anggaran
         */
        $("#admin__chart-by-akun-belanja__select-tahun-anggaran").change(
            function (e) {
                e.preventDefault();
                dashboard.chartByAkunBelanja["tahunAnggaran"] = $(this).val();
                dashboard.setBudgetChartByAkunBelanja();
            }
        );

        /**
         * handle change select divisi
         */
        $("#admin__chart-by-akun-belanja__select-divisi").change(function (e) {
            e.preventDefault();
            dashboard.chartByAkunBelanja["divisiId"] = $(this).val();
            dashboard.setBudgetChartByAkunBelanja();
        });

        /**
         * handle change select akun belanja
         */
        $("#admin__chart-by-akun-belanja__select-akun-belanja").change(
            function (e) {
                e.preventDefault();
                dashboard.chartByAkunBelanja["akunBelanjaId"] = $(this).val();
                dashboard.setBudgetChartByAkunBelanja();
            }
        );

        /**
         * handle change select jenis belanja
         */
        $("#admin__chart-by-akun-belanja__select-jenis-belanja").change(
            function (e) {
                e.preventDefault();
                dashboard.chartByAkunBelanja["jenisBelanjaId"] = $(this).val();
                dashboard.setBudgetChartByAkunBelanja();
            }
        );
    }

    /**
     * jalankan fungsi setTransaksiChartLine ketika user bukan admin
     */
    if (ElDivisiTransaksiChartLine.length > 0) {
        dashboard.setTransaksiChartLine(new Date().getFullYear());

        /**
         * handle jika periode divisi per jenis belanja dirubah
         */
        $("#divisi__transaksi-chart-line__select-tahun-anggaran").change(
            function (e) {
                e.preventDefault();
                dashboard.setTransaksiChartLine($(this).val());
            }
        );
    }

    /**
     * handle change form select global period
     */
    $("#periode-global").change(function (e) {
        e.preventDefault();
        dashboard.setGlobalBudgetChart($(this).val());
    });

    /**
     * set chart divisi
     */
    $.each($(".divisi-chart"), function (index, el) {
        const chartEl = $(el);
        const id = chartEl.data("divisi-id");

        dashboard.setBudgetChartByDivisi(id, new Date().getFullYear());
    });

    /**
     * handle jika periode per divisi dirubah
     */
    $(".periode-divisi").change(function (e) {
        e.preventDefault();
        dashboard.setBudgetChartByDivisi(
            $(this).data("divisi-id"),
            $(this).val()
        );
    });
});
