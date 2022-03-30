/**
 * Akun Belanja class
 */
class AkunBelanja {

    /**
     * method delete data akun_belanja
     *
     * @param {int} id
     */
    deleteAkunBelanja(id) {
        bootbox.confirm({
            title: `Anda ingin menghapus akun belanja ?`,
            message: String.raw `
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">
                        <i class="dripicons-warning mr-1"></i>
                        Peringatan!
                    </h4>
                    <ul>
                        <li>Tindakan ini tidak dapat dibatalkan.</li>
                        <li>
                            Akun belanja yang dihapus tidak dapat dikembalikan.
                        </li>
                        <li>Pastikan anda berhati-hati dalam menghapus.</li>
                    </ul>
                    <p>
                        <b>NB:</b> Akun belanja tidak dapat dihapus jika
                        memilikin data pada relasi <b>Jenis Belanja</b>!
                    </p>
                </div>
            `,
            buttons: {
                confirm: {
                    label: String.raw `<i class="mdi mdi-delete mr-1"></i> Hapus`,
                    className: "btn btn-danger btn-sm btn-rounded",
                },
                cancel: {
                    label: String.raw `<i class="mdi mdi-close-circle mr-1"></i>
                        Batal`,
                    className: "btn btn-sm btn-dark btn-rounded mr-2",
                },
            },
            callback: (result) => {
                if (result) {
                    const form = $("#form-delete-akun-belanja");

                    form.attr("action", `${main.baseUrl}/akun-belanja/${id}`);
                    form.submit();
                }
            },
        });
    }

    /**
     * method delete data jenis_belanja
     * 
     * @param {int} id
     */
    deleteJenisBelanja(id) {
        bootbox.confirm({
            title: `Anda ingin menghapus akun belanja ?`,
            message: String.raw `
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">
                        <i class="dripicons-warning mr-1"></i>
                        Peringatan!
                    </h4>
                    <ul>
                        <li>Tindakan ini tidak dapat dibatalkan.</li>
                        <li>
                            Akun belanja yang dihapus tidak dapat dikembalikan.
                        </li>
                        <li>Pastikan anda berhati-hati dalam menghapus.</li>
                    </ul>
                    <p>
                        <b>NB:</b> Akun belanja tidak dapat dihapus jika
                        memilikin data pada relasi <b>budget</b>!
                    </p>
                </div>
            `,
            buttons: {
                confirm: {
                    className: `btn btn-danger btn-sm btn-rounded`,
                    label: String.raw `<i class="mdi mdi-delete mr-1"></i> Hapus`,
                },
                cancel: {
                    className: `btn btn-sm btn-dark btn-rounded mr-2`,
                    label: String.raw `<i class="mdi mdi-close-circle mr-1"></i>
                        Batal`,
                },
            },
            callback: (result) => {
                if (result) {
                    const form = $("#form-delete-jenis-belanja");

                    form.attr("action", `${main.baseUrl}/akun-belanja/jenis-belanja/${id}`);
                    form.submit();
                }
            },
        });
    }
}

const akunBelanja = new AkunBelanja();
