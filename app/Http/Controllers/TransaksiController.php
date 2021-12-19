<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * generate no dokumen baru
     *
     * @return string
     */
    public function generateNoDocument()
    {
        /**
         * buat format
         */
        $format = 'DOK-' . date('Y-m') . '-';

        /**
         * ambil no dokumen tertinggi berdasarkan bulan dan tahun sekarang
         */
        $maxDoc = Transaksi::select('no_dokumen')
            ->where('no_dokumen', 'like', '%' . date('Y-m') . '%')
            ->max('no_dokumen');

        /**
         * ambil no unique dokumen dan tambahkan 1
         */
        $no = (int) substr($maxDoc, 12) + 1;

        /**
         * cek panjang nomer unique $no
         */
        switch (strlen($no)) {
            case 1:
                $format .= "000{$no}";
                break;

            case 2:
                $format .= "00{$no}";
                break;

            case 3:
                $format .= "0{$no}";
                break;

            default:
                $format .= $no;
                break;
        }

        return $format;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * query join tabel transaki, user, profil & divisi
         */
        $query = Transaksi::leftJoin('user', 'transaksi.user_id', '=', 'user.id')
            ->leftJoin('divisi', 'transaksi.divisi_id', '=', 'divisi.id')
            ->leftJoin('profil', 'user.id', '=', 'profil.user_id')
            ->select(
                'transaksi.id',
                'transaksi.tanggal',
                'transaksi.kegiatan',
                'transaksi.no_dokumen',
                'transaksi.approval',
                'transaksi.updated_at',
                'profil.nama_lengkap',
                'divisi.nama_divisi'
            );

        /**
         * cek jika ada request pencarian
         */
        if ($request->search) {
            $query->where('transaksi.kegiatan', 'like', "%{$request->search}%")
                ->orWhere('transaksi.jumlah', 'like', "%{$request->search}%")
                ->orWhere('transaksi.no_dokumen', 'like', "%{$request->search}%")
                ->orWhere('transaksi.approval', 'like', "%{$request->search}%")
                ->orWhere('profil.nama_lengkap', 'like', "%{$request->search}%")
                ->orWhere('divisi.nama_divisi', 'like', "%{$request->search}%");
        }

        /**
         * buat pagination
         */
        $transactions = $query->orderBy('transaksi.tanggal', 'desc')->simplePaginate(25)->withQueryString();

        /**
         * ambil user akses untuk menu transaksi
         */
        $userAccess = Auth::user()->menuItem->where('nama_menu', 'transaksi')->first();

        return view('pages.transaksi.index', compact('transactions', 'userAccess'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $noDocument = $this->generateNoDocument();
        $divisions = Divisi::all();

        return view('pages.transaksi.create', compact('divisions', 'noDocument'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
