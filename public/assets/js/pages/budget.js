class Budget {
    constructor() {
        this.dataTableAkunBelanja = null;
    }

    /**
     * Fungsi handle hapus data budget
     *
     * @param {int} id
     */
    handleDelete = (id) => {
        main.handleDelete("Hapus pagu ?", (response) => {
            if (response) {
                const form = $("#form-delete");

                form.attr("action", `${main.baseUrl}/budget/${id}`);
                form.submit();
            }
        });
    };

    /**
     * fungsi show hide loading modal
     *
     * @param {boolean} show
     */
    showLoading = (show) => {
        const loading = $("#detail-loading");
        const content = $("#detail-content");

        if (show) {
            loading.show();
            content.hide();
        } else {
            loading.hide();
            content.show();
        }
    };

    /**
     * Fungsi handle show modal detail
     *
     * @param {int} id
     */
    detail = (show, budgetId = null) => {
        $("#detail-budget").modal(show ? "show" : "hide");

        if (show) {
            this.showLoading(true);

            $("#detail-transaksi").html("");

            $.ajax({
                type: "get",
                url: `${main.baseUrl}/budget/${budgetId}/show`,
                dataType: "json",
                success: (res) => {
                    this.showLoading(false);

                    $("#detail-keterangan").html(res.budget.keterangan);
                    $("#detail-tahun-anggaran").text(res.budget.tahun_anggaran);
                    $("#detail-tahun-anggaran").text(res.budget.tahun_anggaran);
                    $("#detail-divisi").text(res.budget.divisi.nama_divisi);

                    $("#detail-akun-belanja").text(
                        res.budget.jenis_belanja.akun_belanja.nama_akun_belanja
                    );

                    $("#detail-jenis-belanja").text(
                        res.budget.jenis_belanja.kategori_belanja
                    );

                    $("#detail-nominal").text(
                        "Rp. " + main.formatRupiah(res.budget.nominal)
                    );

                    $("#detail-nominal-transaksi").text(
                        "Rp. " + main.formatRupiah(res.totalNominalTransaksi)
                    );

                    $("#detail-sisa-nominal").text(
                        "Rp. " + main.formatRupiah(res.budget.sisa_nominal)
                    );

                    /**
                     * append table detail transkasi per budget
                     */
                    res.transaksi.map((transaksi) =>
                        $("#detail-transaksi").append(String.raw`
                            <tr>
                                <td>${transaksi.tanggal}</td>
                                <td>${transaksi.user.profil.nama_lengkap}</td>
                                <td>${transaksi.kegiatan}</td>
                                <td>${transaksi.approval}</td>
                                <td>${transaksi.no_dokumen}</td>
                                <td class="text-center">
                                    ${
                                        transaksi.file_dokumen !== null
                                            ? String.raw`
                                            <a href="${main.baseUrl}/belanja/${transaksi.id}/download" class="btn btn-light btn-sm btn-rounded">
                                                <i class="mdi mdi-download"></i>
                                                <span>Unduh</span>
                                            </a>
                                        `
                                            : "File tidak tersedia"
                                    }
                                </td>
                                <td class="text-right">
                                    Rp. ${main.formatRupiah(
                                        transaksi.jumlah_nominal
                                    )}
                                </td>
                            </tr>
                         `)
                    );
                },
            });
        }
    };

    /**
     * Fungsi handle close modal detail
     *
     * @param {int} id
     */
    handleCloseModalDetail = () => {
        $("#modal-detail").modal("hide");
    };

    /**
     * Fungsi show hide modal table akun belanja
     *
     * @param {boolean} show
     */
    modalTableAkunBelanja(show) {
        $("#modal-table-akun-belanja").modal(show ? "show" : "hide");

        if (this.dataTableAkunBelanja == null) {
            this.dataTableAkunBelanja = $(
                "#datatable_modal-akun-belanja"
            ).DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                lengthChange: false,
                scrollX: true,
                info: false,
                ajax: `${main.baseUrl}/akun-belanja/jenis-belanja/datatable`,
                pagingType: "simple",
                language: {
                    paginate: {
                        previous: "Prev",
                        next: "Next",
                    },
                },
                columns: [
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                    },
                    {
                        data: "akun_belanja.nama_akun_belanja",
                        name: "akun_belanja.nama_akun_belanja",
                    },
                    {
                        data: "kategori_belanja",
                        name: "kategori_belanja",
                    },
                ],
            });
        }
    }

    /**
     * Fungsi set value form input akun belanja
     *
     * @param {int} id
     * @param {string} namaAkunBelanja
     * @param {string} kategoriBelanja
     */
    setValueAkunBelanja(id, namaAkunBelanja, kategoriBelanja) {
        $("#jenis_belanja_id").val(id);
        $("#nama_akun_belanja").val(namaAkunBelanja);
        $("#kategori_belanja").val(kategoriBelanja);

        this.modalTableAkunBelanja(false);
    }
}

/**
 * instalsiasi class budget
 */
const budget = new Budget();

/**
 * Jalankan fungsi seletal document dimuat
 */
$(document).ready(function () {
    /**
     * summernote keterangan
     */
    $("#keterangan").summernote({
        required: true,
        height: 230,
        lang: "id-ID",
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["view", ["fullscreen", "help"]],
        ],
    });
});
