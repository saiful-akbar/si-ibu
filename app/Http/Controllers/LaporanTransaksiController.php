<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

/**
 * Laporan Transaksi
 */
class LaporanTransaksiController extends Controller
{
    /**
     * view laporan transaksi
     *
     * @param Request $request
     *
     * @return view
     */
    public function index(Request $request)
    {
        /**
         * Validasi rule
         */
        $validateRules = ['periodeAwal' => [], 'periodeAkhir' => [], 'divisi' => []];

        /**
         * Pesan error validasi
         */
        $validateErrorMessage = [
            'periodeAwal.required' => 'Periode harus diisi.',
            'periodeAwal.date' => 'Periode harus tanggal yang valid.',
            'periodeAkhir.required' => 'Periode harus diisi.',
            'periodeAkhir.date' => 'Periode harus tanggal yang valid.',
            'divisi.exists' => 'Divisi tidak ada. Pilih divisi yang ditentukan.',
        ];

        /**
         * jika periodeAwal & periodeAkhir dikirim tambahkan validasi
         */
        if ($request->periodeAwal || $request->periodeAkhir) {
            array_push($validateRules['periodeAwal'], 'required', 'date');
            array_push($validateRules['periodeAkhir'], 'required', 'date');
        }

        /**
         * jika divisi dipilih jalankan validasi
         */
        if ($request->divisi != null) {
            array_push($validateRules['divisi'], 'exists:divisi,nama_divisi');
        }

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * Query join table transaksi, divisi, user & profil
         */
        $query = Transaksi::with(['divisi', 'jenisBelanja', 'user.profil'])
            ->whereBetween('transaksi.tanggal', [$request->periodeAwal, $request->periodeAkhir]);

        /**
         * cek apakan request divis dipilih atau tidak
         */
        if ($request->divisi != null) {
            $divisi = Divisi::where('nama_divisi', $request->divisi)->first();
            $query->where('divisi_id',  $divisi->id);
        }

        /**
         * buat order
         */
        $query->orderBy('tanggal', 'asc')->orderBy('divisi_id', 'asc');

        /**
         * response
         */
        return view('pages.laporan-transaksi.index', [
            'divisi' => Divisi::select('id', 'nama_divisi')->get(),
            'laporanTransaksi' => $query->paginate(50)->withQueryString(),
        ]);
    }
}
