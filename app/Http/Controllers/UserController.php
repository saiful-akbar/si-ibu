<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * View halaman user
     *
     * @param  Request $request [description]
     * @return view
     */
    public function index(Request $request)
    {
        $users = User::leftJoin('profil', 'user.id', '=', 'profil.user_id')
            ->leftJoin('divisi', 'user.divisi_id', '=', 'divisi.id')
            ->leftJoin('role', 'user.role_id', '=', 'role.id');

        if ($request->search) {
            $users->where('user.username', 'like', '%' . $request->search . '%')
                ->orWhere('profil.nama_lengkap', 'like', '%' . $request->search . '%')
                ->orWhere('divisi.nama_divisi', 'like', '%' . $request->search . '%')
                ->orWhere('role.level', 'like', '%' . $request->search . '%');
        }

        $users->select(
            'user.id',
            'user.username',
            'user.active',
            'user.updated_at',
            'user.created_at',
            'profil.avatar',
            'profil.nama_lengkap',
            'divisi.nama_divisi',
            'role.level',
        );

        return view('pages.user.index', [
            'users' => $users->simplePaginate(25)->withQueryString()
        ]);
    }

    /**
     * View halaman tambah user
     *
     * @return view
     */
    public function create()
    {
        $divisions = Divisi::all();
        $roles = Role::all();

        return view('pages.user.create', compact('divisions', 'roles'));
    }

    /**
     * Tambah data user baru
     *
     * @param Request $request
     *
     * @return redirect
     */
    public function store(Request $request)
    {
        // valisadi rules
        $validasi_rules = [
            'username'     => ['required', 'unique:user,username', 'max:100'],
            'password'     => ['required', 'min:4', 'max:200'],
            'avatar'       => ['image', 'max:1000'],
            'nama_lengkap' => ['required', 'max:100'],
            'divisi_id'    => ['required', 'exists:divisi,id'],
            'role_id'      => ['required', 'exists:role,id'],
        ];

        // pesan error validasi
        $validate_message = [
            'username.required'     => 'Username harus diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'username.max'          => 'Username tidak boleh lebih dari 100 karakter.',
            'password.required'     => 'Password harus diisi.',
            'password.min'          => 'Password minimal 4 karakter.',
            'password.max'          => 'Password tidak boleh lebih dari 200 karakter.',
            'avatar.image'          => 'Avatar harus berupa file gambar.',
            'avatar.max'            => 'Ukuran avatar tidak boleh lebih besar dari 1000 kilobytes',
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'nama_lengkap.max'      => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
            'divisi_id.required'    => 'Divisi harus dipilih.',
            'divisi_id.exists'      => 'Divisi tidak terdaftar. Anda harus memilih divisi yang telah ditentukan.',
            'role_id.required'      => 'Role level harus dipilih.',
            'divisi_id.exists'      => 'Role level tidak terdaftar. Anda harus memilih role level yang telah ditentukan.',
        ];

        // jalankan validadi request
        $request->validate($validasi_rules, $validate_message);

        // cek user aktif atau tidak
        $user_active = isset($request->active) ? true : false;
        $avatar = null;

        // cek avatar di upload atau tidak
        // jika di upload simpan pada storage
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // simpan data user ke database
        $user = User::create([
            'role_id' => $request->role_id,
            'divisi_id' => $request->divisi_id,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'active' => $user_active,
        ]);

        // simpan data profil
        $user->profil()->create([
            'avatar' => $avatar,
            'nama_lengkap' => ucwords($request->nama_lengkap),
        ]);

        return redirect()->route('user')->with('alert', [
            'type' => 'success',
            'message' => '1 user berhasil ditambahkan',
        ]);
    }
}
