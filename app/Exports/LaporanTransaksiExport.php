<?php

namespace App\Exports;

use App\Models\Divisi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanTransaksiExport implements FromView
{

    /**
     * @param Object $request
     */
    public function __construct(Object $request)
    {
        $this->request = $request;
    }


    /**
     * Export excel form view
     *
     * @return View
     */
    public function view(): View
    {
        /**
         * Query join table transaksi, divisi, user & profil
         */
        $query = Transaksi::with(['divisi', 'jenisBelanja', 'user.profil'])
            ->whereBetween('transaksi.tanggal', [$this->request->periodeAwal, $this->request->periodeAkhir]);

        /**
         * cek apakan request divis dipilih atau tidak
         */
        if ($this->request->divisi != null) {
            $divisi = Divisi::where('nama_divisi', $this->request->divisi)->first();

            if ($divisi) {
                $query->where('divisi_id',  $divisi->id);
            }
        }

        /**
         * buat order
         */
        $result = $query->orderBy('tanggal', 'asc')->orderBy('divisi_id', 'asc')->get();

        return view('pages.laporan-transaksi.export-excel', [
            'laporanTransaksi' => $result
        ]);
    }
}
