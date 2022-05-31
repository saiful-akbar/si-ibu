{{-- modal table list jenis belanja --}}
<div id="modal-table-budget" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-1">
                    Daftar Pagu
                </h5>

                <button
                    type="button"
                    class="close"
                    onclick="transaksi.showModalTableBudget(false)"
                    aria-hidden="true"
                >×</button>
            </div>

            <div class="modal-body">
                <x-table id="datatable-budget">
                    <x-slot name="thead">
                        <tr>
                            <th class="text-center">Pilih</th>
                            <th>Tahun Anggaran</th>
                            <th>Bagian</th>
                            <th>Akun Belanja</th>
                            <th>Jenis Belanja</th>
                            <th>Sisa Budget</th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-dark btn-sm" onclick="transaksi.showModalTableBudget(false)">
                    <i class="mdi mdi-close"></i>
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>
