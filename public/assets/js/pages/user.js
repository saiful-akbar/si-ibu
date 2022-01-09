/**
 * Fungsi handle hapus data user
 *
 * @param {int} id
 * @param {string} username
 */
function handleDelete(id) {
    bootbox.confirm({
        title: "Anda ingin menghapus user ?",
        message: `
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">
                    <i class="dripicons-warning mr-1"></i>
                    Peringatan!
                </h4>

                <ul>
                    <li>Tindakan ini tidak dapat dibatalkan.</li>
                    <li>User yang dihapus tidak dapat dikembalikan.</li>
                    <li>Pastikan anda berhati-hati dalam menghapus data.</li>
                </ul>

                <p><b>NB:</b> User tidak dapat dihapus jika memiliki data relasi pada <b>Transaksi Belanja</b>!</p>
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
     * Disable atau aktifkan form edit user menu akses
     */
    $(".menu-headers").change(function (e) {
        const isChecked = $(this).is(":checked");
        const headerName = $(this).data("header");

        $(`.${headerName}`).attr("disabled", !isChecked);
    });

    /**
     * Dissable atau aktifkan password di halaman edit user
     */
    $("#is-disable-password").change(function (e) {
        const isChecked = $(this).is(":checked");

        $("#password").attr("disabled", !isChecked);
    });
});
