<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;

class DivisiController extends Controller
{
    /**
     * View halaman divisi
     *
     * @return view
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        
        $divisi = Divisi::where('nama_divisi', 'like', '%' . $search . '%')
            ->simplePaginate(25)
            ->withQueryString();

        return view('pages.divisi.index', compact('divisi', 'search'));
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
            'nama_divisi.required' => 'Nama divisi tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama divisi sudah digunakan.',
        ];

        // validasi
        $validate = $request->validate([
            'nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi']
        ], $validate_message);

        $validate['nama_divisi'] = ucwords($validate['nama_divisi']);

        // simpan ke database
        Divisi::create($validate);

        return redirect()->route('divisi')->with('alert', [
            'type' => 'success',
            'message' => '1 data divisi berhasil ditambahkan',
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
            'nama_divisi.required' => 'Nama divisi tidak boleh kosong.',
            'nama_divisi.max' => 'Panjang nama tidak boleh lebih dari 100 karakter.',
            'nama_divisi.unique' => 'Nama divisi sudah digunakan.',
        ];

        // validasi rules
        $validate_rules = ['nama_divisi' => ['required', 'max:100']];

        // cek apakah value dirubah atau tidak
        if ($request->nama_divisi != $divisi->nama_divisi) {
            $validate_rules = ['nama_divisi' => ['required', 'max:100', 'unique:divisi,nama_divisi']];
        }

        // validasi
        $validatedData = $request->validate($validate_rules, $validate_message);
        $validatedData['nama_divisi'] = ucwords($validatedData['nama_divisi']);

        // update ke database
        Divisi::where('id', $divisi->id)->update($validatedData);

        return redirect()->route('divisi')->with('alert', [
            'type' => 'success',
            'message' => '1 data divisi berhasil diperbarui',
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

        return redirect()->route('divisi')->with('alert', [
            'type' => 'success',
            'message' => '1 data divisi berhasil dihapus',
        ]);
    }
}
