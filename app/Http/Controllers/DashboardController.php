<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\Transaksi;
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
        if (
            $authUser->create == 1 &&
            $authUser->read == 1 &&
            $authUser->update == 1 &&
            $authUser->delete == 1
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
         * ambil data jenis_belanja berdasarkan belanja (transaksi) yang pernah dilakukan bagian (divisi)
         */
        $jenisBelanja = JenisBelanja::leftJoin('budget', 'budget.jenis_belanja_id', '=', 'jenis_belanja.id')
            ->where('budget.divisi_id', Auth::user()->divisi->id)
            ->select('jenis_belanja.id', 'jenis_belanja.kategori_belanja')
            ->get();

        /**
         * looping data akun belanja (jenis_belanja)
         */
        foreach ($jenisBelanja as $keyJenisBelanja => $valueJenisBelanja) {
            $data[$keyJenisBelanja]['name'] = $valueJenisBelanja->kategori_belanja;

            foreach ($bulan as $valueBulan) {
                $data[$keyJenisBelanja]['data'][] = (int) Transaksi::leftJoin('budget', 'budget.id', '=', 'transaksi.budget_id')
                    ->where('transaksi.tanggal', 'like', "{$year}-{$valueBulan}%")
                    ->where('budget.jenis_belanja_id', $valueJenisBelanja->id)
                    ->where('budget.divisi_id', Auth::user()->divisi->id)
                    ->sum('transaksi.jumlah_nominal');
            }
        }

        return response()->json([
            'data' => $data,
        ], 200);
    }

    /**
     * Chat admin per jenis_belanja
     *
     * @param mixed $jenisBelanjaId
     * @param int $periode
     *
     * @return json
     */
    public function chartPiePerJenisBelanja($jenisBelanjaId, int $periode)
    {
        /**
         * Ambil semua data bagian (divisi)
         */
        $divisi = Divisi::select('id', 'nama_divisi')
            ->where('active', 1)
            ->orderBy('nama_divisi', 'asc')
            ->get();

        /**
         * buat data kosong
         */
        $data = [];

        /**
         * cek $jenisBelanjaId = all atau sesuai id jenis_belanja
         */
        if ($jenisBelanjaId == 'all') {
            foreach ($divisi as $div) {
                $data['labels'][] = $div->nama_divisi;
                $data['series'][] = (int) Transaksi::leftJoin('budget', 'budget.id', '=', 'transaksi.budget_id')
                    ->where('budget.divisi_id', $div->id)
                    ->where('transaksi.tanggal', 'like', "%{$periode}%")
                    ->sum('transaksi.jumlah_nominal');
            }

            /**
             * buat total nominal (budget) semua akun belanja (jenis_belanja)
             */
            $data['totalBelanja'] = (int) Transaksi::where('transaksi.tanggal', 'like', "%{$periode}%")->sum('jumlah_nominal');
        } else {
            foreach ($divisi as $div) {
                $data['labels'][] = $div->nama_divisi;
                $data['series'][] = (int) Transaksi::leftJoin('budget', 'budget.id', '=', 'transaksi.budget_id')
                    ->where('budget.divisi_id', $div->id)
                    ->where('budget.jenis_belanja_id', $jenisBelanjaId)
                    ->where('transaksi.tanggal', 'like', "%{$periode}%")
                    ->sum('transaksi.jumlah_nominal');
            }

            /**
             * buat total nominal (budget) berdasarkan akun belanja (jenis_belanja)
             */
            $data['totalBelanja'] = (int) Transaksi::leftJoin('budget', 'budget.id', '=', 'transaksi.budget_id')
                ->where('transaksi.tanggal', 'like', "%{$periode}%")
                ->where('budget.jenis_belanja_id', $jenisBelanjaId)
                ->sum('jumlah_nominal');
        }


        return response()->json([
            'data' => $data,
        ], 200);
    }
}
