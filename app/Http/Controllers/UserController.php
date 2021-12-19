<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\MenuHeader;
use App\Models\MenuItem;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        /**
         * query join tabel user dengan tabel profil, divisi
         *
         * @var object
         */
        $users = User::leftJoin('profil', 'user.id', '=', 'profil.user_id')
            ->leftJoin('divisi', 'user.divisi_id', '=', 'divisi.id');

        /**
         * cek apakah ada request pencarian atau tidak
         * jika ada tambahkan query where like.
         */
        if ($request->search) {
            $users->where('user.username', 'like', '%' . $request->search . '%')
                ->orWhere('profil.nama_lengkap', 'like', '%' . $request->search . '%')
                ->orWhere('divisi.nama_divisi', 'like', '%' . $request->search . '%');
        }

        /**
         * query select untuk kolom yang ingin diambil
         */
        $users->select(
            'user.id',
            'user.username',
            'user.active',
            'user.updated_at',
            'user.created_at',
            'profil.avatar',
            'profil.nama_lengkap',
            'divisi.nama_divisi',
        )->orderBy('user.username', 'asc');

        /**
         * ambid data user akses untuk menu user
         */
        $user_akses = User::with('menuItem')->find(Auth::user()->id)
            ->menuItem
            ->where('nama_menu', 'user')
            ->first();

        /**
         * view halaman user.
         */
        return view('pages.user.index', [
            'users' => $users->simplePaginate(25)->withQueryString(),
            'user_akses' => $user_akses,
        ]);
    }



    /**
     * View halaman tambah user
     *
     * @return view
     */
    public function create()
    {
        /**
         * ambil semua data divisi
         *
         * @var object
         */
        $divisions = Divisi::all();

        return view('pages.user.create', compact('divisions'));
    }



    /**
     * store
     * Tambah data user baru
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        /**
         * valisadi rules
         *
         * @var array
         */
        $validasi_rules = [
            'username'     => ['required', 'unique:user,username', 'max:100'],
            'password'     => ['required', 'min:4', 'max:200'],
            'avatar'       => ['image', 'max:1000'],
            'nama_lengkap' => ['required', 'max:100'],
            'divisi_id'    => ['required', 'exists:divisi,id'],
        ];

        /**
         * pesan error validasi
         *
         * @var array
         */
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
        ];

        /**
         * jalankan validadi request
         */
        $request->validate($validasi_rules, $validate_message);

        /**
         * set value awal user aktif & avatar
         */
        $user_active = isset($request->active) ? true : false;
        $avatar = null;

        /**
         * cek avatar di upload atau tidak
         * jika di upload simpan pada storage
         */
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('avatars', 'public');
        }

        /**
         * simpan data user ke database
         *
         * @var object
         */
        $user = User::create([
            'divisi_id' => $request->divisi_id,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'active' => $user_active,
        ]);

        /**
         * simpan data profil
         */
        $user->profil()->create([
            'avatar' => $avatar,
            'nama_lengkap' => ucwords($request->nama_lengkap),
        ]);

        /**
         * redurect ke halaman user
         */
        return redirect()->route('user')->with('alert', [
            'type' => 'success',
            'message' => '1 user berhasil ditambahkan',
        ]);
    }



    /**
     * View halaman edit user
     *
     * @param  User   $user [description]
     * @return view
     */
    public function edit(User $user)
    {
        /**
         * ambil data divisi & rol
         */
        $divisions = Divisi::all();

        return view('pages.user.edit', compact('divisions', 'user'));
    }



    /**
     * Update data user
     *
     * @param  Request $request
     * @param  User    $user
     *
     * @return redirect
     */
    public function update(Request $request, User $user)
    {
        /**
         * valisadi rules
         *
         * @var array
         */
        $validasi_rules = [
            'username' => ['required', 'max:100'],
            'password' => ['max:200'],
            'avatar' => ['image', 'max:1000'],
            'nama_lengkap' => ['required', 'max:100'],
            'divisi_id' => ['required', 'exists:divisi,id'],
        ];

        /**
         * cek username dirubah atau tidak
         */
        if ($request->username != $user->username) {
            array_push($validasi_rules['username'], 'unique:user,username');
        }

        /**
         * cek password dirubah atau tidak
         */
        if (!empty($request->password)) {
            array_push($validasi_rules['password'], 'min:4');
        }

        /**
         * pesan error validasi
         *
         * @var array
         */
        $validate_message = [
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.max' => 'Username tidak boleh lebih dari 100 karakter.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 4 karakter.',
            'password.max' => 'Password tidak boleh lebih dari 200 karakter.',
            'avatar.image' => 'Avatar harus berupa file gambar.',
            'avatar.max' => 'Ukuran avatar tidak boleh lebih besar dari 1000 kilobytes',
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
            'divisi_id.required' => 'Divisi harus dipilih.',
            'divisi_id.exists' => 'Divisi tidak terdaftar. Anda harus memilih divisi yang telah ditentukan.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validasi_rules, $validate_message);

        /**
         * set value user active & avatar
         */
        $user_active = isset($request->active) ? true : false;
        $avatar = $user->profil->avatar;

        /**
         * cek avatar dirubah atau tidak.
         * jika dirubah hapus avatar yang lama dan upload avatar yang baru.
         */
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($user->profil->avatar);

            $avatar = $request->file('avatar')->store('avatars', 'public');
        }

        /**
         * simpan data user ke database
         *
         * @var object
         */
        $user->divisi_id = $request->divisi_id;
        $user->username = $request->username;
        $user->active = $user_active;

        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        /**
         * simpan data profil ke database
         */
        Profil::where('user_id', $user->id)->update([
            'avatar' => $avatar,
            'nama_lengkap' => ucwords($request->nama_lengkap),
        ]);

        /**
         * redirect ke halaman user
         */
        return redirect()->route('user')->with('alert', [
            'type' => 'success',
            'message' => '1 user berhasil diperbarui',
        ]);
    }



    /**
     * Hapus data user
     *
     * @param User $user
     *
     * @return redirect
     */
    public function delete(User $user)
    {
        try {
            User::destroy($user->id);
        } catch (\Exception $e) {
            return redirect()->route('user')->with('alert', [
                'type' => 'danger',
                'message' => 'User dengan id = ' . $user->id . 'gagal dihapus. ' . $e->getMessage(),
            ]);
        }

        return redirect()->route('user')->with('alert', [
            'type' => 'success',
            'message' => '1 data user berhasil dihapus.',
        ]);
    }



    /**
     * View menu akses user
     *
     * @param User $user
     *
     * @return view
     */
    public function detailMenuAkses(User $user)
    {
        $user = User::with('profil', 'divisi')->find($user->id);
        $menuItems = MenuItem::with('menuHeader', 'user')->get();

        /**
         * ambid data user akses untuk menu user
         */
        $userAccess = User::with('menuItem')->find(Auth::user()->id)
            ->menuItem
            ->where('nama_menu', 'user')
            ->first();

        return view('pages.user.menu-akses.index', compact('user', 'menuItems', 'userAccess'));
    }



    /**
     * View menu akses user
     *
     * @param User $user
     *
     * @return view
     */
    public function editMenuAkses(User $user)
    {
        $user = User::with('menuHeader', 'menuItem', 'profil', 'divisi')->find($user->id);
        $menuHeaders = MenuHeader::with('menuItem', 'user')->get();

        $userAccess = User::with('menuItem')->find(Auth::user()->id)
            ->menuItem
            ->where('nama_menu', 'user')
            ->first();

        return view('pages.user.menu-akses.edit', compact('user', 'menuHeaders', 'userAccess'));
    }



    /**
     * Tambah menu akses user
     *
     * @param Request $request
     * @param User $user
     *
     * @return resirect
     */
    public function updateMenuAkses(Request $request, User $user)
    {
        /**
         * simpan data ke user_menu_header
         */
        try {
            foreach ($request->menuHeader as $menuHeader) {
                DB::table('user_menu_header')->updateOrInsert(
                    [
                        'user_id' => $user->id,
                        'menu_header_id' => $menuHeader['id'],
                    ],
                    [
                        'read' => isset($menuHeader['read']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        } catch (\Exception $e) {
            return redirect()->route('user.menu-akses.edit', ['user' => $user->id])->with('alert', [
                'type' => 'danger',
                'message' => 'Akses pada menu header gagal diperbarui. ' . $e->getMessage(),
            ]);
        }

        /**
         * simpan data ke tabel user_menu_header
         */
        try {
            foreach ($request->menuItem as $menuItem) {
                DB::table('user_menu_item')
                    ->updateOrInsert(
                        [
                            'user_id' => $user->id,
                            'menu_item_id' => $menuItem['id']
                        ],
                        [
                            'create' => isset($menuItem['create']),
                            'read' => isset($menuItem['read']),
                            'update' => isset($menuItem['update']),
                            'delete' => isset($menuItem['delete']),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
            }
        } catch (\Exception $e) {
            return redirect()->route('user.menu-akses.edit', ['user' => $user->id])->with('alert', [
                'type' => 'danger',
                'message' => 'Akses pada menu item gagal diperbarui. ' . $e->getMessage(),
            ]);
        }

        return redirect()->route('user.menu-akses.edit', ['user' => $user->id])->with('alert', [
            'type' => 'success',
            'message' => 'Akses pada menu berhasil diperbarui',
        ]);
    }
}
