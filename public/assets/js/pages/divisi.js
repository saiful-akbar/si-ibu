/**
 * Inisialisasi class Main
 */
const main = new Main();

/**
 * Fungsi handle hapus data divisi
 *
 * @param {int} id id divisi
 * @param {string} namaDivisi nama divisi
 */
const handleDelete = (id, namaDivisi) => {
    bootbox.confirm({
        title: "Peringatan!",
        message: `
            <ul>
                <li>Yakin ingin menghapus divisi <strong>${namaDivisi}</strong> ?</li>
                <li>Semua data terkait atau data yang berelasi dengan data ini juga akan terhapus.</li>
            </ul>
        `,
        buttons: {
            confirm: {
                label: "Hapus",
                className: "btn-danger btn-sm btn-rounded",
            },
            cancel: {
                label: "Batal",
                className: "btn-secondary btn-sm btn-rounded",
            },
        },
        callback: (result) => {
            if (result) {
                const form = $("#form-delete");

                form.attr("action", `${main.baseUrl}/divisi/${id}`);
                form.submit();
            }
        },
    });
};
