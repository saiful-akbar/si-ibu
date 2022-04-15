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
use Illuminate\Support\Js;

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
         * ambil akses menu user
         */
        $userAccess = $this->getAccess(href: '/dashboard');


        /**
         * Cek apakah user mempunyai full akses atau tidak
         */
        $isAdmin = $this->isAdmin(href: '/dashboard');

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

        return view(
            'pages.dashboard.index',
            compact('years', 'divisi', 'isAdmin', 'akunBelanja')
        );
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
         * ambil data user sebagai admin atau bukan
         */
        $isAdmin = $this->isAdmin(href: '/dashboard', userId: $authUser->id);

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
        if ($isAdmin) {
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
         * cek user sebagau admin atau bukan
         */
        $isAdmin = $this->isAdmin(href: '/dashboard');

        /**
         * Cek apakah user mempunyai full akses (superadmin) atau tidak
         */
        if (!$isAdmin) {
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
        $isAdmin = $this->isAdmin(href: '/dashboard');

        /**
         * ambil tahun anggaran
         */
        $tahunAnggaran = $request->tahun_anggaran ?? date('Y');

        /**
         * Query total budget
         */
        $budget = Budget::with('jenisBelanja')->where('tahun_anggaran', $tahunAnggaran);

        /**
         * Query total transaksi
         */
        $outstanding = Transaksi::with('budget.jenisBelanja', 'budget')
            ->where('outstanding', '=', 1)
            ->whereHas('budget', fn (Builder $query) => $query->where('tahun_anggaran', $tahunAnggaran));

        $onstanding = Transaksi::with('budget.jenisBelanja', 'budget')
            ->where('outstanding', '=', 0)
            ->whereHas('budget', fn (Builder $query) => $query->where('tahun_anggaran', $tahunAnggaran));

        /**
         * Cek jika user sebagai admin & divisi (bagian) select dirubah
         */
        if ($isAdmin) {
            if ($request->divisi) {
                $budget->where('divisi_id', $request->divisi);
                $outstanding->whereHas('budget', fn (Builder $query) => $query->where('divisi_id', $request->divisi));
                $onstanding->whereHas('budget', fn (Builder $query) => $query->where('divisi_id', $request->divisi));
            }
        } else {
            $divisiId = auth()->user()->divisi_id;
            $budget->where('divisi_id', $divisiId);
            $outstanding->whereHas('budget', fn (Builder $query) => $query->where('divisi_id', $divisiId));
            $onstanding->whereHas('budget', fn (Builder $query) => $query->where('divisi_id', $divisiId));
        }

        /**
         * cek jika akun_belanja dipilih
         */
        if ($request->akun_belanja) {
            $budget->whereHas('jenisBelanja', fn (Builder $query) => $query->where('akun_belanja_id', $request->akun_belanja));
            $outstanding->whereHas('budget.jenisBelanja', fn (Builder $query) => $query->where('akun_belanja_id', $request->akun_belanja));
            $onstanding->whereHas('budget.jenisBelanja', fn (Builder $query) => $query->where('akun_belanja_id', $request->akun_belanja));

            /**
             * Cek jumlah jenis belanja
             */
            $countJenisBelanja = JenisBelanja::where([
                ['id', $request->jenis_belanja],
                ['akun_belanja_id', $request->akun_belanja],
            ])->count();

            /**
             * cek jika jenis_belanja dipilih
             */
            if ($request->jenis_belanja && $countJenisBelanja > 0) {
                $budget->where('jenis_belanja_id', $request->jenis_belanja);
                $outstanding->whereHas('budget', fn (Builder $query) => $query->where('jenis_belanja_id', $request->jenis_belanja));
                $onstanding->whereHas('budget', fn (Builder $query) => $query->where('jenis_belanja_id', $request->jenis_belanja));
            }
        }


        /**
         * jumlah sisa nominal budget
         */
        $sisa = $budget->sum('sisa_nominal');
        $sisaBudget = $sisa >= 0 ? $sisa : 0;

        return response()->json([
            'totalBudget'      => (int) $budget->sum('nominal'),
            'totalOnstanding'  => (int) $onstanding->sum('jumlah_nominal'),
            'totalOutstanding' => (int) $outstanding->sum('jumlah_nominal'),
            'sisaBudget'       => (int) $sisaBudget,
        ], 200);
    }

    /**
     * Mengambil data jenis belanja berdasarkan id akun belanja...
     * ... untuk isi select option.
     *
     * @param  int $akunBelanjaId [description]
     * @return void
     */
    public function getJenisBelanjaByAkunBelanjaId($akunBelanjaId)
    {
        $jenisBelanja = JenisBelanja::select(['id', 'akun_belanja_id', 'kategori_belanja', 'active'])
            ->where('akun_belanja_id', $akunBelanjaId)
            ->where('active', 1)
            ->get();

        $options = "<option value>-- Semua --</option>";

        foreach ($jenisBelanja as $jBelanja) {
            $options .= "<option value='{$jBelanja->id}'>{$jBelanja->kategori_belanja}</option>";
        }

        echo $options;
    }
}
