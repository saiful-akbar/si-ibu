<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisiController extends Controller
{
    /**
     * View halaman divisi
     *
     * @return view
     */
    public function index(Request $request)
    {
        $divisi = Divisi::select('id', 'nama_divisi', 'active', 'updated_at');

        if ($request->search) {
            $divisi->where('nama_divisi', 'like', '%' . $request->search . '%');
        }

        $divisi->orderBy('nama_divisi', 'asc');

        /**
         * ambid data user akses untuk menu divisi
         */
        $user_akses = User::with('menuItem')->find(Auth::user()->id)
            ->menuItem
            ->where('href', '/divisi')
            ->first();

        return view('pages.divisi.index', [
            'divisi' => $divisi->simplePaginate(25)->withQueryString(),
            'user_akses' => $user_akses
        ]);
    }



    /**
     * View halaman create divisi
     *
     * @return view
     */
    public function create()
    {
        return view('pages.divisi.create');
    }



    /**
     * Membuat atau menambah data divisi baru
     *
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request)
    {
        /**
         * validasi rules
         * @var array
         */
        $validateRules = [
            'nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi'],
            'active' => []
        ];

        /**
         * pesan validasi error
         * @var array
         */
        $validate_message = [
            'nama_divisi.required' => 'Nama bagian tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama bagian sudah digunakan.',
        ];

        /**
         * Jalankan validasi
         * @var array
         */
        $validate = $request->validate($validateRules, $validate_message);

        $validate['nama_divisi'] = ucwords($validate['nama_divisi']);
        $validate['active'] = isset($request->active) ? true : false;

        /**
         * Tambahkan ke database.
         */
        Divisi::create($validate);

        return redirect()->route('divisi.create')->with('alert', [
            'type' => 'success',
            'message' => '1 data bagian berhasil ditambahkan',
        ]);
    }



    /**
     * View form edit data divisi
     *
     * @param Divisi $divisi
     *
     * @return view
     */
    public function edit(Divisi $divisi)
    {
        return view('pages.divisi.edit', compact('divisi'));
    }



    /**
     * Update data divisi
     *
     * @param Request $request
     * @param Divisi $divisi
     *
     * @return redirect
     */
    public function update(Request $request, Divisi $divisi)
    {
        /**
         * validasi rules
         * @var array
         */
        $validateRules = [
            'nama_divisi' => ['required', 'max:100'],
            'active' => []
        ];

        /**
         * pesan validasi error
         * @var array
         */
        $validateErrorMessage = [
            'nama_divisi.required' => 'Nama bagian tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama bagian sudah digunakan.',
        ];

        /**
         * cek nama_divisi dirubah atau tidak
         * jika dirubah tambahkan validasi rule untuk nama_divisi
         */
        if ($request->nama_divisi != $divisi->nama_divisi) {
            $validateRules = ['nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi']];
        }

        /**
         * Jalankan validasi
         * @var array
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        $validatedData['nama_divisi'] = ucwords($validatedData['nama_divisi']);
        $validatedData['active'] = isset($request->active) ? true : false;

        try {

            /**
             * Update ke database
             */
            Divisi::where('id', $divisi->id)->update($validatedData);
        } catch (\Exception $e) {

            /**
             * Return jika proses update gagal.
             */
            return redirect()->route('divisi.edit', ['divisi' => $divisi->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal memperbarui data bagian. <strong>' . $e->getMessage() . '</strong>',
                ]);
        }

        /**
         * return jika proses update berhasil.
         */
        return redirect()->route('divisi')->with('alert', [
            'type' => 'success',
            'message' => 'Data bagian berhasil diperbarui',
        ]);
    }



    /**
     * Hapus data divisi
     *
     * @param Divisi $divisi
     * @return redirect
     */
    public function delete(Divisi $divisi)
    {
        $relasiData = Divisi::with('user', 'budget')->find($divisi->id);

        /**
         * cek apakah data divisi melilik data pada relasi ke user dan jenis_belanja
         * jika ada batalkan proses hapus.
         */
        if (count($relasiData->user) > 0 || count($relasiData->budget) > 0) {
            return redirect()->route('divisi')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "Gagal menghapus data. Bagian <b>{$divisi->nama_divisi}</b> memiliki data relasi dengan user & budget.",
                ]);
        }

        /**
         * Proses delete
         */
        try {
            Divisi::destroy($divisi->id);
        } catch (\Exception $e) {
            return redirect()->route('divisi')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menghapus data bagian. <strong>' . $e->getMessage() . '</strong>',
                ]);
        }

        /**
         * Return jika proses delete sukses.
         */
        return redirect()->route('divisi')->with('alert', [
            'type' => 'success',
            'message' => '1 data bagian berhasil dihapus',
        ]);
    }
}
