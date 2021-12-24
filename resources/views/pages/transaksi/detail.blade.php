<div
    id="modal-detail"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="detail"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail">DETAIL TRANSAKSI</h5>
                
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
                <div id="modal-detail-loading">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>

                {{-- modal detail conten --}}
                <div id="modal-detail-content" class="container">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p><b id="detail-user"></b></p>
                            <p class="text-muted font-13">
                                <b id="detail-divisi"></b>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <p class="font-13">
                                <strong>No Dokumen :</strong>
                                <span id="detail-no-dokumen" class="ml-2"></span>
                            </p>
                            <p class="font-13">
                                <strong>Jenis Belanja :</strong>
                                <span id="detail-jenis-belanja" class="ml-2"></span>
                            </p>
                            <p class="font-13">
                                <strong>Tanggal :</strong>
                                <span id="detail-tanggal" class="ml-2"></span>
                            </p>
                            <p class="font-13">
                                <strong>Jumlah Nominal :</strong>
                                <span id="detail-jumlah-nominal" class="ml-2"></span>
                            </p>
                            <p class="font-13">
                                <strong>Approval :</strong>
                                <span id="detail-approval" class="ml-2"></span>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <hr/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-1">
                            <h5 class="h5" id="detail-kegiatan"></h4>
                        </div>
                        <div class="col-12">
                            <p id="detail-uraian" class="text-muted font-13"></p>
                        </div>
                    </div>
                </div>
                {{-- end modal detail conten --}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" onclick="transaksi.closeDetail()">
                    <i class=" mdi mdi-close"></i>
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>