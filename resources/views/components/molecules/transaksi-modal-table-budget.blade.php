{{-- modal table list jenis belanja --}}
<div id="modal-table-budget" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Pilih Akun Belanja
                </h4>

                <button type="button" class="close" onclick="transaksi.showModalTableBudget(false)"
                    aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <table id="datatable-budget"
                    class="table table-hover table-centered w-100 nowrap @if (auth()->user()->pengaturan->tema == 'dark') table-dark @endif">
                    <thead>
                        <tr>
                            <th class="text-center">Aksi</th>
                            <th>Bagian</th>
                            <th>Akun Belanja</th>
                            <th>Tahun Anggaran</th>
                            <th>Sisa Budget</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-rounded btn-sm"
                    onclick="transaksi.showModalTableBudget(false)">
                    <i class="mdi mdi-close"></i>
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>
