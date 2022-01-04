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
            Yakin ingin menghapus bagian <strong>${namaBagian}</strong> ?

            <div class="alert alert-info mt-3" role="alert">
                <h5 class="alert-heading">
                    <i class="dripicons-information mr-1"></i>
                    Info
                </h5>
                <p>Bagian tidak dapat dihapus jika memlikin data pada relasi <b>User</b> dan <b>Budget</b>!</p>
            </div>
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
