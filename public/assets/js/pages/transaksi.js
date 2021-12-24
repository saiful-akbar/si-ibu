class Transaksi {

    /**
     * Fungsi handle hapus data user
     *
     * @param {int} id
     * @param {string} noDokumen
     */
    delete(id, noDokumen) {
        bootbox.confirm({
            title: "Peringatan!",
            message: `
                <ul>
                    <li>
                        Yakin ingin menghapus transaksi dengan nomer dokumen "<strong>${noDokumen}</strong>" ?
                    </li>
                    <li>
                        Semua data terkait atau data yang berelasi dengan data transaksi ini juga akan terhapus.
                    </li>
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
                    const form = $("#form-delete-transaksi");

                    form.attr("action", `${main.baseUrl}/transaksi/${id}`);
                    form.submit();
                }
            },
        });
    }

    showModalLoading(show) {
        if(show) {
            $('#modal-detail-loading').show();
            $('#modal-detail-content').hide();
        } else {
            $('#modal-detail-loading').hide();
            $('#modal-detail-content').show();
        }
    }

    /**
     * Fungsi show modal detail transaksi
     * 
     * @param  {integer} id
     * @return {void}
     */
    showDetail(id) {
        $('#modal-detail').modal('show');
        this.showModalLoading(true);

        $.ajax({
            type: 'GET',
            url: `${main.baseUrl}/transaksi/${id}`,
            data: { _token: main.csrfToken },
            dataType: "json",
            success: (res) => {
                this.showModalLoading(false);
                
                $('#detail-user').text(res.transaksi.user.profil.nama_lengkap);
                $('#detail-divisi').text(res.transaksi.divisi.nama_divisi);
                $('#detail-jenis-belanja').text(res.transaksi.jenis_belanja.kategori_belanja);
                $('#detail-tanggal').text(res.transaksi.tanggal);
                $('#detail-kegiatan').text(res.transaksi.kegiatan);
                $('#detail-jumlah-nominal').text(main.formatRupiah(res.transaksi.jumlah_nominal));
                $('#detail-no-dokumen').text(res.transaksi.no_dokumen);
                $('#detail-uraian').html(res.transaksi.uraian);
                $('#detail-approval').text(res.transaksi.approval);
            }
        });
    }

    /**
     * Fungsi close modal detail transaksi
     * 
     * @return {void}
     */
    closeDetail() {
        $('#modal-detail').modal('hide');
    }
};

const transaksi = new Transaksi();

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
        const fileNameEl = $("#file-name");
        const { files } = $(this)[0];

        if (files.length > 0) {
            fileNameEl.removeClass("d-none");
            fileNameEl.text(files[0].name);
        } else {
            if (fileNameEl.data("action") === "create") {
                fileNameEl.addClass("d-none");
            } else {
                fileNameEl.text(fileNameEl.data("file"));
            }
        }
    });

    /**
     * menghilangkan nama file dokumen ketika button reset ditekan
     */
    $("button[type=reset]").click(function (e) {
        const fileNameEl = $("#file-name");

        if (fileNameEl.data("action") === "create") {
            fileNameEl.addClass("d-none");
        } else {
            fileNameEl.text(fileNameEl.data("file"));
        }
    });
});
