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
            ->where('href', '/bagian')
            ->first();

        return view('pages.divisi.index', [
            'divisi' => $divisi->paginate(25)->withQueryString(),
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
     *
     * @return redirect
     */
    public function store(Request $request)
    {
        // validasi rules
        $validateRules = [
            'nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi'],
            'active' => []
        ];

        // pesan validasi error
        $validate_message = [
            'nama_divisi.required' => 'Nama bagian tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama bagian sudah digunakan.',
        ];

        // validasi
        $validate = $request->validate($validateRules, $validate_message);

        $validate['nama_divisi'] = ucwords($validate['nama_divisi']);
        $validate['active'] = isset($request->active) ? true : false;

        // simpan ke database
        Divisi::create($validate);

        return redirect()->route('bagian.create')->with('alert', [
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
        // validasi rules
        $validateRules = [
            'nama_divisi' => ['required', 'max:100'],
            'active' => []
        ];

        // pesan validasi error
        $validateErrorMessage = [
            'nama_divisi.required' => 'Nama bagian tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama bagian sudah digunakan.',
        ];

        // cek apakah value dirubah atau tidak
        if ($request->nama_divisi != $divisi->nama_divisi) {
            $validateRules = ['nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi']];
        }

        // validasi
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        $validatedData['nama_divisi'] = ucwords($validatedData['nama_divisi']);
        $validatedData['active'] = isset($request->active) ? true : false;

        // update ke database
        try {
            Divisi::where('id', $divisi->id)->update($validatedData);
        } catch (\Exception $e) {
            return redirect()->route('bagian.edit', ['divisi' => $divisi->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal memperbarui data bagian. <strong>' . $e->getMessage() . '</strong>',
                ]);
        }

        return redirect()->route('bagian.edit', ['divisi' => $divisi->id])->with('alert', [
            'type' => 'success',
            'message' => 'Data bagian berhasil diperbarui',
        ]);
    }



    /**
     * Hapus data divisi
     *
     * @param Divisi $divisi
     *
     * @return redirect
     */
    public function delete(Divisi $divisi)
    {
        $relasiData = Divisi::with('user', 'jenisBelanja')->find($divisi->id);

        /**
         * cek apakah data divisi melilik data pada relasi ke user dan jenis_belanja
         */
        if (count($relasiData->user) > 0 && count($relasiData->jenisBelanja) > 0) {
            return redirect()->route('bagian')
                ->with('alert', [
                    'type' => 'warning',
                    'message' => "Gagal menghapus data. Bagian <b>{$divisi->nama_divisi}</b> memiliki relasi dengan user & akun belanja.",
                ]);
        }

        /**
         * Proses delete
         */
        try {
            Divisi::destroy($divisi->id);
        } catch (\Exception $e) {
            return redirect()->route('bagian')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menghapus data bagian. <strong>' . $e->getMessage() . '</strong>',
                ]);
        }

        return redirect()->route('bagian')->with('alert', [
            'type' => 'success',
            'message' => '1 data bagian berhasil dihapus',
        ]);
    }
}
