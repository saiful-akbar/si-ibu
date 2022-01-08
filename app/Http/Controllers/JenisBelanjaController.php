<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * ambil semua data jenis_belanja
         */
        $query = JenisBelanja::select('id', 'kategori_belanja', 'active', 'created_at', 'updated_at');

        /**
         * cek jika ada request search atau tidak
         */
        if ($request->search) {
            $query->where('kategori_belanja', 'like', "%{$request->search}%")
                ->orWhere('updated_at', 'like', "%{$request->search}%");
        }

        /**
         * buat paginasi
         */
        $jenisBelanja = $query
            ->orderBy('kategori_belanja', 'asc')
            ->simplePaginate(25)
            ->withQueryString();

        /**
         * ambid data user akses untuk menu divisi
         */
        $userAccess = User::with('menuItem')->find(Auth::user()->id)
            ->menuItem
            ->where('href', '/jenis-belanja')
            ->first();

        return view('pages.jenis-belanja.index', compact('jenisBelanja', 'userAccess'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.jenis-belanja.create');
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
            'kategori_belanja' => ['required', 'max:100', 'unique:jenis_belanja,kategori_belanja'],
            'active' => []
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
            'kategori_belanja.unique' => 'Kategori belanja sudah ada.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);
        $validatedData['kategori_belanja'] = ucwords($request->kategori_belanja);
        $validatedData['active'] = isset($request->active) ? true : false;

        /**
         * simpan data ke database
         */
        try {
            JenisBelanja::create($validatedData);
        } catch (\Exception $e) {
            return redirect()->route('jenis-belanja.create')->with('alert', [
                'type' => 'danger',
                'message' => 'Akun belanja gagal ditambahkan. ' . $e->getMessage(),
            ]);
        }

        return redirect()->route('jenis-belanja.create')->with('alert', [
            'type' => 'success',
            'message' => '1 akun jenis belanja berhasil ditambahkan.',
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
        $divisions = Divisi::where('active', 1)->get();

        return view('pages.jenis-belanja.edit', compact('jenisBelanja', 'divisions'));
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
            'kategori_belanja' => ['required', 'max:100'],
            'active' => ['boolean']
        ];


        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
            'kategori_belanja.unique' => 'Kategori belanja sudah ada.',
            'active.boolean' => 'Active harus bernilai true (1) atau false (0).',
        ];

        /**
         * cek kategori belanja dirubah atau tidak
         * tambahkan validasi unique
         */
        if ($request->kategori_belanja != $jenisBelanja->kategori_belanja) {
            array_push($validateRules['kategori_belanja'], 'unique:jenis_belanja,kategori_belanja');
        }

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        $validatedData['kategori_belanja'] = ucwords($request->kategori_belanja);
        $validatedData['active'] = isset($request->active) ? true : false;

        /**
         * simpan data ke database
         */
        try {
            $jenisBelanja->update($validatedData);
        } catch (\Exception $e) {
            return redirect()->route('jenis-belanja.edit', ['jenisBelanja' => $jenisBelanja->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal merubah data jenis belanja. ' . $e->getMessage(),
                ]);
        }

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
        $relasiData = JenisBelanja::with('budget')->find($jenisBelanja->id);

        /**
         * cek apakah ada data transaksi & budget yang berelasi dengan jenis_belanja ini
         */
        if (count($relasiData->budget) > 0) {
            return redirect()
                ->route('jenis-belanja')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "Gagal menghapus data akun belanja {$jenisBelanja->divisi->nama_divisi}-{$jenisBelanja->kategori_belanja}. Data akun belanja ini memiliki data relasi dengan budget. ",
                ]);
        }

        /**
         * Proses hapus
         */
        try {
            JenisBelanja::destroy($jenisBelanja->id);
        } catch (\Exception $e) {
            return redirect()
                ->route('jenis-belanja')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menghapus data akun belanja. ' . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('jenis-belanja')
            ->with('alert', [
                'type' => 'success',
                'message' => '1 akun belanja berhasil dihapus.',
            ]);
    }
}
