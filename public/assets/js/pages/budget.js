class Budget {
    constructor() {
        this.dataTable = null;
    }

    /**
     * Fungsi handle hapus data budget
     *
     * @param {int} id
     * @param {string} divisi
     */
    handleDelete = (id, divisi) => {
        bootbox.confirm({
            title: "Peringatan!",
            message: `
            <ul>
                <li>Yakin ingin menghapus budget pada divisi <strong>${divisi}</strong> ?</li>
                <li>Semua data terkait atau data yang berelasi dengan budget divisi ini juga akan terhapus.</li>
            </ul>
        `,
            buttons: {
                confirm: {
                    label: "Hapus",
                    className: "btn-danger btn-rounded btn-sm",
                },
                cancel: {
                    label: "Batal",
                    className: "btn-secondary btn-rounded btn-sm",
                },
            },
            callback: (result) => {
                if (result) {
                    const form = $("#form-delete-budget");

                    form.attr("action", `${main.baseUrl}/budget/${id}`);
                    form.submit();
                }
            },
        });
    };

    /**
     * fungsi show hide loading modal
     *
     * @param {boolean} show
     */
    showHideLoadingModal = (show) => {
        const loading = $("#loading-modal");
        const content = $("#modal-detail-content");

        if (show) {
            content.hide();
            loading.show();
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
    handleShowModalDetail = (id) => {
        $("#modal-detail").modal("show");

        this.showHideLoadingModal(true);

        // request api
        $.ajax({
            type: "GET",
            url: `${main.baseUrl}/budget/${id}/show`,
            data: { _token: main.csrfToken },
            dataType: "json",
            success: (res) => {
                this.showHideLoadingModal(false);

                const {
                    jenis_belanja,
                    tahun_anggaran,
                    nominal,
                    created_at,
                    updated_at,
                    keterangan,
                } = res.budget;

                $("#detail-divisi").text(jenis_belanja.divisi.nama_divisi);
                $("#detail-akun-belanja").text(jenis_belanja.kategori_belanja);
                $("#detail-tahun-anggaran").text(tahun_anggaran);
                $("#detail-nominal").text(main.formatRupiah(nominal));
                $("#detail-created").text(created_at);
                $("#detail-updated").text(updated_at);
                $("#detail-keterangan").html(keterangan);
            },
        });
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
     * Set value form switch budget
     *
     * @param {object} budget
     */
    setValueSwitchBudget = (id) => {
        this.showModalTable(false);

        $.ajax({
            type: "GET",
            url: `${main.baseUrl}/budget/${id}/show`,
            data: { _token: main.csrfToken },
            dataType: "json",
            success: (res) => {
                const {
                    id,
                    tahun_anggaran,
                    keterangan,
                    jenis_belanja,
                    divisi,
                } = res.budget;

                $("#id").val(id);
                $("#jenis_belanja").val(jenis_belanja.kategori_belanja);
                $("#divisi").val(divisi.nama_divisi);
                $("#tahun_anggaran").val(tahun_anggaran);
                $("#keterangan").html(keterangan);
                $(".note-editable").html(keterangan);
            },
        });
    };

    /**
     * handle show modal table
     * @param {boolean} show
     */
    showModalTable = (show, id = null) => {
        if (show) {
            $("#modal-table-budget").modal("show");

            if (this.dataTable == null) {
                this.dataTable = $("#datatable-budget").DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 25,
                    lengthChange: false,
                    scrollX: true,
                    destroy: false,
                    info: false,
                    ajax: `${main.baseUrl}/budget/${id}/datatable`,
                    language: {
                        paginate: {
                            previous: "<i class='mdi mdi-chevron-left'>",
                            next: "<i class='mdi mdi-chevron-right'>",
                        },
                    },
                    columns: [
                        {
                            data: "action",
                            name: "action",
                            className: "text-center",
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: "divisi.nama_divisi",
                            name: "divisi.nama_divisi",
                        },
                        {
                            data: "jenis_belanja.kategori_belanja",
                            name: "jenis_belanja.kategori_belanja",
                        },
                        {
                            data: "tahun_anggaran",
                            name: "tahun_anggaran",
                        },
                        {
                            data: "nominal",
                            name: "nominal",
                            render: (data) => "Rp. " + main.formatRupiah(data),
                        },
                    ],
                });
            }
        } else {
            $("#modal-table-budget").modal("hide");
        }
    };
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
