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
                        height: 350,
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
        let url = `${main.baseUrl}/dashboard/chart/akun-belanja`;
        url += `?tahun_anggaran=${this.chartByAkunBelanja.tahunAnggaran}`;
        url += `&divisi=${this.chartByAkunBelanja.divisiId}`;
        url += `&akun_belanja=${this.chartByAkunBelanja.akunBelanjaId}`;
        url += `&jenis_belanja=${this.chartByAkunBelanja.jenisBelanjaId}`;

        $.ajax({
            type: "get",
            url,
            dataType: "json",
            success: function (res) {
                $("#chart-by-akun-belanja__total-budget").text(
                    "Rp. " + main.formatRupiah(res.totalBudget)
                );

                $("#chart-by-akun-belanja__total-outstanding").text(
                    "Rp. " + main.formatRupiah(res.totalOutstanding)
                );

                $("#chart-by-akun-belanja__total-onstanding").text(
                    "Rp. " + main.formatRupiah(res.totalOnstanding)
                );

                $("#chart-by-akun-belanja__sisa-budget").text(
                    "Rp. " + main.formatRupiah(res.sisaBudget)
                );

                const options = {
                    chart: { height: 350, type: "pie" },
                    legend: { show: false },
                    fill: { type: "gradient" },
                    series: [
                        res.totalOutstanding,
                        res.totalOnstanding,
                        res.sisaBudget,
                    ],
                    labels: [
                        "Realisasi Outstanding",
                        "Realisasi Onstanding",
                        "Sisa Budget",
                    ],
                    colors: ["#FA5C7C", "#0ACF97", "#ffbc00"],
                    responsive: [
                        {
                            breakpoint: 480,
                            options: { chart: { height: 220 } },
                        },
                    ],
                };

                const chart = new ApexCharts(
                    document.querySelector("#chart-by-akun-belanja"),
                    options
                );

                chart.render();
                chart.updateSeries([
                    res.totalOutstanding,
                    res.totalOnstanding,
                    res.sisaBudget,
                ]);
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
    dashboard.setBudgetChartByAkunBelanja();

    /**
     * handle change select tahun anggaran...
     * ...pada chart per akun belanja
     */
    $("#chart-by-akun-belanja__select-tahun-anggaran").change(function (e) {
        e.preventDefault();
        dashboard.chartByAkunBelanja["tahunAnggaran"] = $(this).val();
        dashboard.setBudgetChartByAkunBelanja();
    });

    /**
     * handle change select divisi...
     * ...pada chart per akun belanja
     */
    $("#chart-by-akun-belanja__select-divisi").change(function (e) {
        e.preventDefault();
        dashboard.chartByAkunBelanja["divisiId"] = $(this).val();
        dashboard.setBudgetChartByAkunBelanja();
    });

    /**
     * handle change select akun belanja...
     * ...pada chart per akun belanja
     */
    $("#chart-by-akun-belanja__select-akun-belanja").change(function (e) {
        e.preventDefault();

        dashboard.chartByAkunBelanja["akunBelanjaId"] = $(this).val();
        dashboard.setBudgetChartByAkunBelanja();

        const akunBelanjaId = $(this).val() === "" ? "all" : $(this).val();

        const url = `${main.baseUrl}/dashboard/chart/akun-belanja/options/${akunBelanjaId}`;
        const selectJenisBelanja = $(
            "#chart-by-akun-belanja__select-jenis-belanja"
        );

        selectJenisBelanja.load(url);
    });

    /**
     * handle change select jenis belanja...
     * ...pada chart per akun belanja
     */
    $("#chart-by-akun-belanja__select-jenis-belanja").change(function (e) {
        e.preventDefault();
        dashboard.chartByAkunBelanja["jenisBelanjaId"] = $(this).val();
        dashboard.setBudgetChartByAkunBelanja();
    });

    /**
     * handle change form select periode pada chart global
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
     * handle change select periode pada chart per divisi dirubah
     */
    $(".periode-divisi").change(function (e) {
        e.preventDefault();
        dashboard.setBudgetChartByDivisi(
            $(this).data("divisi-id"),
            $(this).val()
        );
    });
});
