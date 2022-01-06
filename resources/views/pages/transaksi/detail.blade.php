<div id="modal-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-full-width" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-1">
                    DETAIL TRANSAKSI BELANJA
                </h5>

                <button onclick="transaksi.closeDetail()" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- preloader --}}
                <div id="modal-detail-loading" class="my-5">
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

                {{-- modal detail conten --}}
                <div id="modal-detail-content" class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="clearfix">
                                        <div class="float-right">
                                            <h4 class="m-0 d-print-none">Detail</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="float-left mt-3">
                                                <p><b>Uraian</b></p>
                                                <p class="text-muted font-13" id="detail-uraian"></p>
                                            </div>

                                        </div>

                                        <div class="col-sm-4 offset-sm-2">
                                            <div class="mt-3 float-sm-right">
                                                <p class="font-13">
                                                    <strong>Bagian: </strong>
                                                    <span id="detail-nama-divisi" class="float-right ml-5"></span>
                                                </p>

                                                <p class="font-13">
                                                    <strong>Akun Belanja: </strong>
                                                    <span id="detail-kategori-belanja" class="float-right ml-5"></span>
                                                </p>

                                                <p class="font-13">
                                                    <strong>Submitter: </strong>
                                                    <span id="detail-submitter" class="float-right ml-5"></span>
                                                </p>

                                                <p class="font-13">
                                                    <strong>Approval: </strong>
                                                    <span id="detail-approval" class="float-right ml-5"></span>
                                                </p>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row mt-3">
                                        <div class="col-12">
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

                                    <div class="row mt-3">
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
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end modal detail conten --}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-rounded btn-outline-dark" onclick="transaksi.closeDetail()">
                    <i class=" mdi mdi-close"></i>
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>
