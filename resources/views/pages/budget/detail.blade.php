<div id="detail-budget" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailBudget"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="detailBudget">Detail Budget</h4>
                <button class="close" onclick="budget.detail(false)">×</button>
            </div>

            <div class="modal-body">

                {{-- preloader --}}
                <div id="detail-loading" class="my-5">
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

                <div id="detail-content" class="px-md-3 px-1">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="float-left mt-3">
                                <p><b>Keterangan</b></p>
                                <p class="text-muted font-13" id="detail-keterangan"></p>
                            </div>

                        </div>

                        <div class="col-sm-4 offset-sm-2">
                            <div class="mt-3 float-sm-right">
                                <p class="font-13">
                                    <strong>Tahun Anggaran :</strong>
                                    <span class="float-right ml-3" id="detail-tahun-anggaran"></span>
                                </p>

                                <p class="font-13">
                                    <strong>Bagian :</strong>
                                    <span class="float-right ml-3" id="detail-divisi"></span>
                                </p>

                                <p class="font-13">
                                    <strong>Akun Belanja :</strong>
                                    <span class="float-right ml-3" id="detail-jenis-belanja"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-3 mb-2">
                            <span class="h5">List Belanja</span>
                        </div>

                        <div class="col-12">
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
                        <div class="col-sm-12 mt-3">
                            <div class="float-right mt-3 mt-sm-0">
                                <p>
                                    <b>Budget :</b>
                                    <span class="float-right ml-3" id="detail-nominal"></span>
                                </p>
                                <p>
                                    <b>Total Belanja :</b>
                                    <span class="float-right ml-3" id="detail-nominal-transaksi"></span>
                                </p>
                                <hr>
                                <h3 id="detail-sisa-nominal" class="float-right"></h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-dark btn-sm btn-rounded" onclick="budget.detail(false)">
                    <i class=" mdi mdi-close-circle"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
