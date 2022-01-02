class Transaksi {
    constructor() {
        this.dataTableBudget = null;
    }

    /**
     * Method handle hapus data user
     *
     * @param {int} id
     * @param {string} noDokumen
     */
    delete(id, noDokumen) {
        bootbox.confirm({
            title: "Peringatan!",
            message: `
                <ul>
                    <li>Yakin ingin menghapus data belanja dengan nomer dokumen "<strong>${noDokumen}</strong>" ?</li>
                    <li>Semua data terkait atau data yang berelasi dengan data belanja ini juga akan terhapus.</li>
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

                    form.attr("action", `${main.baseUrl}/belanja/${id}`);
                    form.submit();
                }
            },
        });
    }

    /**
     * Method how modal loading
     * @param {boolean} show
     */
    showModalLoading(show) {
        if (show) {
            $("#modal-detail-loading").show();
            $("#modal-detail-content").hide();
        } else {
            $("#modal-detail-loading").hide();
            $("#modal-detail-content").show();
        }
    }

    /**
     * Method show modal detail transaksi
     *
     * @param  {integer} id
     * @return {void}
     */
    showDetail(id) {
        $("#modal-detail").modal("show");
        this.showModalLoading(true);

        $.ajax({
            type: "GET",
            url: `${main.baseUrl}/belanja/${id}`,
            data: { _token: main.csrfToken },
            dataType: "json",
            success: (res) => {
                this.showModalLoading(false);

                $("#detail-user").text(res.transaksi.user.profil.nama_lengkap);
                $("#detail-divisi").text(res.transaksi.divisi.nama_divisi);
                $("#detail-jenis-belanja").text(
                    res.transaksi.jenis_belanja.kategori_belanja
                );
                $("#detail-tanggal").text(res.transaksi.tanggal);
                $("#detail-kegiatan").text(res.transaksi.kegiatan);
                $("#detail-jumlah-nominal").text(
                    main.formatRupiah(res.transaksi.jumlah_nominal)
                );
                $("#detail-no-dokumen").text(res.transaksi.no_dokumen);
                $("#detail-uraian").html(res.transaksi.uraian);
                $("#detail-approval").text(res.transaksi.approval);
            },
        });
    }

    /**
     * Method close modal detail transaksi
     *
     * @return {void}
     */
    closeDetail() {
        $("#modal-detail").modal("hide");
    }

    /**
     *
     * @param {boolean} show
     */
    showModalTableBudget(show) {
        $("#modal-table-budget").modal(show ? "show" : "hide");

        if (this.dataTableBudget == null) {
            this.dataTableBudget = $("#datatable-budget").DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                lengthChange: false,
                scrollX: true,
                destroy: false,
                info: false,
                ajax: `${main.baseUrl}/belanja/budget/datatable`,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>",
                    },
                },
                columns: [
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "nama_divisi",
                        name: "nama_divisi",
                    },
                    {
                        data: "kategori_belanja",
                        name: "kategori_belanja",
                    },
                    {
                        data: "tahun_anggaran",
                        name: "tahun_anggaran",
                    },
                    {
                        data: "nominal",
                        name: "nominal",
                        render: (data) => main.formatRupiah(data),
                    },
                ],
            });
        }
    }

    /**
     * Method set value pada form
     *
     * @param {JSON} data
     */
    setFormValue(data) {
        this.showModalTableBudget(false);

        $("#jenis_belanja_id").val(data.id);
        $("#tahun_anggaran").val(data.tahun_anggaran);
        $("#sisa_budget").val(main.formatRupiah(data.nominal));
        $("#kategori_belanja").val(
            `${data.nama_divisi} - ${data.kategori_belanja}`
        );
    }
}

/**
 * Inisialisasi class transaksi
 */
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

    /**
     * handle export excel & print pdf
     */
    $(".btn-export").click(function (e) {
        e.preventDefault();

        const route = $(this).data("route");
        const formExport = $("#form-export");

        formExport.attr("action", route);

        formExport.submit();
    });
});
