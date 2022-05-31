<div id="modal-table-akun-belanja" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-1">
                    Daftar Akun Belanja
                </h5>

                <button type="button" class="close" onclick="budget.modalTableAkunBelanja(false)"
                    aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <x-table id="datatable_modal-akun-belanja">
                    <x-slot name="thead">
                        <tr>
                            <th class="text-center">Pilih</th>
                            <th>Akun Belanja</th>
                            <th>Kategori Belanja</th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-dark btn-sm" onclick="budget.modalTableAkunBelanja(false)">
                    <i class="mdi mdi-close"></i>
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>
