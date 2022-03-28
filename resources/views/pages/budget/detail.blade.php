<div
    id="detail-budget"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="detailBudget"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4
                    class="modal-title"
                    id="detailBudget"
                >
                    Detail Pagu
                </h4>

                <button
                    class="close"
                    onclick="budget.detail(false)"
                >×</button>
            </div>

            <div class="modal-body">

                {{-- preloader --}}
                <div
                    id="detail-loading"
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

                {{-- detail content --}}
                <div
                    id="detail-content"
                    class="px-md-3 px-1"
                >
                    <div class="row mt-3">
                        <div class="col">
                            <strong>Tahun Anggaran :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-tahun-anggaran"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <strong>Bagian :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-divisi"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <strong>Akun Belanja :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-akun-belanja"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <strong>Jenis Belanja :</strong>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <p id="detail-jenis-belanja"></p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <strong>Keterangan</strong>
                                <p
                                    class="text-muted font-13 mt-2"
                                    id="detail-keterangan"
                                ></p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-12 mb-3">
                            <span class="h5">List Belanja</span>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table table-centered nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Submitter</th>
                                            <th>Kegiatan</th>
                                            <th>Approval</th>
                                            <th>No Dokumen</th>
                                            <th class="text-center">File Dokumen</th>
                                            <th class="text-right">Jumlah Nominal</th>
                                        </tr>
                                    </thead>

                                    <tbody id="detail-transaksi"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right">
                                <p>
                                    <b>Budget :</b>
                                    <span
                                        class="float-right ml-3"
                                        id="detail-nominal"
                                    ></span>
                                </p>

                                <p>
                                    <b>Total Belanja :</b>
                                    <span
                                        class="float-right ml-3"
                                        id="detail-nominal-transaksi"
                                    ></span>
                                </p>

                                <hr>

                                <h3
                                    id="detail-sisa-nominal"
                                    class="float-right"
                                ></h3>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button
                    class="btn btn-dark btn-sm btn-rounded"
                    onclick="budget.detail(false)"
                >
                    <i class=" mdi mdi-close-circle"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
