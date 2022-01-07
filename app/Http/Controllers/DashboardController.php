<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\Transaksi;
use App\Models\User;
use App\Traits\UserAccessTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use UserAccessTrait;

    /**
     * view halaman dashboard
     *
     * @param Request $request
     *
     * @return view
     */
    public function index(Request $request)
    {
        /**
         * ambil data user auth
         */
        $authUser = Auth::user();

        /**
         * ambil akses menu user
         */
        $userAccess = $this->getAccess($authUser->id, '/dashboard');

        $isAdmin = false;

        /**
         * Cek apakah user mempunyai full akses atau tidak
         */
        if (
            $userAccess->create == 1 &&
            $userAccess->read == 1 &&
            $userAccess->update == 1 &&
            $userAccess->delete == 1
        ) {
            $isAdmin = true;
        }

        /**
         * Ambil data busget
         */
        $queryYear = Budget::select('tahun_anggaran')
            ->orderBy('tahun_anggaran', 'desc')
            ->get();

        /**
         * ambil tahun yang ada pada pada budget
         */
        $years = [];
        foreach ($queryYear as $budget) {
            if (!in_array($budget->tahun_anggaran, $years)) {
                $years[] = $budget->tahun_anggaran;
            }
        }

        /**
         * ambil data divisi
         */
        $divisi = Divisi::all();

        /**
         * Ambil data akun belanja (jenis_belanja)
         */
        $jenisBelanja = JenisBelanja::all();

        return view('pages.dashboard.index', compact('years', 'divisi', 'isAdmin', 'jenisBelanja'));
    }


    /**
     * Ambil semua data budget dan transaksi berdasarkan tahun
     *
     * @param int $year
     *
     * @return json
     */
    public function chartPieGlobalDivisi(int $year)
    {
        /**
         * ambil data user auth
         */
        $authUser = Auth::user();

        /**
         * ambil akses menu user
         */
        $userAccess = $this->getAccess($authUser->id, '/dashboard');

        /**
         * ambil bagian (divisi) user
         */
        $namaDivisi = $authUser->divisi->nama_divisi;


        /**
         * total nominal pada budget
         * berdasarkan bagian (divisi) & tahun
         */
        $totalBudget = Budget::where([
            ['divisi_id', $authUser->divisi_id],
            ['tahun_anggaran', $year]
        ])->sum('nominal');

        /**
         * total jumlah_nominal pada belanja (transaksi)
         * berdasarkan bagian (divisi) & tahun
         */
        $totalTransaksi = Transaksi::leftJoin('budget', 'budget.id', '=', 'transaksi.budget_id')
            ->where([
                ['budget.divisi_id', $authUser->divisi_id],
                ['transaksi.tanggal', 'like', "%{$year}%"],
            ])->sum('transaksi.jumlah_nominal');;

        /**
         * cek user superadmin atau tidak
         * jika iya,
         * totalkan budget seluruh bagian (divisi) berdasarkan tahun &
         * total kan seluruh jumlah_nominal transaksi berdasarkan tahun
         */
        if (
            $userAccess->create == 1 &&
            $userAccess->read == 1 &&
            $userAccess->update == 1 &&
            $userAccess->delete == 1
        ) {
            $totalBudget = Budget::where('tahun_anggaran', $year)->sum('nominal');
            $totalTransaksi = Transaksi::where('tanggal', 'like', "%{$year}%")->sum('jumlah_nominal');

            /**
             * jika user super admin ubah $divisi menjadi "semua bagian (divisi)"
             */
            $namaDivisi = "Semua Bagian";
        }

        /**
         * total sisa budget
         */
        $sisa = $totalBudget - $totalTransaksi;
        $sisaBudget = $sisa < 0 ? 0 : $sisa;

        /**
         * response
         */
        return response()->json([
            'tahun' => (int) $year,
            'totalBudget' => (int) $totalBudget,
            'totalTransaksi' => (int) $totalTransaksi,
            'sisaBudget' => (int) $sisaBudget,
            'namaDivisi' => $namaDivisi,
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
    public function chartPiePerDivisi(Divisi $divisi, int $year)
    {
        /**
         * ambil data user auth
         */
        $authUser = Auth::user();

        /**
         * ambil akses menu user
         */
        $userAccess = $this->getAccess($authUser->id, '/dashboard');

        /**
         * Cek apakah user mempunyai full akses (superadmin) atau tidak
         */
        if (
            $userAccess->create == 0 ||
            $userAccess->read == 0 ||
            $userAccess->update == 0 ||
            $userAccess->delete == 0
        ) {
            return response()->json([], 403);
        }

        /**
         * Total nominal budget berdsarkan bagian (divisi) & tahun
         */
        $totalBudget = Budget::where([
            ['tahun_anggaran', $year],
            ['divisi_id', $divisi->id]
        ])->sum('nominal');

        /**
         * Toal jumlah_nominal belanja (transaksi) berdasarkan bagian (divisi) & tahun
         */
        $totalTransaksi = Transaksi::leftJoin('budget', 'budget.id', 'transaksi.budget_id')
            ->where([
                ['transaksi.tanggal', 'like', "%{$year}%"],
                ['budget.divisi_id', $divisi->id]
            ])->sum('jumlah_nominal');

        /**
         * total sisa budget
         */
        $sisa = $totalBudget - $totalTransaksi;
        $sisaBudget = $sisa < 0 ? 0 : $sisa;

        return response()->json([
            'tahun' => (int) $year,
            'totalBudget' => (int) $totalBudget,
            'totalTransaksi' => (int) $totalTransaksi,
            'sisaBudget' => (int) $sisaBudget,
            'namaDivisi' => $divisi->nama_divisi,
        ], 200);
    }

    /**
     * Jenis belanja chart
     *
     * @param Divisi $divisi
     * @param int $year
     *
     * @return Object
     */
    public function chartLinePerJenisBelanja(Divisi $divisi, int $year): Object
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
        if ($create == 1 && $read == 1 && $update == 1 && $delete == 1) {
            return response()->json([], 403);
        }

        $bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data = [];

        foreach (JenisBelanja::all() as $keyJenisBelanja => $valueJenisBelanja) {
            $data[$keyJenisBelanja]['name'] = $valueJenisBelanja->kategori_belanja;

            foreach ($bulan as $valueBulan) {
                $data[$keyJenisBelanja]['data'][] = Transaksi::where('tanggal', 'like', "{$year}-{$valueBulan}%")
                    ->where('jenis_belanja_id', $valueJenisBelanja->id)
                    ->where('divisi_id', $divisi->id)
                    ->sum('jumlah_nominal');
            }
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
