<?php

namespace App\Http\Controllers;

use App\Models\AkunBelanja;
use App\Traits\UserAccessTrait;
use Illuminate\Http\Request;

class AkunBelanjaController extends Controller
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
         * ambil data user menu akses
         */
        $userAccess = $this->getAccess(href: '/akun-belanja');

        /**
         * ambil data user sebagai admin atau tidak
         */
        $isAdmin = $this->isAdmin(href: '/akun-belanja');

        /**
         * Query akun belanja
         */
        $query = AkunBelanja::select('id', 'nama_akun_belanja', 'active', 'created_at', 'updated_at');

        /**
         * cek jika ada request pencarian
         */
        if ($request->search) {
            $query->where('nama_akun_belanja', 'like', "%{$request->search}%")
                ->orWhere('created_at', 'like', "%{$request->search}%")
                ->orWhere('updated_at', 'like', "%{$request->search}%");
        }

        /**
         * order
         */
        $query->orderBy('nama_akun_belanja', 'asc');

        /**
         * buat pagination
         */
        $akunBelanja = $query->paginate(20)->withQueryString();

        /**
         * view
         */
        return view('pages.akun-belanja.index', [
            'isAdmin' => $isAdmin,
            'userAccess' => $userAccess,
            'akunBelanja' => $akunBelanja,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.akun-belanja.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * validasi rule
         */
        $validationRules = [
            'nama_akun_belanja' => ['required', 'unique:akun_belanja,nama_akun_belanja'],
        ];

        /**
         * pesan error validasi
         */
        $validationErrorMessage = [
            'nama_akun_belanja.required' => 'Nama akun belanja harus diisi.',
            'nama_akun_belanja.unique' => 'Nama akun belanja sudah digunakan.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validationRules, $validationErrorMessage);

        try {

            /**
             * tablahkan data akun belanja baru
             */
            AkunBelanja::create([
                'nama_akun_belanja' => ucwords($request->nama_akun_belanja),
                'active' => isset($request->active) ? true : false,
            ]);
        } catch (\Exception $e) {

            /**
             * tampilkan pesan error jika proses pemanbahan data gagal
             */
            return redirect()->route('akun-belanja.create')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menambahkan akun belanja. ' . $e->getMessage(),
                ]);
        }

        /**
         * sukses
         */
        return redirect()->route('akun-belanja.create')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Akun belanja berhasil ditambahkan. ',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AkunBelanja  $akunBelanja
     * @return \Illuminate\Http\Response
     */
    public function edit(AkunBelanja $akunBelanja)
    {
        return view('pages.akun-belanja.edit', compact('akunBelanja'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AkunBelanja  $akunBelanja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AkunBelanja $akunBelanja)
    {
        /**
         * validasi rule
         */
        $validationRules = [
            'nama_akun_belanja' => ['required'],
        ];

        /**
         * cek jika akun belanja dirubah
         */
        if ($request->nama_akun_belanja != $akunBelanja->nama_akun_belanja) {
            array_push($validationRules['nama_akun_belanja'], 'unique:akun_belanja,nama_akun_belanja');
        }

        /**
         * pesan error validasi
         */
        $validationErrorMessage = [
            'nama_akun_belanja.required' => 'Nama akun belanja harus diisi.',
            'nama_akun_belanja.unique' => 'Nama akun belanja sudah digunakan.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validationRules, $validationErrorMessage);

        try {

            /**
             * update data akun belanja
             */
            $akunBelanja->nama_akun_belanja = ucwords($request->nama_akun_belanja);
            $akunBelanja->active = isset($request->active) ? true : false;
            $akunBelanja->save();
        } catch (\Exception $e) {

            /**
             * tampilkan pesan error jika proses update gagal
             */
            return redirect()->route('akun-belanja.edit', ['akunBelanja' => $akunBelanja->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal merubah akun belanja. ' . $e->getMessage(),
                ]);
        }

        /**
         * update sukses
         */
        return redirect()->route('akun-belanja')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Akun belanja berhasil dirubah. ',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AkunBelanja  $akunBelanja
     * @return \Illuminate\Http\Response
     */
    public function delete(AkunBelanja $akunBelanja)
    {
        /**
         * cek apakah ada data pada relasi dengan jenis_belanja
         */
        if (count($akunBelanja->jenisBelanja) > 0) {
            return redirect()
                ->route('akun-belanja')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "Gagal menghapus data akun belanja. Akun belanja <b>{$akunBelanja->nama_akun_belanja}</b> memiliki relasi data dengan jenis belanja. ",
                ]);
        }

        try {

            /**
             * hapus data akun belanja
             */
            AkunBelanja::destroy($akunBelanja->id);
        } catch (\Exception $e) {

            /**
             * tampilkan pesan error jika proses delete gagal
             */
            return redirect()->route('akun-belanja')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menghapus akun belanja. ' . $e->getMessage(),
                ]);
        }

        /**
         * delete sukses
         */
        return redirect()->route('akun-belanja')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Akun belanja berhasil dihapus. ',
            ]);
    }
}
