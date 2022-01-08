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

                <div id="detail-content" class="px-3">
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
                                    <strong>Tahun Anggaran: </strong>
                                    <span class="float-right" id="detail-tahun-anggaran"></span>
                                </p>

                                <p class="font-13">
                                    <strong>Bagian: </strong>
                                    <span class="float-right" id="detail-divisi"></span>
                                </p>

                                <p class="font-13">
                                    <strong>Akun Belanja: </strong>
                                    <span class="float-right" id="detail-jenis-belanja"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mt-4">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <b>Laptop</b> <br />
                                                Brand Model VGN-TXN27N/B
                                                11.1" Notebook PC
                                            </td>
                                            <td>1</td>
                                            <td>$1799.00</td>
                                            <td class="text-right">$1799.00</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>
                                                <b>Warranty</b> <br />
                                                Two Year Extended Warranty -
                                                Parts and Labor
                                            </td>
                                            <td>3</td>
                                            <td>$499.00</td>
                                            <td class="text-right">$1497.00</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>
                                                <b>LED</b> <br />
                                                80cm (32) HD Ready LED TV
                                            </td>
                                            <td>2</td>
                                            <td>$412.00</td>
                                            <td class="text-right">$824.00</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right mt-3 mt-sm-0">
                                <p>
                                    <b>Nominal Budget : </b>
                                    <span class="float-right" id="detail-nominal"></span>
                                </p>

                                <p>
                                    <b>Nominal Belanja : </b>
                                    <span class="float-right" id="detail-nominal-transaksi"></span>
                                </p>

                                <h3 id="detail-sisa-nominal"></h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light btn-sm btn-rounded" onclick="budget.detail(false)">
                    <i class=" mdi mdi-close"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
