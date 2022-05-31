/**
 * Fungsi handle hapus data user
 *
 * @param {int} id
 */
function handleDelete(id) {
    main.handleDelete('Hapus user ?', (response) => {
        if (response) {
            const form = $("#form-delete");

            form.attr("action", `${main.baseUrl}/user/${id}`);
            form.submit();
        }
    });
}

$(document).ready(function() {

    /**
     * View avatar
     */
    $("#avatar").change(function(e) {
        e.preventDefault();

        const { files } = $(this)[0];

        if (files) {
            $("#avatar-view").attr("src", URL.createObjectURL(files[0]));
        }
    });

    /**
     * Kembalikan avatar ketika form direset
     */
    $("button[type=reset]").click(function() {
        const avatarView = $("#avatar-view");

        avatarView.attr("src", avatarView.data("src"));
    });

    /**
     * Disable atau aktifkan form edit user menu akses
     */
    $(".menu-headers").change(function(e) {
        const isChecked = $(this).is(":checked");
        const headerName = $(this).data("header");

        $(`.${headerName}`).attr("disabled", !isChecked);
    });

    /**
     * Dissable atau aktifkan password di halaman edit user
     */
    $("#is-disable-password").change(function(e) {
        const isChecked = $(this).is(":checked");

        $("#password").attr("disabled", !isChecked);
    });
});
