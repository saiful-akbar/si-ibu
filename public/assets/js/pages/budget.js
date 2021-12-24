/**
 * Fungsi handle hapus data budget
 *
 * @param {int} id
 * @param {string} divisi
 */
const handleDelete = (id, divisi) => {
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
const showHideLoadingModal = (show) => {
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
const handleShowModalDetail = (id) => {
    $("#modal-detail").modal("show");

    showHideLoadingModal(true);

    // request api
    $.ajax({
        type: "GET",
        url: `${main.baseUrl}/budget/${id}`,
        data: { _token: main.csrfToken },
        dataType: "json",
        success: (res) => {
            showHideLoadingModal(false);

            $("#detail-divisi").text(res.budget.divisi.nama_divisi);
            $("#detail-tahun-anggaran").text(res.budget.tahun_anggaran);
            $("#detail-nominal").text(main.formatRupiah(res.budget.nominal));
            $("#detail-created").text(res.budget.created_at);
            $("#detail-updated").text(res.budget.updated_at);
            $("#detail-keterangan").html(res.budget.keterangan);
        },
    });
};

/**
 * Fungsi handle close modal detail
 *
 * @param {int} id
 */
const handleCloseModalDetail = () => {
    $("#modal-detail").modal("hide");
};

/**
 * summernote keterangan
 */
$("#keterangan").summernote({
    placeholder: "Masukan Keterangan...",
    height: 230,
    toolbar: [
        ["style", ["style"]],
        ["font", ["bold", "underline"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["view", ["fullscreen", "help"]],
    ],
});
