class AkunBelanja {
    /**
     * Handle delete data akun belanja
     *
     * @param {int} id
     */
    deleteAkunBelanja(id) {
        main.handleDelete("Hapus akun belanja ?", (result) => {
            if (result) {
                const form = $("#form-delete");
                const url = `${main.baseUrl}/akun-belanja/${id}`;

                form.attr("action", url);
                form.submit();
            }
        });
    }

    /**
     * method delete jenis belanja
     *
     * @param {int} id
     */
    deleteJenisBelanja(id) {
        main.handleDelete("Hapus jenis belanja ?", (result) => {
            if (result) {
                const form = $("#form-delete");
                const url = `${main.baseUrl}/akun-belanja/jenis-belanja/${id}`;

                form.attr("action", url);
                form.submit();
            }
        });
    }
}

const akunBelanja = new AkunBelanja();
