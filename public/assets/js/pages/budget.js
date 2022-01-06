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
$(document).ready(function() {
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
