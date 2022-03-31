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

class BudgetController extends Controller
{
    use UserAccessTrait;

    /**
     * index
     * view halaman budget
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        /**
         * ambil data user akses untuk menu user
         */
        $userAccess = $this->getAccess(href: '/budget');

        /**
         * ambil akses menu pada user
         * jika full akses (create, read, update, delete) maka user dianggap sebagai admin
         */
        $isAdmin = $this->isAdmin(href: '/budget');

        /**
         * Periode
         */
        $periodeAwal = $request->periode_awal ?? date('Y');
        $periodeAkhir = $request->periode_akhir ?? date('Y');

        /**
         * query join table budget dengan tabel divisi dan select kolom yang diperlukan
         */
        $query = Budget::with('divisi', 'jenisBelanja.akunBelanja')
            ->whereBetween('budget.tahun_anggaran', [$periodeAwal, $periodeAkhir]);

        /**
         * cek akun belanja (jenis_belanja) di cari atau tidak
         */
        if (!empty($request->jenis_belanja)) {
            $query->whereHas(
                'jenisBelanja',
                fn (Builder $query) => $query->where(
                    'kategori_belanja',
                    $request->jenis_belanja
                )
            );
        }

        /**
         * cek apakah user sebagai admin atau tidak
         */
        if ($isAdmin) {

            /**
             * cek divisi di cari atau tidak
             */
            if (!empty($request->divisi)) {
                $query->whereHas(
                    'divisi',
                    fn (Builder $query) => $query->where(
                        'nama_divisi',
                        $request->divisi
                    )
                );
            }
        } else {

            /**
             * query berdasarkan  divisi user yang sedang login
             */
            $query->where('divisi_id', Auth::user()->divisi_id);
        }

        /**
         * Query order
         */
        $budgets = $query->orderBy('tahun_anggaran', 'desc')
            ->orderBy('budget.updated_at', 'desc')
            ->paginate(10)->withQueryString();

        /**
         * jumlah total nominal dan total sisa_nominal budget
         */
        $totalNominal = $query->sum('nominal');
        $totalSisaNominal = $query->sum('sisa_nominal');

        /**
         * ambil data bagian (divisi)
         */
        $divisi = Divisi::where('active', 1)
            ->orderBy('nama_divisi', 'asc')
            ->get();

        /**
         * ambil data akun_belanja
         */
        $akunBelanja = AkunBelanja::with('jenisBelanja')
            ->where('active', 1)
            ->orderBy('nama_akun_belanja', 'asc')
            ->get();

        /**
         * return view
         */
        return view('pages.budget.index', [
            'budgets' => $budgets,
            'divisi' => $divisi,
            'akunBelanja' => $akunBelanja,
            'totalNominal' => $totalNominal,
            'totalSisaNominal' => $totalSisaNominal,
            'userAccess' => $userAccess,
            'isAdmin' => $isAdmin,
        ]);
    }

    /**
     * detail budget per id
     *
     * @param Budget $budget
     * @return json
     */
    public function show(Budget $budget)
    {
        /**
         * ambil data budget
         */
        $data = Budget::with('divisi', 'jenisBelanja.akunBelanja', 'transaksi')
            ->find($budget->id);

        /**
         * ambil data belanja (transaksi)
         */
        $transaksi = Transaksi::with('user.profil')
            ->where('budget_id', $budget->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        /**
         * total jumlah_nominal belanja (transaksi)
         */
        $totalNominalTransaksi = Transaksi::where('budget_id', $budget->id)
            ->sum('jumlah_nominal');

        /**
         * response
         */
        return response()->json([
            'budget' => $data,
            'transaksi' => $transaksi,
            'totalNominalTransaksi' => (int) $totalNominalTransaksi,
        ], 200);
    }

    /**
     * create
     * view halman input budget
     *
     * @return void
     */
    public function create()
    {
        $divisions = Divisi::where('active', 1)->get();
        $jenisBelanja = JenisBelanja::where('active', 1)->get();

        return view('pages.budget.create', compact('divisions', 'jenisBelanja'));
    }

    /**
     * Input tambah budget
     * store
     *
     * @param Request $request
     *
     * @return redirect
     */
    public function store(Request $request)
    {
        /**
         * validasi rule
         */
        $validateRules = [
            'divisi_id' => ['required', 'exists:divisi,id'],
            'jenis_belanja_id' => ['required', 'exists:jenis_belanja,id'],
            'tahun_anggaran' => ['required', 'numeric', 'max:9999', 'min:1900'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'keterangan' => [],
        ];

        /**
         * pesan error validasi
         */
        $validateMessage = [
            'divisi_id.required' => 'Bagian harus dipilih.',
            'divisi_id.exists' => 'bagian tidak terdaftar. Pilih bagian yang telah ditentukan.',
            'jenis_belanja_id.required' => 'Akun belanja harus dipilih.',
            'jenis_belanja_id.exists' => 'Akun belanja tidak terdaftar. Pilih akun belanja yang telah ditentukan.',
            'tahun_anggaran.required' => 'Tahun anggaran tidak boleh kosong.',
            'tahun_anggaran.numeric' => 'Tahun anggaran harus bertipe numerik atau angka.',
            'tahun_anggaran.max' => 'Tahun anggaran tidak boleh lebih dari 4 digit angka.',
            'tahun_anggaran.min' => 'Tahun anggaran tidak boleh kurang dari 1900.',
            'nominal.required' => 'Nilai nominal tidak boleh kosong.',
            'nominal.numeric' => 'Nilai nominal harus bertipe numerik atau angka.',
            'nominal.min' => 'Nilai nominal tidak boleh kurang dari 0.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateMessage);

        /**
         * isi sisa_nominal sesuai nominal yang di-input.
         */
        $validatedData['sisa_nominal'] = $request->nominal;
        $validatedData['keterangan'] = $request->keterangan;

        /**
         * cek apakah divisi_id yang dipilih aktif atau tidak...
         * ...jika tidak aktif tampilkan pesan error
         */
        if (Divisi::find($request->divisi_id)->active != 1) {
            return redirect()->route('budget.create')->with('alert', [
                'type' => 'danger',
                'message' => "
                    <ul class='mt-0'>
                        <li>Bagian tidak aktif</li>
                        <li>Anda tidak bisa membuat pagu pada bagian yang tidak aktif.</li>
                    </ul>
                ",
            ]);
        }

        /**
         * cek apakah jenis_belanja_id yang dipilih aktif atau tidak...
         * ...jika tidak aktif tampilkan pesan error
         */
        if (JenisBelanja::find($request->jenis_belanja_id)->active != 1) {
            return redirect()->route('budget.create')->with('alert', [
                'type' => 'danger',
                'message' => "
                    <ul class='mt-0'>
                        <li>Akun belanja tidak aktif</li>
                        <li>Anda tidak bisa membuat pagu pada akun belanja yang tidak aktif.</li>
                    </ul>
                ",
            ]);
        }

        /**
         * ambil data budget berdasarkan divisi_id, jenis_belanja_id & tahun
         */
        $cekBudget = Budget::where([
            ['divisi_id', $request->divisi_id],
            ['jenis_belanja_id', $request->jenis_belanja_id],
            ['tahun_anggaran', $request->tahun_anggaran],
        ])->first();

        /**
         * cek apakah budget sudah pernah dibuat berdasarakan...
         * ...jenis_belanja dan di tahun yang sama
         */
        if ($cekBudget !== null) {
            return redirect()
                ->route('budget.create')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "
                        <ul class='mt-0'>
                            <li>Budget sudah dibuat.</li>
                            <li>
                                Jika anda ingin menambahkan nominal pagu pada akun belanja, bagian & tahun yang sama.
                                anda bisa melakukan edit data pada tabel budget.
                            </li>
                        </ul>
                    ",
                ]);
        }

        /**
         * simpan ke database
         */
        try {
            Budget::create($validatedData);
        } catch (\Exception $e) {
            return redirect()
                ->route('budget.create')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Pagu gagal ditambahkan. <strong>' . $e->getMessage() . '</strong>',
                ]);
        }

        /**
         * retur jika proses create sukses
         */
        return redirect()
            ->route('budget.create')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Pagu berhasil ditambahkan.',
            ]);
    }

    /**
     * View halaman edit budget
     *
     * @param Budget $budget
     * @return view
     */
    public function edit(Budget $budget)
    {
        $divisions = Divisi::where('active', 1)->get();

        return view('pages.budget.edit', compact('budget', 'divisions'));
    }

    /**
     * Update data budget
     *
     * @param Request $request
     * @param Budget $budget
     *
     * @return redirect
     */
    public function update(Request $request, Budget $budget)
    {
        /**
         * aturan validasi
         */
        $validateRules = [
            'divisi_id' => ['required', 'exists:divisi,id'],
            'jenis_belanja_id' => ['required', 'exists:jenis_belanja,id'],
            'tahun_anggaran' => ['required', 'numeric', 'max:9999', 'min:0'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'keterangan' => [],
        ];

        /**
         * pesan error validasi
         */
        $validateMessage = [
            'divisi_id.required' => 'Bagian harus dipilih.',
            'divisi_id.exists' => 'bagian tidak terdaftar. Pilih bagian yang telah ditentukan.',
            'jenis_belanja_id.required' => 'Akun belanja harus dipilih.',
            'jenis_belanja_id.exists' => 'Akun belanja tidak terdaftar. Pilih akun belanja yang telah ditentukan.',
            'tahun_anggaran.required' => 'Tahun anggaran tidak boleh kosong.',
            'tahun_anggaran.numeric' => 'Tahun anggaran harus bertipe numerik atau angka.',
            'tahun_anggaran.max' => 'Tahun anggaran tidak boleh lebih dari 4 digit angka.',
            'tahun_anggaran.min' => 'Tahun anggaran tidak boleh kurang dari 0.',
            'nominal.required' => 'Nilai nominal tidak boleh kosong.',
            'nominal.numeric' => 'Nilai nominal harus bertipe numerik atau angka.',
            'nominal.min' => 'Nilai nominal tidak boleh kurang dari 0.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateMessage);

        /**
         * masukan sisa_nominal & keterangan ke $validatedData
         */
        $validatedData['sisa_nominal'] = $budget->sisa_nominal;
        $validatedData['keterangan'] = $request->keterangan;

        /**
         * cek apakah divisi_id yang dipilih aktif atau tidak
         * jika tidak aktif tampilkan pesan error
         */
        if (Divisi::find($request->divisi_id)->active != 1) {
            return redirect()
                ->route('budget.edit', ['budget' => $budget->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => "
                        <ul class='mt-0'>
                            <li>Bagian tidak aktif</li>
                            <li>Anda tidak bisa membuat pagu pada bagian yang tidak aktif.</li>
                        </ul>
                    ",
                ]);
        }

        /**
         * cek apakah jenis_belanja_id yang dipilih aktif atau tidak
         * jika tidak aktif tampilkan pesan error
         */
        if (JenisBelanja::find($request->jenis_belanja_id)->active != 1) {
            return redirect()
                ->route('budget.edit', ['budget' => $budget->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => "
                        <ul class='mt-0'>
                            <li>Akun belanja tidak aktif</li>
                            <li>Anda tidak bisa membuat pagu pada akun belanja yang tidak aktif.</li>
                        </ul>
                    ",
                ]);
        }

        /**
         * Cek apakah divisi_id, jenis_belanja_id & tahun anggaran dirubah atau tidak
         * jika dirubah, cek apakah sudah ada budget yang dibuat sebelumnya dengan data yang sama atau tidak
         */
        if (
            $request->divisi_id != $budget->divisi_id ||
            $request->jenis_belanja_id != $budget->jenis_belanja_id ||
            $request->tahun_anggaran != $budget->tahun_anggaran
        ) {
            $cekBudget = Budget::where([
                ['divisi_id', $request->divisi_id],
                ['jenis_belanja_id', $request->jenis_belanja_id],
                ['tahun_anggaran', $request->tahun_anggaran],
            ])->first();

            /**
             * cek apakah budget sudah pernah dibuat berdasarakan jenis_belanja dan di tahun yang sama
             */
            if ($cekBudget !== null) {
                return redirect()->route('budget.edit', ['budget' => $budget->id])
                    ->with('alert', [
                        'type' => 'warning',
                        'message' => "
                            <ul class='mt-0'>
                                <li>Budget sudah dibuat.</li>
                                <li>
                                    Jika anda ingin menambahkan nominal budget pada bagian,
                                    akun belanja & ditahun yang sama dengan data pagu yang ada sebelumnya,
                                    anda bisa melakukan edit nominal.
                                </li>
                            </ul>
                    ",
                    ]);
            }
        }

        /**
         * cek nominal bertambah atau berkurang
         */
        if ($request->nominal > $budget->nominal) {
            $validatedData['sisa_nominal'] = $budget->sisa_nominal + ($request->nominal - $budget->nominal);
        } else if ($request->nominal < $budget->nominal) {
            $sisa = $budget->sisa_nominal - ($budget->nominal - $request->nominal);
            $validatedData['sisa_nominal'] = $sisa < 0 ? 0 : $sisa;
        }

        /**
         * update budget di database
         */
        try {
            Budget::where('id', $budget->id)->update($validatedData);
        } catch (\Exception $e) {
            return redirect()->route('budget.edit', ['budget' => $budget->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Pagu gagal diperbarui. ' . $e->getMessage(),
                ]);
        }

        /**
         * return jika proses update sukses
         */
        return redirect()->route('budget')->with('alert', [
            'type' => 'success',
            'message' => 'Pagu berhasil diperbarui.',
        ]);
    }

    /**
     * Hapus data budhet
     *
     * @param Budget $budget
     *
     * @return redirect
     */
    public function delete(Budget $budget)
    {
        /**
         * ambil data pada transaksi yang belasi dengan budget ini
         */
        $relasiData = Budget::with('transaksi')->find($budget->id);

        /**
         * cek apakah data divisi melilik data pada relasi ke user dan jenis_belanja
         */
        if (count($relasiData->transaksi) > 0) {
            return redirect()->route('budget')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "Penghapusan dibatalkan. Pagu yang ingin anda hapus memiliki relasi pada data <b>Realisasi</b>.",
                ]);
        }

        /**
         * Jika budget tidak memiliki data relasi pada transaksi
         * hapus budget di database
         */
        try {
            Budget::destroy($budget->id);
        } catch (\Exception $e) {
            return redirect()->route('budget')->with('alert', [
                'type' => 'danger',
                'message' => 'Pagu gagal dihapus. ' . $e->getMessage(),
            ]);
        }

        /**
         * return jika hapus budget sukses
         */
        return redirect()->route('budget')->with('alert', [
            'type' => 'success',
            'message' => '1 baris data pagu berhasil dihapus.',
        ]);
    }

    /**
     * view switch budget
     *
     * @param Budget $budget
     *
     * @return view
     */
    public function switch(Budget $budget)
    {
        $divisions = Divisi::where('active', 1)->get();

        return view('pages.budget.switch', compact('budget', 'divisions'));
    }

    /**
     * Update switch anggaran (budget)
     *
     * @param Request $request
     * @param Budget $budget
     *
     * @return Object
     */
    public function updateSwitch(Request $request, Budget $budget)
    {
        /**
         * aturan validasi
         */
        $validatedRules = [
            'divisi_id' => ['required', 'exists:divisi,id'],
            'jenis_belanja_id' => ['required', 'exists:jenis_belanja,id'],
            'tahun_anggaran' => ['required', 'numeric', 'max:9999', 'min:1900'],
            'nominal' => ['required', 'numeric', "max:{$budget->sisa_nominal}", 'min:0'],
            'keterangan' => [],
        ];

        /**
         * pesan error validasi
         */
        $validatedErrorMessage = [
            'divisi_id.required' => 'Bagian harus dipilih.',
            'divisi_id.exists' => 'Bagian tidak ada. Pilih bagian yang ditentukan.',
            'jenis_belanja_id.required' => 'Akun Belanja harus dipilih.',
            'jenis_belanja_id.exists' => 'Akun belanja tidak ada. Pilih akun belanja yang ditentukan.',
            'tahun_anggaran.required' => 'Tahun anggaran harus diisi.',
            'tahun_anggaran.numeric' => 'Tahun anggaran harus berupa tahun yang valid.',
            'tahun_anggaran.max' => 'Tahun anggaran tidak boleh lebih dari 9999.',
            'tahun_anggaran.min' => 'Tahun anggaran tidak boleh kurang dari 1900.',
            'nominal.required' => 'Jumlah nominal harus diisi.',
            'nominal.numeric' => 'Jumlah nominal berupa angka.',
            'nominal.max' => 'Jumlah nominal yang dialihkan melebihi sisa nominal budget pada akun belanja yang dipilih.',
            'nominal.min' => 'Jumlah nominal tidak boleh kurang dari 0.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validatedRules, $validatedErrorMessage);

        /**
         * cek apakah divisi_id yang dipilih aktif atau tidak
         * jika tidak aktif tampilkan pesan error
         */
        if (Divisi::find($request->divisi_id)->active != 1) {
            return redirect()->route('budget.switch', ['budget' => $budget->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => "
                        <ul class='mt-0'>
                            <li>Bagian tidak aktif</li>
                            <li>Anda tidak bisa membuat pagu pada bagian yang tidak aktif.</li>
                        </ul>
                    ",
                ]);
        }

        /**
         * cek apakah jenis_belanja_id yang dipilih aktif atau tidak
         * jika tidak aktif tampilkan pesan error
         */
        if (JenisBelanja::find($request->jenis_belanja_id)->active != 1) {
            return redirect()->route('budget.switch', ['budget' => $budget->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => "
                        <ul class='mt-0'>
                            <li>Akun belanja tidak aktif</li>
                            <li>Anda tidak bisa membuat pagu pada akun belanja yang tidak aktif.</li>
                        </ul>
                    ",
                ]);
        }

        /**
         * Proses update switch budget
         */
        try {

            /**
             * kurangi nominal & sisa_nominal pada budget yang di switch
             */
            $budget->sisa_nominal = $budget->sisa_nominal - $request->nominal;
            $budget->nominal = $budget->nominal - $request->nominal;
            $budget->save();

            /**
             * ambil data budget berdasarkan divisi_id, jenis_belanja_id & tahun_anggaran yang di-input.
             */
            $availableBudget = Budget::where([
                ['divisi_id', $request->divisi_id],
                ['jenis_belanja_id', $request->jenis_belanja_id],
                ['tahun_anggaran', $request->tahun_anggaran],
            ])->first();

            /**
             * cek $availableBudget apakah budget sudah ada atau belum
             * jika sudah ada, update nominal & sisa_nominal nya.
             * jika belum, buat buat budget baru.
             */
            if (empty($availableBudget)) {
                Budget::create([
                    'divisi_id' => $request->divisi_id,
                    'jenis_belanja_id' => $request->jenis_belanja_id,
                    'tahun_anggaran' => $request->tahun_anggaran,
                    'nominal' => $request->nominal,
                    'sisa_nominal' => $request->nominal,
                    'keterangan' => $request->keterangan,
                ]);
            } else {
                $availableBudget->nominal += $request->nominal;
                $availableBudget->sisa_nominal += $request->nominal;
                $availableBudget->keterangan .= $request->keterangan;
                $availableBudget->save();
            }
        } catch (\Exception $e) {

            /**
             * response jika proses update switch budget gagal.
             */
            return redirect()->route('budget.switch', ['budget' => $budget->id])->with('alert', [
                'type' => 'danger',
                'message' => 'Gagal melakukan switch pagu. <strong>' . $e->getMessage() . '</strong>',
            ]);
        }

        /**
         * return jika update switch budget sukses.
         */
        return redirect()->route('budget.switch', ['budget' => $budget->id])->with('alert', [
            'type' => 'success',
            'message' => 'Switch pagu berhasil dilakukan.',
        ]);
    }
}
