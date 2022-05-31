class Transaksi {
    constructor() {
        this.dtBudget = null;
    }

    /**
     * Fungsi handle delete transaksi (pagu)
     * 
     * @param  {int} id [id transaksi (pagu)]
     * @return void
     */
    handleDelete(id) {
        main.handleDelete('Hapus Realisasi ?', (response) => {
            if (response) {
                const form = $('#form-delete');
                const url = `${main.baseUrl}/belanja/${id}`;

                form.attr('action', url);
                form.submit();
            }
        })
    }

    /**
     * Method untuk menampilkan modal loading
     * 
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

                const { nama_divisi } = res.transaksi.budget.divisi;
                const { kategori_belanja } = res.transaksi.budget.jenis_belanja;
                const { nama_lengkap } = res.transaksi.user.profil;
                const {
                    uraian,
                    tanggal,
                    approval,
                    kegiatan,
                    no_dokumen,
                    jumlah_nominal,
                    created_at,
                    updated_at,
                } = res.transaksi;

                $("#detail-uraian").html(uraian);
                $("#detail-nama-divisi").text(nama_divisi);
                $("#detail-kategori-belanja").text(kategori_belanja);
                $("#detail-submitter").text(nama_lengkap);
                $("#detail-approval").text(approval);
                $("#detail-created-at").text(created_at);
                $("#detail-updated-at").text(updated_at);
                $("#detail-kegiatan").text(kegiatan);
                $("#detail-tanggal").text(tanggal);
                $("#detail-no-dokumen").text(no_dokumen);
                $("#detail-jumlah-nominal").text("Rp. " + main.formatRupiah(jumlah_nominal));

                if (res.download !== null) {
                    $("#detail-download-dokumen").html(String.raw `
                        <a href="${res.download}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-download"></i>
                            <span>Unduh</span>
                        </a>
                    `);
                } else {
                    $("#detail-download-dokumen").text("File tidak tersedia");
                }
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

        const options = {
            processing: true,
            serverSide: true,
            pageLength: 20,
            lengthChange: false,
            scrollX: true,
            destroy: false,
            info: false,
            ajax: `${main.baseUrl}/belanja/budget/datatable`,
            pagingType: "simple",
            language: {
                paginate: {
                    previous: "Prev",
                    next: "Next"
                }
            },
            columns: [
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "tahun_anggaran",
                    name: "tahun_anggaran",
                },
                {
                    data: "nama_divisi",
                    name: "nama_divisi",
                },
                {
                    data: "nama_akun_belanja",
                    name: "nama_akun_belanja",
                },
                {
                    data: "kategori_belanja",
                    name: "kategori_belanja",
                },
                {
                    data: "sisa_nominal",
                    name: "sisa_nominal",
                    render: (data) => "Rp. " + main.formatRupiah(data),
                },
            ],
        };

        if (this.dtBudget == null) {
            this.dtBudget = $("#datatable-budget").DataTable(options);
        }
    }

    /**
     * Method set value pada form
     *
     * @param {JSON} data
     */
    setFormValue(
        id,
        tahunAnggaran,
        namaDivisi,
        namaAkunBelanja,
        kategoriBelanja,
        sisaNominal
    ) {
        this.showModalTableBudget(false);

        $("#budget_id").val(id);
        $("#nama_akun_belanja").val(namaAkunBelanja);
        $("#kategori_belanja").val(kategoriBelanja);
        $("#nama_divisi").val(namaDivisi);
        $("#tahun_anggaran").val(tahunAnggaran);
        $("#sisa_budget").val(sisaNominal);
        $("#jumlah_nominal").attr("max", sisaNominal);
    }
}

/**
 * Inisialisasi class transaksi
 */
const transaksi = new Transaksi();

$(document).ready(function() {
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
    $("#file_dokumen").change(function(e) {
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
    $("button[type=reset]").click(function(e) {
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
    $(".btn-export").click(function(e) {
        e.preventDefault();

        const route = $(this).data("route");
        const formExport = $("#form-export");

        formExport.attr("action", route);
        formExport.submit();
    });
});
