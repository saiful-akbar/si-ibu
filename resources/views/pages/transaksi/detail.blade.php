<div
    id="modal-detail"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="detail"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-scrollable modal-lg"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-1">
                    Detail Realisasi
                </h5>

                <button
                    onclick="transaksi.closeDetail()"
                    type="button"
                    class="close"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- preloader --}}
                <div
                    id="modal-detail-loading"
                    class="my-5"
                >
                    <div class="d-flex justify-content-center align-items-center">
                        <div id="status">
                            <div class="bouncing-loader">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end preloader --}}

                {{-- modal detail conten --}}
                <div
                    id="modal-detail-content"
                    class="px-3"
                >
                    <div class="row mt-3">
                        <div class="col">
                            <strong>Bagian :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-nama-divisi"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <strong>Akun Belanja :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-kategori-belanja"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <strong>Submitter :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-submitter"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <strong>Approval :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-approval"></p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-12">
                            <strong>Uraian</strong>
                            <p
                                class="text-muted font-13 mt-2"
                                id="detail-uraian"
                            ></p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table w-100 nowrap mt-4">
                                    <tbody>
                                        <tr>
                                            <th>Kegiatan</th>
                                            <td id="detail-kegiatan"></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td id="detail-tanggal"></td>
                                        </tr>
                                        <tr>
                                            <th>No. Dokumen</th>
                                            <td id="detail-no-dokumen"></td>
                                        </tr>
                                        <tr>
                                            <th>File Dokumen</th>
                                            <td id="detail-download-dokumen"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="mt-sm-0">
                                <p><b>Jumlah Nominal</b></p>
                                <h3 id="detail-jumlah-nominal"></h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-1">
                            <div class="float-md-right">
                                <h6>Dibuat</h6>
                                <div id="detail-created-at"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="float-md-right">
                                <h6>Diperbarui</h6>
                                <div id="detail-updated-at"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end modal detail conten --}}

            </div>

            <div class="modal-footer">
                <button
                    class="btn btn-sm btn-rounded btn-dark"
                    onclick="transaksi.closeDetail()"
                >
                    <i class=" mdi mdi-close-circle mr-1"></i>
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>
