<?php

namespace App\Http\Controllers;

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
        $query = JenisBelanja::select('id', 'kategori_belanja', 'updated_at');

        /**
         * cek jika ada request search atau tidak
         */
        if ($request->search) {
            $query->where('kategori_belanja', 'like', "%{$request->search}%")
                ->orWhere('updated_at', 'like', "%{$request->search}%");
        }

        /**
         * buat order
         */
        $query->orderBy('kategori_belanja', 'asc');

        // dd($query->get());

        /**
         * buat paginasi
         */
        $jenisBelanja = $query->paginate(1)->withQueryString();

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
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
            'kategori_belanja.unique' => 'Kategori belanja sudah digunakan.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        /**
         * simpan data ke database
         */
        try {
            JenisBelanja::create($validatedData);
        } catch (\Exception $e) {
            return redirect()->route('jenis-belanja.create')->with('alert', [
                'type' => 'danger',
                'message' => 'Gagal menambahkan data jenis belanja. ' . $e->getMessage(),
            ]);
        }

        return redirect()->route('jenis-belanja.create')->with('alert', [
            'type' => 'success',
            'message' => '1 data jenis belanja berhasil ditambahkan.',
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
        return view('pages.jenis-belanja.edit', compact('jenisBelanja'));
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
        ];


        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
        ];

        /**
         * cek apakah kategori belanja dirubah atau tidak
         */
        if ($request->kategori_belanja != $jenisBelanja->kategori_belanja) {
            array_push($validateRules['kategori_belanja'], 'unique:jenis_belanja,kategori_belanja');
            $validateErrorMessage['kategori_belanja.unique'] = 'Kategori belanja sudah digunakan.';
        }

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        /**
         * simpan data ke database
         */
        try {
            $jenisBelanja->kategori_belanja = $validatedData['kategori_belanja'];
            $jenisBelanja->save();
        } catch (\Exception $e) {
            return redirect()->route('jenis-belanja.edit', ['jenisBelanja' => $jenisBelanja->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal merubah data jenis belanja. ' . $e->getMessage(),
                ]);
        }

        return redirect()->route('jenis-belanja.edit', ['jenisBelanja' => $jenisBelanja->id])
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
        try {
            JenisBelanja::destroy($jenisBelanja->id);
        } catch (\Exception $e) {
            return redirect()
                ->route('jenis-belanja')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menghapus data jenis belanja. ' . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('jenis-belanja')
            ->with('alert', [
                'type' => 'success',
                'message' => '1 data jenis belanja berhasil dihapus.',
            ]);
    }
}
