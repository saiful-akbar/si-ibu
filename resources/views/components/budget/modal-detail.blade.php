<div id="detail-budget" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailBudget" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="detailBudget">Detail Pagu</h4>
                <button class="close" onclick="budget.detail(false)">×</button>
            </div>

            <div class="modal-body">
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

                <div id="detail-content" class="px-md-3 px-1">
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
                                <p class="text-muted font-13 mt-2" id="detail-keterangan"></p>
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
                                <x-table>
                                    <x-slot name="tbody">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Submitter</th>
                                            <th>Kegiatan</th>
                                            <th>Approval</th>
                                            <th>No Dokumen</th>
                                            <th class="text-center">File Dokumen</th>
                                            <th class="text-right">Jumlah Nominal</th>
                                        </tr>
                                    </x-slot>

                                    <x-slot name="tbody" id="detail-transaksi"></x-slot>
                                </x-table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Pagu :</td>
                                            <td id="detail-nominal" class="text-right"></td>
                                        </tr>
                                        <tr>
                                            <td>Total Realisasi :</td>
                                            <td id="detail-nominal-transaksi" class="text-right"></td>
                                        </tr>
                                        <tr>
                                            <td id="detail-sisa-nominal" class="text-right" colspan="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-dark btn-sm" onclick="budget.detail(false)">
                    <i class="mdi mdi-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
