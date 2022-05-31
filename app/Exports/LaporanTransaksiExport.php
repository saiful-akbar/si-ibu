<?php

namespace App\Exports;

// use App\Models\Divisi;
// use App\Models\Transaksi;
// use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanTransaksiExport implements FromView
{

    /**
     * @param Array $request
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }


    /**
     * Export excel form view
     *
     * @return View
     */
    public function view(): View
    {
        return view('export.excel.laporan-transaksi', $this->data);
    }
}
