/**
 * Fungsi handle hapus data user
 *
 * @param {int} id
 * @param {string} noDokumen
 */
function handleDelete(id, noDokumen) {
    bootbox.confirm({
        title: "Peringatan!",
        message: `
            <ul>
                <li>Yakin ingin menghapus transaksi dengan nomer dokumen "<strong>${noDokumen}</strong>" ?</li>
                <li>Semua data terkait atau data yang berelasi dengan data transaksi ini juga akan terhapus.</li>
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
                const form = $("#form-delete-transaksi");

                form.attr("action", `${main.baseUrl}/transaksi/${id}`);
                form.submit();
            }
        },
    });
}

$(document).ready(function () {
    /**
     * summernote uraian
     */
    $("#uraian").summernote({
        placeholder: "Masukan uraian...",
        height: 230,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["view", ["fullscreen", "help"]],
        ],
    });

    /**
     * menampilkan nama file dokumen
     */
    $("#file_dokumen").change(function (e) {
        const fileNameEl = $("#file-name");
        const { files } = $(this)[0];

        if (files.length > 0) {
            fileNameEl.removeClass("d-none");
            fileNameEl.text(files[0].name);
        } else {
            if (fileNameEl.data("action") === "create") {
                fileNameEl.addClass("d-none");
            } else {
                fileNameEl.text(fileNameEl.data("file"));
            }
        }
    });

    /**
     * menghilangkan nama file dokumen ketika button reset ditekan
     */
    $("button[type=reset]").click(function (e) {
        const fileNameEl = $("#file-name");

        if (fileNameEl.data("action") === "create") {
            fileNameEl.addClass("d-none");
        } else {
            fileNameEl.text(fileNameEl.data("file"));
        }
    });
});
