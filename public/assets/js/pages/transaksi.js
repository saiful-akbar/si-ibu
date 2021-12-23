$(document).ready(function () {
    /**
     * summernote uraian
     */
    $("#uraian").summernote({
        placeholder: "Masukan uraian...",
        height: 230,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["view", ["fullscreen", "help"]],
        ],
    });

    /**
     * menampilkan nama file dokumen
     */
    $("#file_dokumen").change(function (e) {
        const elFileName = $("#file-name");
        const { files } = $(this)[0];

        if (files) {
            elFileName.removeClass("d-none");
            elFileName.text(files[0].name);
        }
    });

    /**
     * menghilangkan nama file dokumen ketika button reset ditekan
     */
    $("button[type=reset]").click(function (e) {
        $("#file-name").addClass("d-none");
    });
});
