<?php

namespace App\Http\Controllers;

use App\Models\AkunBelanja;
use App\Models\JenisBelanja;
use App\Traits\UserAccessTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisBelanjaController extends Controller
{
    use UserAccessTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * ambid data user akses untuk menu divisi
         */
        $userAccess = $this->getAccess(href: '/akun-belanja');

        /**
         * cek user sebagai admin atau bukan
         */
        $isAdmin = $this->isAdmin(href: '/akun-belanja');

        /**
         * ambil semua data jenis_belanja
         */
        $query = JenisBelanja::with('akunBelanja');

        /**
         * cek jika ada request search atau tidak
         */
        if ($request->search) {
            $query->where('kategori_belanja', 'like', "%{$request->search}%")
                ->orWhere('updated_at', 'like', "%{$request->search}%")
                ->OrwhereHas('akunBelanja', function (Builder $query) use ($request) {
                    $query->where('nama_akun_belanja', 'like', "%{$request->search}%");
                });
        }

        /**
         * buat paginasi
         */
        $jenisBelanja = $query->orderBy('updated_at', 'desc')
            ->orderBy('kategori_belanja', 'asc')
            ->simplePaginate(10)
            ->withQueryString();

        return view('pages.jenis-belanja.index', compact('jenisBelanja', 'userAccess', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $akunBelanja = AkunBelanja::where('active', 1)->get();

        return view('pages.jenis-belanja.create', compact('akunBelanja'));
    }

    /**
     * Tambah data baru jenis belanja
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * validasi rule
         */
        $validateRules = [
            'akun_belanja_id' => ['required', 'exists:akun_belanja,id'],
            'kategori_belanja' => ['required', 'max:100'],
            'active' => []
        ];

        /**
         * cek apakah data dengan kategori_belanja & akun_belanja_id yang di request sudah ada atau belum
         */
        $duplicate = JenisBelanja::where([
            ['akun_belanja_id', $request->akun_belanja_id],
            ['kategori_belanja', $request->kategori_belanja],
        ])->first();

        if ($duplicate) {
            array_push($validateRules['kategori_belanja'], 'unique:jenis_belanja,kategori_belanja');
        }

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'akun_belanja_id.required' => 'Akun belanja harus dipilih.',
            'akun_belanja_id.exists' => 'Akun belanja tidak terdaftar. Silakan pilih akun belanja yang sudah ditentukan.',
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
            'kategori_belanja.unique' => 'Kategori belanja sudah digunakan.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        try {

            /**
             * simpan data ke database
             */
            JenisBelanja::create([
                'akun_belanja_id' => $request->akun_belanja_id,
                'kategori_belanja' => ucfirst($request->kategori_belanja),
                'active' => isset($request->active) ? true : false,
            ]);
        } catch (\Exception $e) {

            /**
             * tampilkan pesan error jika proses tambah gagal
             */
            return redirect()->route('jenis-belanja.create')->with('alert', [
                'type' => 'danger',
                'message' => 'Gagal menambahkan data jenis belanja. ' . $e->getMessage(),
            ]);
        }

        /**
         * tambah sukses
         */
        return redirect()->route('jenis-belanja.create')->with('alert', [
            'type' => 'success',
            'message' => 'Jenis belanja berhasil ditambahkan.',
        ]);
    }

    /**
     * edit
     * view halaman edit data jenis belanja
     *
     * @param JenisBelanja $jenisBelanja
     * @return view
     */
    public function edit(JenisBelanja $jenisBelanja)
    {
        $akunBelanja = AkunBelanja::where('active', 1)->get();

        return view('pages.jenis-belanja.edit', compact('jenisBelanja', 'akunBelanja'));
    }

    /**
     * update data jenis belanja
     *
     * @param Request $request
     * @param JenisBelanja $jenisBelanja
     *
     * @return redirect
     */
    public function update(Request $request, JenisBelanja $jenisBelanja)
    {
        /**
         * validasi rule
         */
        $validateRules = [
            'akun_belanja_id' => ['required', 'exists:akun_belanja,id'],
            'kategori_belanja' => ['required', 'max:100'],
            'active' => ['boolean']
        ];

        /**
         * cek jika kategori_belanja dirubah
         */
        if (
            $request->akun_belanja_id != $jenisBelanja->akun_belanja_id ||
            $request->kategori_belanja != $jenisBelanja->kategori_belanja
        ) {
            /**
             * cek apakah data dengan kategori_belanja & akun_belanja_id yang di request sudah ada atau belum
             */
            $duplicate = JenisBelanja::where([
                ['akun_belanja_id', $request->akun_belanja_id],
                ['kategori_belanja', $request->kategori_belanja],
            ])->first();

            if ($duplicate) {
                array_push($validateRules['kategori_belanja'], 'unique:jenis_belanja,kategori_belanja');
            }
        }

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'akun_belanja_id.required' => 'Akun belanja harus dipilih.',
            'akun_belanja_id.exists' => 'Akun belanja tidak terdaftar. Silakan pilih akun belanja yang sudah ditentukan.',
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
            'kategori_belanja.unique' => 'Kategori belanja sudah ada.',
            'active.boolean' => 'Active harus bernilai true (1) atau false (0).',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        try {

            /**
             * update data ke database
             */
            $jenisBelanja->update([
                'akun_belanja_id' => $request->akun_belanja_id,
                'kategori_belanja' => ucfirst($request->kategori_belanja),
                'active' => isset($request->active) ? true : false,
            ]);
        } catch (\Exception $e) {

            /**
             * tampilkan pesan error jika proses update gagal
             */
            return redirect()->route('jenis-belanja.edit', ['jenisBelanja' => $jenisBelanja->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal merubah data jenis belanja. ' . $e->getMessage(),
                ]);
        }

        /**
         * update sukses
         */
        return redirect()->route('jenis-belanja')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Data jenis belanja berhasil dirubah.',
            ]);
    }

    /**
     * hapus data kategori belanja
     *
     * @param JenisBelanja $jenisBelanja
     *
     * @return redirect
     */
    public function delete(JenisBelanja $jenisBelanja)
    {
        /**
         * cek apakah ada data transaksi & budget yang berelasi dengan jenis_belanja ini
         */
        if (count($jenisBelanja->budget) > 0) {
            return redirect()
                ->route('jenis-belanja')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "Gagal menghapus data jenis belanja. <b>{$jenisBelanja->kategori_belanja}</b> memiliki data relasi pada budget. ",
                ]);
        }

        try {

            /**
             * Proses hapus
             */
            JenisBelanja::destroy($jenisBelanja->id);
        } catch (\Exception $e) {

            /**
             * tampilkan pesan error jika proses delete gagal
             */
            return redirect()
                ->route('jenis-belanja')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menghapus data jenis belanja. ' . $e->getMessage(),
                ]);
        }

        /**
         * delete sukses
         */
        return redirect()
            ->route('jenis-belanja')
            ->with('alert', [
                'type' => 'success',
                'message' => '1 data jenis belanja berhasil dihapus.',
            ]);
    }

    /**
     * modal datatable
     */
    public function dataTable()
    {
        $jenisBelanja = JenisBelanja::with('akunBelanja')
            ->where('active', 1)
            ->whereHas('akunBelanja', fn (Builder $query) => $query->where('active', 1))
            ->get();

        return DataTables::of($jenisBelanja)
            ->addColumn('action', function ($data) {
                return "
                    <button
                        onclick='budget.setValueAkunBelanja({$data->id}, \"{$data->akunBelanja->nama_akun_belanja}\", \"{$data->kategori_belanja}\")'
                        class='btn btn-sm btn-success btn-rounded btn-sm'
                    >
                        <i class='mdi mdi-hand-pointing-up mr-1'></i>
                        <span>Pilih</span>
                    </button>
                ";
            })->make(true);
    }
}
