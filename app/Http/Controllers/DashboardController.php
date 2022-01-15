<?php

namespace App\Http\Controllers;

use App\Models\AkunBelanja;
use App\Models\Budget;
use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\Transaksi;
use App\Traits\UserAccessTrait;
use Illuminate\Database\Eloquent\Builder;
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


        /**
         * Cek apakah user mempunyai full akses atau tidak
         */
        $isAdmin = false;

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
         * ambil data bagian (divisi)
         */
        $divisi = Divisi::where('active', 1)->get();

        /**
         * ambil data akun_belanja
         */
        $akunBelanja = AkunBelanja::where('active', 1)->get();

        /**
         * Ambil data jenis_belanja
         */
        $jenisBelanja = JenisBelanja::where('active', 1)->get();

        return view('pages.dashboard.index', compact('years', 'divisi', 'isAdmin', 'jenisBelanja', 'akunBelanja'));
    }

    /**
     * Global budget chart pie
     *
     * @param int $year
     *
     * @return object
     */
    public function globalBudgetChart(int $year): object
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
     * Budget chart pie per bagian (divisi)
     *
     * @param Divisi $divisi
     * @param int $year
     *
     * @return object
     */
    public function budgetChartByDivisi(Divisi $divisi, int $year): object
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
     * Budget chart line per akun belanja
     *
     * @param Divisi $divisi
     * @param int $year
     *
     * @return object
     */
    public function transaksiChartLine(int $year): object
    {
        /**
         * ambil akses menu user
         */
        $userAccess = $this->getAccess(href: '/dashboard');

        /**
         * Cek apakah user mempunyai full akses atau tidak
         */
        if (
            $userAccess->create == 1 &&
            $userAccess->read == 1 &&
            $userAccess->update == 1 &&
            $userAccess->delete == 1
        ) {
            return response()->json([], 403);
        }

        /**
         * buat data bulan dan data array kosong
         */
        $data = [];
        $bulan = [
            '01',
            '02',
            '03',
            '04',
            '05',
            '06',
            '07',
            '08',
            '09',
            '10',
            '11',
            '12',
        ];

        /**
         * ambil data akun_belanja berdasarkan divisi_id user yang yang sedang login
         */
        $akunBelanja = AkunBelanja::with('jenisBelanja.budget')
            ->where('active', 1)
            ->whereHas('jenisBelanja.budget', fn (Builder $query) => $query->where('divisi_id', Auth::user()->divisi_id))
            ->get();

        /**
         * looping data akun belanja (jenis_belanja)
         */
        foreach ($akunBelanja as $key => $aBelanja) {
            $data[$key]['name'] = $aBelanja->nama_akun_belanja;

            /**
             * isi value data untuk jumlah total transakai setiap bulannya berdasarkan divisi user yang sedang login
             */
            foreach ($bulan as $bln) {
                $data[$key]['data'][] = (int) Transaksi::with('budget.jenisBelanja')
                    ->where('tanggal', 'like', "{$year}-{$bln}%")
                    ->whereHas('budget.jenisBelanja', fn (Builder $query) => $query->where('akun_belanja_id', $aBelanja->id))
                    ->whereHas('budget', fn (Builder $query) => $query->where('divisi_id', Auth::user()->divisi_id))
                    ->sum('jumlah_nominal');
            }
        }

        return response()->json([
            'data' => $data,
        ], 200);
    }

    /**
     * Budget chart pie per akun_belanja
     *
     * @param int $periodeTahun
     * @param Divisi $divisi
     * @param AkunBelanja $akunBelanja
     * @param JenisBelanja $jenisBelanja
     *
     * @return object
     */
    public function budgetChartByAkunBelanja(Request $request): object
    {
        /**
         * ambil akses menu user
         */
        $userAccess = $this->getAccess(href: '/dashboard');

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
         * ambil tahun anggaran
         */
        $tahunAnggaran = $request->tahun_anggaran ?? date('Y');

        /**
         * Query total budget
         */
        $budget = Budget::with('jenisBelanja')
            ->where('tahun_anggaran', $tahunAnggaran);

        /**
         * query
         */
        $transaksi = Transaksi::with('budget.jenisBelanja', 'budget')
            ->whereHas('budget', function (Builder $query) use ($tahunAnggaran) {
                $query->where('tahun_anggaran', $tahunAnggaran);
            });

        /**
         * cek jika divisi dipilih
         */
        if ($request->divisi) {
            $budget->where('divisi_id', $request->divisi);

            $transaksi->whereHas('budget', function (Builder $query) use ($request) {
                $query->where('divisi_id', $request->divisi);
            });
        }

        /**
         * cek jika akun_belanja dipilih
         */
        if ($request->akun_belanja) {
            $budget->whereHas('jenisBelanja', function (Builder $query) use ($request) {
                $query->where('akun_belanja_id', $request->akun_belanja);
            });

            $transaksi->whereHas('budget.jenisBelanja', function (Builder $query) use ($request) {
                $query->where('akun_belanja_id', $request->akun_belanja);
            });
        }

        /**
         * cek jika jenis_belanja dipilih
         */
        if ($request->jenis_belanja) {
            $budget->where('jenis_belanja_id', $request->jenis_belanja);

            $transaksi->whereHas('budget', function (Builder $query) use ($request) {
                $query->where('jenis_belanja_id', $request->jenis_belanja);
            });
        }

        /**
         * jumlah sisa nominal budget
         */
        $sisa = $budget->sum('sisa_nominal');
        $sisaBudget = $sisa >= 0 ? $sisa : 0;

        return response()->json([
            'totalBudget' => (int) $budget->sum('nominal'),
            'totalTransaksi' => (int) $transaksi->sum('jumlah_nominal'),
            'sisaBudget' => (int) $sisaBudget,
        ], 200);
    }
}
