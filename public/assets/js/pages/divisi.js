/**
 * Fungsi handle hapus data divisi (bagian)
 *
 * @param {int} id id divisi
 */
const handleDelete = (id) => {
    main.handleDelete("Hapus bagian ?", (response) => {
        if (response) {
            const form = $("#form-delete");
            form.attr("action", `${main.baseUrl}/divisi/${id}`);
            form.submit();
        }
    });
};
