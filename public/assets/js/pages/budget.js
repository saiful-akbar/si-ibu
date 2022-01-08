class Budget {
    constructor() {
        this.dataTable = null;
    }

    /**
     * Fungsi handle hapus data budget
     *
     * @param {int} id
     */
    handleDelete = (id) => {
        bootbox.confirm({
            title: "<h5 class='mt-2'>Anda ingin menghapus budget ?</h5>",
            message: `
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">
                        <i class="dripicons-warning"></i>
                        Peringatan!
                    </h4>

                    <ul>
                        <li>Tindakan ini tidak dapat dibatalkan.</li>
                        <li>Budget yang dihapus tidak dapat dikembalikan.</li>
                        <li>Pastikan anda berhati-hati dalam menghapus.</li>
                    </ul>

                    <p><b>NB:</b> Budget tidak dapat dihapus jika memiliki data relasi pada <b>Transaksi Belanja</b>!</p>
                </div>
            `,
            buttons: {
                confirm: {
                    label: "Hapus",
                    className: "btn btn-danger btn-sm btn-rounded",
                },
                cancel: {
                    label: "Batal",
                    className: "btn btn-sm btn-outline-dark btn-rounded",
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
            this.showLoading(false);
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
