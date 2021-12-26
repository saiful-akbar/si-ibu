<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Divisi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * view halaman dashboard
     *
     * @param Request $request
     *
     * @return view
     */
    public function index(Request $request)
    {
        $queryYear = Budget::select('tahun_anggaran')
            ->orderBy('tahun_anggaran', 'desc')
            ->get();

        $years = [];
        foreach ($queryYear as $budget) {
            if (!in_array($budget->tahun_anggaran, $years)) {
                $years[] = $budget->tahun_anggaran;
            }
        }

        $divisi = Divisi::all();

        /**
         * ambid data user akses untuk menu dashboard
         */
        $userAccess = User::with('menuItem')->find(Auth::user()->id)->menuItem->where('href', '/dashboard')->first();
        $create = $userAccess->pivot->create;
        $read = $userAccess->pivot->read;
        $update = $userAccess->pivot->update;
        $delete = $userAccess->pivot->delete;

        $isAdmin = false;

        /**
         * Cek apakah user mempunyai full akses atau tidak
         */
        if ($create == 1 && $read == 1 && $update == 1 && $delete == 1) {
            $isAdmin = true;
        }

        return view('pages.dashboard.index', compact('years', 'divisi', 'isAdmin'));
    }


    /**
     * Ambil semua data budget dan transaksi berdasarkan tahun
     *
     * @param int $year
     *
     * @return json
     */
    public function globalChart(int $year)
    {
        /**
         * jumlahkan nominal budget berdasarkan tahun dan id divisi user yang sedang login
         */
        $totalBudget = Budget::where([
            ['tahun_anggaran', $year],
            ['divisi_id', Auth::user()->divisi_id]
        ])->sum('nominal');

        /**
         * jumlahkan nominal transaksi berdasarkan tahun dan id divisi user yang sedang login
         */
        $totalTransaksi = Transaksi::where([
            ['tanggal', 'like', "%{$year}%"],
            ['divisi_id', Auth::user()->divisi_id]
        ])->sum('jumlah_nominal');

        /**
         * ambid data user akses untuk menu dashboard
         */
        $userAccess = User::with('menuItem')->find(Auth::user()->id)->menuItem->where('href', '/dashboard')->first();
        $create = $userAccess->pivot->create;
        $read = $userAccess->pivot->read;
        $update = $userAccess->pivot->update;
        $delete = $userAccess->pivot->delete;
        $divisi = Auth::user()->divisi->nama_divisi;


        /**
         * Cek apakah user mempunyai full akses atau tidak
         */
        if ($create == 1 && $read == 1 && $update == 1 && $delete == 1) {
            $totalBudget = Budget::where('tahun_anggaran', $year)->sum('nominal');
            $totalTransaksi = Transaksi::where('tanggal', 'like', "%{$year}%")->sum('jumlah_nominal');
            $divisi = 'Semua Divisi';
        }

        /**
         * buat sisa budget
         */
        $sisaBudget = 0;
        if ($totalBudget - $totalTransaksi >= 0) {
            $sisaBudget = $totalBudget - $totalTransaksi;
        }


        /**
         * response
         */
        return response()->json([
            'year' => $year,
            'totalBudget' => $totalBudget,
            'totalTransaksi' => $totalTransaksi,
            'sisaBudget' => $sisaBudget,
            'divisi' => $divisi,
        ], 200);
    }

    /**
     * Ambil semua data budget dan transaksi berdasarkan tahun dan divisinya
     *
     * @param Divisi $divisi
     * @param int $year
     *
     * @return json
     */
    public function divisiChart(Divisi $divisi, int $year)
    {
        /**
         * ambid data user akses untuk menu dashboard
         */
        $userAccess = User::with('menuItem')
            ->find(Auth::user()->id)
            ->menuItem
            ->where('href', '/dashboard')
            ->first();

        $create = $userAccess->pivot->create;
        $read = $userAccess->pivot->read;
        $update = $userAccess->pivot->update;
        $delete = $userAccess->pivot->delete;

        /**
         * Cek apakah user mempunyai full akses atau tidak
         */
        if ($create == 0 || $read == 0 || $update == 0 || $delete == 0) {
            return response()->json([], 403);
        }

        /**
         * jumlahkan nominal budget berdasarkan tahun dan id divisi user yang sedang login
         */
        $totalBudget = Budget::where([
            ['tahun_anggaran', $year],
            ['divisi_id', $divisi->id]
        ])->sum('nominal');

        /**
         * jumlahkan nominal transaksi berdasarkan tahun dan id divisi user yang sedang login
         */
        $totalTransaksi = Transaksi::where([
            ['tanggal', 'like', "%{$year}%"],
            ['divisi_id', $divisi->id]
        ])->sum('jumlah_nominal');

        /**
         * buat sisa budget
         */
        $sisaBudget = 0;
        if ($totalBudget - $totalTransaksi >= 0) {
            $sisaBudget = $totalBudget - $totalTransaksi;
        }

        return response()->json([
            'year' => $year,
            'totalBudget' => $totalBudget,
            'totalTransaksi' => $totalTransaksi,
            'sisaBudget' => $sisaBudget,
            'divisi' => $divisi->nama_divisi,
        ], 200);
    }
}
