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
        success: function (res) {
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
                    type: "pie",
                },
                legend: {
                    show: false,
                },
                fill: {
                    type: "gradient",
                },
                series: [res.totalTransaksi, res.sisaBudget],
                labels: ["Total Transaksi", "Sisa Budget"],
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
 * Jalankan fungsi ketika document selsai dimuat
 */
$(document).ready(function () {
    setGlobalChart(new Date().getFullYear());

    const chartPerJenisBelanja = $("#chart-jenis-belanja");

    /**
     * jalankan fungsi setChartPerJenisBelanja ketika user bukan admin
     */
    if (chartPerJenisBelanja.length > 0) {
        setChartPerJenisBelanja(
            chartPerJenisBelanja.data("divisi-id"),
            new Date().getFullYear()
        );

        /**
         * handle jika periode divisi per jenis belanja dirubah
         */
        $("#periode-divisi-jenis-belanja").change(function (e) {
            e.preventDefault();
            setChartPerJenisBelanja(
                chartPerJenisBelanja.data("divisi-id"),
                $(this).val()
            );
        });
    }

    /**
     * handle change form select global period
     */
    $("#periode-global").change(function (e) {
        e.preventDefault();
        setGlobalChart($(this).val());
    });

    /**
     * set chart divisi
     */
    $.each($(".divisi-chart"), function (index, el) {
        const chartEl = $(el);
        const id = chartEl.data("divisi-id");

        setDivisiChart(id, new Date().getFullYear());
    });

    /**
     * handle jika periode per divisi dirubah
     */
    $(".periode-divisi").change(function (e) {
        e.preventDefault();
        setDivisiChart($(this).data("divisi-id"), $(this).val());
    });
});
