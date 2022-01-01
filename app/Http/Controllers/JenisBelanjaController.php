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
        $query = JenisBelanja::leftJoin('divisi', 'jenis_belanja.divisi_id', '=', 'divisi.id')
            ->select(
                'jenis_belanja.id',
                'jenis_belanja.kategori_belanja',
                'jenis_belanja.active',
                'jenis_belanja.updated_at',
                'divisi.nama_divisi'
            );

        /**
         * cek jika ada request search atau tidak
         */
        if ($request->search) {
            $query->where('jenis_belanja.kategori_belanja', 'like', "%{$request->search}%")
                ->orWhere('jenis_belanja.updated_at', 'like', "%{$request->search}%")
                ->orWhere('divisi.nama_divisi', 'like', "%{$request->search}%");
        }

        /**
         * buat order
         */
        $query->orderBy('divisi.nama_divisi', 'asc')
            ->orderBy('jenis_belanja.kategori_belanja', 'asc');

        /**
         * buat paginasi
         */
        $jenisBelanja = $query->paginate(25)->withQueryString();

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
        $divisions = Divisi::where('active', 1)->get();

        return view('pages.jenis-belanja.create', compact('divisions'));
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
            'kategori_belanja' => ['required', 'max:100'],
            'divisi_id' => ['required', 'exists:divisi,id'],
            'active' => []
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
            'kategori_belanja.unique' => 'Kategori belanja sudah digunakan.',
            'divisi_id.required' => 'Bagian harus dipilih.',
            'divisi_id.exists' => 'Bagian tidak terdaftar. Pilih bagian yang sudah ditentukan.',
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
            'divisi_id' => ['required', 'exists:divisi,id'],
            'active' => []
        ];


        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'kategori_belanja.required' => 'Kategori belanja tidak boleh kosong.',
            'kategori_belanja.max' => 'Kategori belanja tidak boleh lebih dari 100 karakter.',
            'divisi_id.required' => 'Bagian harus dipilih.',
            'divisi_id.exists' => 'Bagian tidak terdaftar. Pilih bagian yang sudah ditentukan.',
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
            $jenisBelanja->update($validatedData);
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
        $relasiData = JenisBelanja::with('budget', 'transaksi')->find($jenisBelanja->id);

        /**
         * cek apakah ada data transaksi & budget yang berelasi dengan jenis_belanja ini
         */
        if (count($relasiData->budget) > 0 && count($relasiData->transaksi) > 0) {
            return redirect()
                ->route('jenis-belanja')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "Gagal menghapus data akun belanja {$jenisBelanja->divisi->nama_divisi}-{$jenisBelanja->kategori_belanja}. Data akun belanja ini memiliki data relasi dengan budget & transaksi belanja. ",
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
                'message' => '1 data akun belanja berhasil dihapus.',
            ]);
    }
}
