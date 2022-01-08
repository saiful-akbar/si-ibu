class Dashboard {
    /**
     * Fungsi set chart global divisi
     *
     * @param {int} year
     */
    setChartPieGlobalDivisi(year) {
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
     * Fungsi set chart bar per akun belanja (jenis_belanja)
     *
     * @param {int} year Tahun periode
     * @param {int} jenisBelanjaId Jenis belanja id
     */
    chartPiePerJenisBelanja(jenisBelanjaId, periode) {
        $.ajax({
            type: "get",
            url: `${main.baseUrl}/dashboard/chart/admin/${jenisBelanjaId}/${periode}/jenis-belanja`,
            dataType: "json",
            success: function (res) {
                $("#admin-jbelanja-total-belanja").text(
                    "Rp. " + main.formatRupiah(res.data.totalBelanja)
                );

                const options = {
                    chart: {
                        height: 350,
                        type: "pie",
                    },
                    fill: {
                        type: "gradient",
                    },
                    legend: {
                        show: true,
                        position: "bottom",
                        itemMargin: {
                            horizontal: 5,
                            vertical: 5,
                        },
                    },
                    series: [...res.data.series],
                    labels: [...res.data.labels],
                    responsive: [
                        {
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: 290,
                                },
                                legend: {
                                    position: "bottom",
                                },
                            },
                        },
                    ],
                };

                const chart = new ApexCharts(
                    document.querySelector("#chart-admin-jenis-belanja"),
                    options
                );

                chart.render();
                chart.updateSeries(res.data.series);
            },
        });
    }

    /**
     * Fungsi set chart per divisi
     *
     * @param {int} id
     * @param {int} year
     */
    setChartPiePerDivisi(id, year) {
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
     * Fungsi set chart per jenis kategori
     *
     * @param mixed idDivisi
     * @param mixed year
     *
     * @return void
     */
    setChartLinePerJenisBelanja(periode) {
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
                            text: "Nominal Belanja",
                        },
                        labels: {
                            formatter: (yLabel) => main.formatRupiah(yLabel),
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
                    document.querySelector("#chart-jenis-belanja"),
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
    dashboard.setChartPieGlobalDivisi(new Date().getFullYear());

    const ElChartPerJenisBelanja = $("#chart-jenis-belanja");
    const ElChartAdminJenisBelanja = $("#chart-admin-jenis-belanja");

    /**
     * Jalankan fungsi chartPiePerJenisBelanja ketika user admin
     */
    if (ElChartAdminJenisBelanja.length > 0) {
        dashboard.chartPiePerJenisBelanja("all", new Date().getFullYear());

        /**
         * handle change select #chart-admin-jbelanja-periode
         */
        $("#chart-admin-jbelanja-periode").change(function (e) {
            e.preventDefault();

            const periode = $(this).val();
            const jenisBelanjaId = $("#chart-admin-jbelanja").val();

            dashboard.chartPiePerJenisBelanja(jenisBelanjaId, periode);
        });

        /**
         * handle change select #chart-admin-jbelanja
         */
        $("#chart-admin-jbelanja").change(function (e) {
            e.preventDefault();

            const periode = $("#chart-admin-jbelanja-periode").val();
            const jenisBelanjaId = $(this).val();

            dashboard.chartPiePerJenisBelanja(jenisBelanjaId, periode);
        });
    }

    /**
     * jalankan fungsi setChartLinePerJenisBelanja ketika user bukan admin
     */
    if (ElChartPerJenisBelanja.length > 0) {
        dashboard.setChartLinePerJenisBelanja(new Date().getFullYear());

        /**
         * handle jika periode divisi per jenis belanja dirubah
         */
        $("#periode-divisi-jenis-belanja").change(function (e) {
            e.preventDefault();
            dashboard.setChartLinePerJenisBelanja($(this).val());
        });
    }

    /**
     * handle change form select global period
     */
    $("#periode-global").change(function (e) {
        e.preventDefault();
        dashboard.setChartPieGlobalDivisi($(this).val());
    });

    /**
     * set chart divisi
     */
    $.each($(".divisi-chart"), function (index, el) {
        const chartEl = $(el);
        const id = chartEl.data("divisi-id");

        dashboard.setChartPiePerDivisi(id, new Date().getFullYear());
    });

    /**
     * handle jika periode per divisi dirubah
     */
    $(".periode-divisi").change(function (e) {
        e.preventDefault();
        dashboard.setChartPiePerDivisi(
            $(this).data("divisi-id"),
            $(this).val()
        );
    });
});
