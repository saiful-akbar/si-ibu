/**
 * Fungsi handle hapus data divisi
 *
 * @param {int} id id divisi
 * @param {string} namaBagian nama divisi
 */
const handleDelete = (id, namaBagian) => {
    bootbox.confirm({
        title: `Anda ingin menghapus data bagian ?`,
        message: `
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">
                    <i class="dripicons-warning mr-1"></i>
                    Peringatan!
                </h4>

                <ul>
                    <li>Tindakan ini tidak dapat dibatalkan.</li>
                    <li>Bagian yang dihapus tidak dapat dikembalikan.</li>
                    <li>Pastikan anda berhati-hati dalam menghapus data.</li>
                </ul>

                <p>
                    <b>NB:</b> Data bagian tidak dapat dihapus jika memiliki data relasi pada <b>User</b> dan <b>Budget</b>!
                </p>
            </div>
        `,
        buttons: {
            confirm: {
                label: "<i class='mdi mdi-delete mr-1'></i> Hapus",
                className: "btn btn-danger btn-sm btn-rounded",
            },
            cancel: {
                label: "<i class='mdi mdi-close-circle mr-1'></i> Batal",
                className: "btn btn-sm btn-dark btn-rounded mr-2",
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
