const handleDelete = (a) => {
    bootbox.confirm({
        title: "Anda ingin menghapus data bagian ?",
        message: String.raw`
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
                label: String.raw`<i class='mdi mdi-delete mr-1'></i> Hapus`,
                className: "btn btn-danger btn-sm btn-rounded",
            },
            cancel: {
                label: String.raw`<i class='mdi mdi-close-circle mr-1'></i> Batal`,
                className: "btn btn-sm btn-dark btn-rounded mr-2",
            },
        },
        callback: (i) => {
            if (i) {
                const i = $("#form-delete");
                i.attr("action", `${main.baseUrl}/divisi/${a}`), i.submit();
            }
        },
    });
};
