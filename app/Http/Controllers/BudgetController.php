<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BudgetController extends Controller
{
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
         * query join table budget dengan tabel divisi
         */
        $budgets = Budget::leftJoin('jenis_belanja', 'budget.jenis_belanja_id', '=', 'jenis_belanja.id')
            ->leftJoin('divisi', 'divisi.id', '=', 'jenis_belanja.divisi_id');

        /**
         * cek apakah ada request search atau tidak
         */
        if ($request->search) {
            $budgets->where('budget.tahun_anggaran', 'like', "%{$request->search}%")
                ->orWhere('budget.nominal', 'like', "%{$request->search}%")
                ->orWhere('budget.updated_at', 'like', "%{$request->search}%")
                ->orWhere('jenis_belanja.kategori_balanja', 'like', "%{$request->search}%")
                ->orWhere('divisi.nama_divisi', 'like', "%{$request->search}%");
        }

        /**
         * query select kolom yang akan ditampilkan
         */
        $budgets->select(
            'budget.id',
            'budget.tahun_anggaran',
            'budget.nominal',
            'budget.updated_at',
            'jenis_belanja.kategori_belanja',
            'divisi.nama_divisi',
        )->orderBy('budget.tahun_anggaran', 'desc')
            ->orderBy('budget.updated_at', 'desc');

        /**
         * ambid data user akses untuk menu user
         */
        $userAccess = User::with('menuItem')->find(Auth::user()->id)
            ->menuItem
            ->where('href', '/budget')
            ->first();

        return view('pages.budget.index', [
            'budgets' => $budgets->paginate(25)->withQueryString(),
            'userAccess' => $userAccess,
        ]);
    }

    /**
     * detail budget per id
     *
     * @param Budget $budget
     *
     * @return json
     */
    public function show(Budget $budget)
    {
        return response()->json([
            'budget' => Budget::with('jenisBelanja.divisi')->find($budget->id),
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
        /**
         * Ambil semua data divisi dan jenisBelanja
         */
        $divisions = Divisi::with('jenisBelanja')
            ->where('active', 1)
            ->get();

        return view('pages.budget.create', compact('divisions'));
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
         * aturan validasi
         */
        $validateRules = [
            'jenis_belanja_id' => ['required', 'exists:jenis_belanja,id'],
            'tahun_anggaran' => ['required', 'numeric', 'max:9999', 'min:1900'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'keterangan' => [],
        ];

        /**
         * pesan error validasi
         */
        $validateMessage = [
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
        /**
         * Ambil semua data divisi
         */
        $divisions = Divisi::with('jenisBelanja')
            ->where('active', 1)
            ->get();

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
            'jenis_belanja_id' => ['required', 'exists:jenis_belanja,id'],
            'tahun_anggaran' => ['required', 'numeric', 'max:9999', 'min:0'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'keterangan' => [],
        ];

        /**
         * pesan error validasi
         */
        $validateMessage = [
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
         * update budget di database
         */
        try {
            Budget::where('id', $budget->id)->update($validatedData);
        } catch (\Exception $e) {
            return redirect()->route('budget.edit', ['budget' => $budget->id])->with('alert', [
                'type' => 'danger',
                'message' => 'Budget gagal ditambahkan. <strong>' . $e->getMessage() . '</strong>',
            ]);
        }

        return redirect()->route('budget.edit', ['budget' => $budget->id])->with('alert', [
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
        $divisions = Divisi::with('jenisBelanja')->get();
        return view('pages.budget.switch', compact('budget', 'divisions'));
    }

    /**
     * datatables
     *
     * @return JSON
     */
    public function getDatatable($id)
    {
        $budgets = Budget::with('jenisBelanja.divisi')
            ->where('id', '!=', $id)
            ->get();

        return DataTables::of($budgets)
            ->addColumn('pilih', fn ($data) => $data)
            ->setRowClass('row-clicked')
            ->setRowData(['id' => 'test'])
            ->setRowAttr(function ($budget) {
                return [
                    'data-id' => $budget->id
                ];
            })
            ->make(true);
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
            'id' => ['required', 'exists:budget,id'],
            'jenis_belanja' => ['required'],
            'tahun_anggaran' => ['required', 'numeric', 'max:9999', 'min:1900'],
            'nominal' => ['required', 'numeric', "max:{$budget->nominal}", 'min:0'],
        ];

        /**
         * pesan error validasi
         */
        $validatedErrorMessage = [
            'jenis_belanja.required' => 'Akun Belanja harus diisi.',
            'tahun_anggaran.required' => 'Tahun anggaran harus diisi.',
            'tahun_anggaran.numeric' => 'Tahun anggaran harus berupa tahun yang valid.',
            'tahun_anggaran.max' => 'Tahun anggaran tidak boleh lebih dari 9999.',
            'tahun_anggaran.min' => 'Tahun anggaran tidak boleh kurang dari 1900.',
            'nominal.required' => 'Jumlah nominal harus diisi.',
            'nominal.numeric' => 'Jumlah nominal berupa angka.',
            'nominal.max' => 'Jumlah nominal yang dialihkan melebihi jumlah budget pada akun belanja yang dipilih.',
            'nominal.min' => 'Jumlah nominal tidak boleh kurang dari 0.'
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validatedRules, $validatedErrorMessage);

        /**
         * ambil data budget saat ini
         */
        $currentBudget = Budget::find($request->id);

        try {

            /**
             * update budget tujuan
             */
            $currentBudget->nominal = $currentBudget->nominal + (int) $request->nominal;
            $currentBudget->keterangan = $request->keterangan;
            $currentBudget->save();

            /**
             * update budget dari
             */
            $budget->nominal = $budget->nominal - (int) $request->nominal;
            $budget->save();
        } catch (\Exception $e) {
            return redirect()->route('budget.swith', ['budget' => $budget->id])->with('alert', [
                'type' => 'danger',
                'message' => 'Gagal melakikan switch budget. <strong>' . $e->getMessage() . '</strong>',
            ]);
        }

        return redirect()->route('budget')->with('alert', [
            'type' => 'success',
            'message' => 'Switch budget berhasil dilakukan.',
        ]);
    }
}
