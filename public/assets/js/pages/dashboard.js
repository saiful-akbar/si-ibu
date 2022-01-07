class Dashboard {
    /**
     * Fungsi set chart global divisi
     *
     * @param {int} year
     */
    setChartPieGlobalDivisi(year) {
        $.ajax({
            type: "get",
            url: `${main.baseUrl}/dashboard/${year}`,
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
                        height: 350,
                        width: 350,
                        type: "pie",
                    },
                    legend: {
                        show: false,
                    },
                    fill: {
                        type: "gradient",
                    },
                    series: [1000, 500],
                    labels: ["Total Belanja", "Sisa Budget"],
                    colors: ["#0acf97", "#727cf5"],
                    responsive: [
                        {
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: "100%",
                                    width: "100%",
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
    setChartPiePerDivisi(id, year) {
        $.ajax({
            type: "get",
            url: `${main.baseUrl}/dashboard/admin/${id}/${year}/divisi`,
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
                        width: 230,
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
                                    width: "100%",
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
    setChartLinePerJenisBelanja(idDivisi, year) {
        $.ajax({
            type: "get",
            url: `${main.baseUrl}/dashboard/divisi/${idDivisi}/${year}/jenis-belanja`,
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
                        labels: {
                            formatter: (yLabel) => main.formatRupiah(yLabel),
                            offsetX: -15,
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

    /**
     * Fungsi set chart bar per akun belanja (jenis_belanja)
     *
     * @param {int} year Tahun periode
     * @param {int} jenisBelanjaId Jenis belanja id
     */
    setChartLinePerJenisBelanja(year, jenisBelanjaId) {
        const options = {
            series: [
                {
                    name: "Total Budget",
                    data: [44, 55, 41, 56, 38, 72],
                },
                {
                    name: "Total Belanja",
                    data: [53, 32, 33, 67, 36, 58],
                },
            ],
            xaxis: {
                categories: [
                    "IT",
                    "Accounting",
                    "Warehouse",
                    "Marketing",
                    "Finance",
                    "Autdit",
                ],
            },
            chart: {
                type: "bar",
                height: "auto",
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        position: "top",
                    },
                },
            },
            dataLabels: {
                enabled: true,
                offsetX: -6,
            },
            stroke: {
                show: true,
                width: 1,
                colors: ["#fff"],
            },
            tooltip: {
                shared: true,
                intersect: false,
            },
        };

        const chart = new ApexCharts(
            document.querySelector("#chart-admin-jenis-belanja"),
            options
        );

        chart.render();
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
     * Jalankan fungsi setChartLinePerJenisBelanja ketika user admin
     */
    if (ElChartAdminJenisBelanja.length > 0) {
        dashboard.setChartLinePerJenisBelanja(new Date().getFullYear(), "all");
    }

    /**
     * jalankan fungsi setChartLinePerJenisBelanja ketika user bukan admin
     */
    if (ElChartPerJenisBelanja.length > 0) {
        dashboard.setChartLinePerJenisBelanja(
            ElChartPerJenisBelanja.data("divisi-id"),
            new Date().getFullYear()
        );

        /**
         * handle jika periode divisi per jenis belanja dirubah
         */
        $("#periode-divisi-jenis-belanja").change(function (e) {
            e.preventDefault();
            dashboard.setChartLinePerJenisBelanja(
                ElChartPerJenisBelanja.data("divisi-id"),
                $(this).val()
            );
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
