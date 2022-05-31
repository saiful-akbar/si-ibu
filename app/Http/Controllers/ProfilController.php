<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Profil;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = Profil::where('user_id', auth()->user()->id)->first();
        return view('pages.profil.index', compact('profil'));
    }

    /**
     * Update data profil user
     * @param Request $request
     *
     * @return Object
     */
    public function updateProfil(Request $request)
    {
        /**
         * valisadi rules
         */
        $validateRules = [
            'avatar' => ['image', 'max:1000'],
            'nama_lengkap' => ['required', 'max:100'],
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'avatar.image' => 'Avatar harus berupa file gambar.',
            'avatar.max' => 'Ukuran avatar tidak boleh lebih besar dari 1000 kilobytes',
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        $avatar = auth()->user()->profil->avatar;

        /**
         * cek avatar dirubah atau tidak.
         * jika dirubah hapus avatar yang lama dan upload avatar yang baru.
         */
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete(auth()->user()->profil->avatar);

            $avatar = $request->file('avatar')->store('avatars', 'public');
        }

        /**
         * simpan perubahan profil ke database
         */
        try {
            Profil::where('user_id', auth()->user()->id)->update([
                'avatar' => $avatar,
                'nama_lengkap' => ucwords($request->nama_lengkap),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('profil')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal memperbarui profil. ' . $e->getMessage(),
                ]);
        }

        /**
         * redirect ke halaman user
         */
        return redirect()->route('profil')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Profil berhasil diperbarui.',
            ]);
    }

    /**
     * view akun setting
     *
     * @return view
     */
    public function akun()
    {
        return view('pages.profil.akun');
    }

    /**
     * update username
     *
     * @param Request $request
     *
     * @return Object
     */
    public function updateUsername(Request $request): Object
    {
        /**
         * validasi rule
         */
        $validateRules = [
            'username' => ['required', 'max:100'],
        ];

        /**
         * cek username dirubah atau tidak
         */
        if ($request->username != auth()->user()->username) {
            array_push($validateRules['username'], 'unique:user,username');
        }

        /**
         * pesan error validasi
         *
         * @var array
         */
        $validateErrorMessage = [
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.max' => 'Username tidak boleh lebih dari 100 karakter.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * ubah username pada database
         */
        try {
            User::where('id', auth()->user()->id)->update([
                'username' => $request->username,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('profil.akun')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal memperbarui username. ' . $e->getMessage(),
                ]);
        }

        return redirect()->route('profil.akun')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Username berhasil diperbarui.',
            ]);
    }

    /**
     * Update password user yang sedang login
     *
     * @param Request $request
     *
     * @return Object
     */
    public function updatePassword(Request $request): Object
    {
        /**
         * validasi rule
         */
        $validateRules = [
            'password_lama'       => ['required', new MatchOldPassword],
            'password_baru'       => ['required', 'max:200', 'min:4'],
            'password_konfirmasi' => ['required', 'same:password_baru'],
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'password_lama.required'       => 'Password lama harus diisi.',
            'password_baru.required'       => 'Password baru harus diisi.',
            'password_baru.max'            => 'Password baru tidak boleh lebih dari 200 karakter.',
            'password_baru.min'            => 'Password baru minimal 4 karakter.',
            'password_konfirmasi.required' => 'Password konfirmasi harus diisi.',
            'password_konfirmasi.same'     => 'Password konfirmasi tidak cocok.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        try {

            /**
             * ubah password pada database
             */
            User::where('id', auth()->user()->id)
                ->update(['password' => bcrypt($request->password_baru)]);
        } catch (\Exception $e) {
            
            /**
             * Return jika update gagal.
             */
            return redirect()->route('profil.akun')->with('alert', [
                'type'    => 'danger',
                'message' => 'Gagal memperbarui password. ' . $e->getMessage(),
            ]);
        }

        /**
         * Return jika update berhasil
         */
        return redirect()->route('profil.akun')->with('alert', [
            'type'    => 'success',
            'message' => 'Password berhasil diperbarui.',
        ]);
    }

    /**
     * view pengaturan
     */
    public function pengaturan()
    {
        return view('pages.profil.pengaturan');
    }

    /**
     * Update Tema
     *
     * @param Request $request
     *
     * @return Object
     */
    public function updateTema(Request $request): Object
    {

        /**
         * validasi rule
         */
        $validateRules = [
            'tema'    => ['required', 'in:light,dark'],
            'sidebar' => ['required', 'in:default,light,dark']
        ];

        /**
         * Pesan error validasi
         */
        $validateErrorMessage = [
            'tema.required'    => 'Tema harus dipilih',
            'tema.in'          => 'Pilih tema terang atau gelap.',
            'sidebar.required' => 'Sidebar harus dipilih',
            'sidebar.in'       => 'Pilih sidebar default, terang atau gelap.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        try {

            /**
             * update tema
             */
            Pengaturan::where('user_id', auth()->user()->id)->update($validatedData);
        } catch (\Exception $e) {

            /**
             * response jika update gagal
             */
            return redirect()->route('profil.pengaturan')
                ->with('alert', [
                    'type'    => 'danger',
                    'message' => 'Gagal memperbarui tema. ' . $e->getMessage(),
                ]);
        }

        /**
         * response update sukses
         */
        return redirect()->route('profil.pengaturan')
            ->with('alert', [
                'type'    => 'success',
                'message' => 'Tema berhasil diperbarui.',
            ]);
    }
}
