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
        $divisi = Divisi::select('id', 'nama_divisi', 'updated_at');

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
        // pesan validasi error
        $validate_message = [
            'nama_divisi.required' => 'Nama bagian tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama bagian sudah digunakan.',
        ];

        // validasi
        $validate = $request->validate([
            'nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi']
        ], $validate_message);

        $validate['nama_divisi'] = ucwords($validate['nama_divisi']);

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
        // pesan validasi error
        $validate_message = [
            'nama_divisi.required' => 'Nama bagian tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama bagian sudah digunakan.',
        ];

        // validasi rules
        $validate_rules = ['nama_divisi' => ['required', 'max:100']];

        // cek apakah value dirubah atau tidak
        if ($request->nama_divisi != $divisi->nama_divisi) {
            $validate_rules = ['nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi']];
        }

        // validasi
        $validated_data = $request->validate($validate_rules, $validate_message);
        $validated_data['nama_divisi'] = ucwords($validated_data['nama_divisi']);

        // update ke database
        Divisi::where('id', $divisi->id)->update($validated_data);

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
        Divisi::destroy($divisi->id);

        return redirect()->route('bagian')->with('alert', [
            'type' => 'success',
            'message' => '1 data bagian berhasil dihapus',
        ]);
    }
}
