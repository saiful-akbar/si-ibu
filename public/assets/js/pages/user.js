const main = new Main();

/**
 * Fungsi handle hapus data user
 *
 * @param {int} id
 * @param {string} username
 */
function handleDelete(id, username) {
    bootbox.confirm({
        title: "Peringatan!",
        message: `
            <ul>
                <li>Yakin ingin menghapus user <strong>${username}</strong> ?</li>
                <li>Semua data terkait atau data yang berelasi dengan data ini juga akan terhapus.</li>
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
                const form = $("#form-delete-user");

                form.attr("action", `${main.baseUrl}/user/${id}`);
                form.submit();
            }
        },
    });
}

$(document).ready(function () {
    /**
     * View avatar
     */
    $("#avatar").change(function (e) {
        e.preventDefault();

        const { files } = $(this)[0];

        if (files) {
            $("#avatar-view").attr("src", URL.createObjectURL(files[0]));
        }
    });

    /**
     * Kembalikan avatar ketika form direset
     */
    $("button[type=reset]").click(function () {
        const avatarView = $("#avatar-view");

        avatarView.attr("src", avatarView.data("src"));
    });

    /**
     * Disable atau aktifkan form update user menu akses
     */
    $(".menu-headers").change(function (e) {
        const isChecked = $(this).is(":checked");
        const headerName = $(this).data("header-name");

        $(`.${headerName}`).attr("disabled", !isChecked);
    });

    /**
     * Dissable atau aktifkan password di halaman edit
     */
    $("#is-disable-password").change(function (e) {
        const isChecked = $(this).is(":checked");

        $("#password").attr("disabled", !isChecked);
    });
});
