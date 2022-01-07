<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * custom date untuk keterangan.
     *
     * @return string
     */
    private function dateKeterangan(): string
    {
        return '<p><small>' . date('d M Y H:i') . '</small></p><hr/>';
    }

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
         * query join table budget dengan tabel divisi dan select kolom yang diperlukan
         */
        $query = Budget::leftJoin('divisi', 'divisi.id', '=', 'budget.divisi_id')
            ->leftJoin('jenis_belanja', 'jenis_belanja.id', '=', 'budget.jenis_belanja_id')
            ->select([
                'budget.id',
                'budget.tahun_anggaran',
                'budget.nominal',
                'budget.sisa_nominal',
                'budget.created_at',
                'budget.updated_at',
                'divisi.nama_divisi',
                'jenis_belanja.kategori_belanja',
            ])->whereBetween('budget.tahun_anggaran', [$request->periode_awal, $request->periode_akhir]);

        /**
         * cek divisi di cari atau tidak
         */
        if (!empty($request->divisi)) {
            $query->where('divisi.nama_divisi', $request->divisi);
        }

        /**
         * cek akun belanja (jenis_belanja) di cari atau tidak
         */
        if (!empty($request->jenis_belanja)) {
            $query->where('jenis_belanja.kategori_belanja', $request->jenis_belanja);
        }

        /**
         * Query order
         */
        $query->orderBy('budget.tahun_anggaran', 'desc')
            ->orderBy('divisi.nama_divisi', 'asc')
            ->orderBy('budget.updated_at', 'desc');

        /**
         * jumlah total nominal dan total sisa_nominal budget
         */
        $totalNominal = $query->sum('nominal');
        $totalSisaNominal = $query->sum('sisa_nominal');


        /**
         * ambil data user akses untuk menu user
         */
        $userAccess = User::with('menuItem')->find(Auth::user()->id)
            ->menuItem
            ->where('href', '/budget')
            ->first();



        /**
         * return view
         */
        return view('pages.budget.index', [
            'budgets' => $query->simplePaginate(25)->withQueryString(),
            'userAccess' => $userAccess,
            'divisi' => Divisi::all(),
            'jenisBelanja' => JenisBelanja::all(),
            'totalNominal' => $totalNominal,
            'totalSisaNominal' => $totalSisaNominal,
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
        return response()->json([
            'budget' => Budget::with('jenisBelanja', 'divisi')->find($budget->id),
        ]);
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
            'keterangan' => ['required'],
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
            'keterangan.required' => 'Keterangan harus diisi.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateMessage);

        /**
         * isi sisa_nominal sesuai nominal yang di-input.
         */
        $validatedData['sisa_nominal'] = $request->nominal;
        $validatedData['keterangan'] = $this->dateKeterangan() . $request->keterangan . '<br>';

        /**
         * ambil data budget berdasarkan divisi_id, jenis_belanja_id & tahun
         */
        $cekBudget = Budget::where([
            ['divisi_id', $request->divisi_id],
            ['jenis_belanja_id', $request->jenis_belanja_id],
            ['tahun_anggaran', $request->tahun_anggaran],
        ])->first();

        /**
         * cek apakah budget sudah pernah dibuat berdasarakan jenis_belanja dan di tahun yang sama
         */
        if ($cekBudget !== null) {
            return redirect()->route('budget.create')->with('alert', [
                'type' => 'warning',
                'message' => "
                    <ul class='mt-0'>
                        <li>Budget sudah dibuat.</li>
                        <li>Jika anda ingin menambahkan nominal budget pada akun belanja, bagian & tahun yang sama, anda bisa melakukan edit data pada tabel budget.</li>
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
            return redirect()->route('budget.create')->with('alert', [
                'type' => 'danger',
                'message' => 'Budget gagal ditambahkan. <strong>' . $e->getMessage() . '</strong>',
            ]);
        }

        /**
         * retur jika proses create sukses
         */
        return redirect()->route('budget.create')->with('alert', [
            'type' => 'success',
            'message' => 'Budget berhasil ditambahkan.',
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
        $jenisBelanja = JenisBelanja::where('active', 1)->get();

        return view('pages.budget.edit', compact('budget', 'divisions', 'jenisBelanja'));
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
            'keterangan' => ['required'],
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
            'keterangan.required' => 'Keterangan harus diisi.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateMessage);

        /**
         * masukan sisa_nominal & keterangan ke $validatedData
         */
        $validatedData['sisa_nominal'] = $budget->sisa_nominal;
        $validatedData['keterangan'] = $budget->keterangan . $this->dateKeterangan() . $request->keterangan . '<br>';

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
                                <li>Jika anda ingin menambahkan nominal budget pada bagian, akun belanja & ditahun yang sama dengan data budget yang ada sebelumnya, anda bisa melakukan edit nominal.</li>
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
                    'message' => 'Budget gagal ditambahkan. ' . $e->getMessage(),
                ]);
        }

        /**
         * return jika proses update sukses
         */
        return redirect()->route('budget')->with('alert', [
            'type' => 'success',
            'message' => 'Budget berhasil diperbarui.',
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
                    'message' => "Penghapusan dibatalkan. Budget yang ingin anda hapus memiliki relasi pada data <b>Transaksi belanja</b>.",
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
                'message' => 'Budget gagal dihapus. ' . $e->getMessage(),
            ]);
        }

        /**
         * return jika hapus budget sukses
         */
        return redirect()->route('budget')->with('alert', [
            'type' => 'success',
            'message' => '1 baris data budget berhasil dihapus.',
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
        $jenisBelanja = JenisBelanja::where('active', 1)->get();

        return view('pages.budget.switch', compact('budget', 'divisions', 'jenisBelanja'));
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
            'keterangan' => ['required'],
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
            'keterangan.required' => 'keterangan harus diisi',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validatedRules, $validatedErrorMessage);

        /**
         * Proses update switch budget
         */
        try {

            /**
             * tanggal untuk keterangan
             */
            $date = '<p><small>' . date('d M Y H:i') . '</small></p><hr/>';

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
                    'keterangan' => $this->dateKeterangan() . $request->keterangan . '<br>',
                ]);
            } else {
                $availableBudget->nominal += $request->nominal;
                $availableBudget->sisa_nominal += $request->nominal;
                $availableBudget->keterangan .= $this->dateKeterangan() . $request->keterangan . '<br>';
                $availableBudget->save();
            }
        } catch (\Exception $e) {

            /**
             * response jika proses update switch budget gagal.
             */
            return redirect()->route('budget.swith', ['budget' => $budget->id])->with('alert', [
                'type' => 'danger',
                'message' => 'Gagal melakikan switch budget. <strong>' . $e->getMessage() . '</strong>',
            ]);
        }

        /**
         * return jika update switch budget sukses.
         */
        return redirect()->route('budget')->with('alert', [
            'type' => 'success',
            'message' => 'Switch budget berhasil dilakukan.',
        ]);
    }
}
