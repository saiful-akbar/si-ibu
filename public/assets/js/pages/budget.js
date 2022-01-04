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
