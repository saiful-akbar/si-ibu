class Budget {
    constructor() {
        this.dataTableAkunBelanja = null;
    }
    handleDelete(a) {
        bootbox.confirm({
            title: "Anda ingin menghapus budget ?",
            message: String.raw`
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">
                        <i class="dripicons-warning mr-1"></i>
                        Peringatan!
                    </h4>
                    <ul>
                        <li>Tindakan ini tidak dapat dibatalkan.</li>
                        <li>Budget yang dihapus tidak dapat dikembalikan.</li>
                        <li>Pastikan anda berhati-hati dalam menghapus.</li>
                    </ul>
                    <p>
                        <b>NB:</b> Budget tidak dapat dihapus jika memiliki data relasi pada <b>Transaksi Belanja</b>!
                    </p>
                </div>
            `,
            buttons: {
                confirm: {
                    label: String.raw`<i class='mdi mdi-delete mr-1'></i> Hapus`,
                    className: "btn btn-danger btn-sm btn-rounded",
                },
                cancel: {
                    label: String.raw`<i class='mdi mdi-close-circle mr-1'></i> Batal`,
                    className: "btn btn-sm btn-dark btn-rounded mr-2",
                },
            },
            callback: (e) => {
                if (e) {
                    const e = $("#form-delete-budget");
                    e.attr("action", `${main.baseUrl}/budget/${a}`), e.submit();
                }
            },
        });
    }
    showLoading(a) {
        const e = $("#detail-loading"),
            n = $("#detail-content");
        a ? (e.show(), n.hide()) : (e.hide(), n.show());
    }
    detail(a, e = null) {
        $("#detail-budget").modal(a ? "show" : "hide"),
            a &&
                (this.showLoading(!0),
                $("#detail-transaksi").html(""),
                $.ajax({
                    type: "get",
                    url: `${main.baseUrl}/budget/${e}/show`,
                    dataType: "json",
                    success: (a) => {
                        this.showLoading(!1),
                            $("#detail-keterangan").html(a.budget.keterangan),
                            $("#detail-tahun-anggaran").text(
                                a.budget.tahun_anggaran
                            ),
                            $("#detail-tahun-anggaran").text(
                                a.budget.tahun_anggaran
                            ),
                            $("#detail-divisi").text(
                                a.budget.divisi.nama_divisi
                            ),
                            $("#detail-akun-belanja").text(
                                a.budget.jenis_belanja.akun_belanja
                                    .nama_akun_belanja
                            ),
                            $("#detail-jenis-belanja").text(
                                a.budget.jenis_belanja.kategori_belanja
                            ),
                            $("#detail-nominal").text(
                                "Rp. " + main.formatRupiah(a.budget.nominal)
                            ),
                            $("#detail-nominal-transaksi").text(
                                "Rp. " +
                                    main.formatRupiah(a.totalNominalTransaksi)
                            ),
                            $("#detail-sisa-nominal").text(
                                "Rp. " +
                                    main.formatRupiah(a.budget.sisa_nominal)
                            ),
                            a.transaksi.map((a) =>
                                $("#detail-transaksi").append(String.raw`
                            <tr>
                                <td>${a.tanggal}</td>
                                <td>${a.user.profil.nama_lengkap}</td>
                                <td>${a.kegiatan}</td>
                                <td>${a.approval}</td>
                                <td>${a.no_dokumen}</td>
                                <td class="text-center">
                                    ${
                                        null !== a.file_dokumen
                                            ? String.raw`
                                                <a
                                                    href="${main.baseUrl}/belanja/${a.id}/download"
                                                    class="btn btn-light btn-sm btn-rounded"
                                                >
                                                    <i class="mdi mdi-download"></i>
                                                    <span>Unduh</span>
                                                </a>
                                            `
                                            : "File tidak tersedia"
                                    }
                                </td>
                                <td class="text-right">
                                    Rp. ${main.formatRupiah(a.jumlah_nominal)}
                                </td>
                            </tr>
                         `)
                            );
                    },
                }));
    }
    handleCloseModalDetail() {
        $("#modal-detail").modal("hide");
    }
    modalTableAkunBelanja(a) {
        $("#modal-table-akun-belanja").modal(a ? "show" : "hide"),
            null == this.dataTableAkunBelanja &&
                (this.dataTableAkunBelanja = $(
                    "#datatable-akun-belanja"
                ).DataTable({
                    processing: !0,
                    serverSide: !0,
                    pageLength: 20,
                    lengthChange: !1,
                    scrollX: !0,
                    info: !1,
                    scrollY: "300px",
                    scrollCollapse: !0,
                    ajax: `${main.baseUrl}/akun-belanja/jenis-belanja/datatable`,
                    pagingType: "simple",
                    language: { paginate: { previous: "Prev", next: "Next" } },
                    columns: [
                        {
                            data: "action",
                            name: "action",
                            orderable: !1,
                            searchable: !1,
                            className: "text-center",
                        },
                        {
                            data: "akun_belanja.nama_akun_belanja",
                            name: "akun_belanja.nama_akun_belanja",
                        },
                        { data: "kategori_belanja", name: "kategori_belanja" },
                    ],
                }));
    }
    setValueAkunBelanja(a, e, n) {
        $("#jenis_belanja_id").val(a),
            $("#nama_akun_belanja").val(e),
            $("#kategori_belanja").val(n),
            this.modalTableAkunBelanja(!1);
    }
}
const budget = new Budget();
$(document).ready(function () {
    $("#keterangan").summernote({
        required: !0,
        height: 230,
        lang: "id-ID",
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["view", ["fullscreen", "help"]],
        ],
    });
});
