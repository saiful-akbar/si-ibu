$(document).ready(function () {
    const main = new Main();

    /**
     * View avatar
     */
    $('#avatar').change(function (e) {
        e.preventDefault();

        const { files } = $(this)[0];

        if (files) {
            $('#avatar-view').attr('src', URL.createObjectURL(files[0]));
        }
    });

    /**
     * Kembalikan avatar ketika form direset
     */
    $('button[type=reset]').click(function () {
        const avatarView = $('#avatar-view');

        avatarView.attr('src', avatarView.data('src'));
    });
});