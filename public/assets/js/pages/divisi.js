/**
 * Fungsi handle hapus data divisi
 *
 * @param {int} id id divisi
 * @param {string} namaBagian nama divisi
 */
const handleDelete = (id, namaBagian) => {
    bootbox.confirm({
        title: "Peringatan!",
        message: `
            <ul>
                <li>Yakin ingin menghapus bagian <strong>${namaBagian}</strong> ?</li>
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

                form.attr("action", `${main.baseUrl}/bagian/${id}`);
                form.submit();
            }
        },
    });
};
