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
        $profil = Profil::where('user_id', Auth::user()->id)->first();
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

        $avatar = Auth::user()->profil->avatar;

        /**
         * cek avatar dirubah atau tidak.
         * jika dirubah hapus avatar yang lama dan upload avatar yang baru.
         */
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete(Auth::user()->profil->avatar);

            $avatar = $request->file('avatar')->store('avatars', 'public');
        }

        /**
         * simpan perubahan profil ke database
         */
        try {
            Profil::where('user_id', Auth::user()->id)->update([
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
        if ($request->username != Auth::user()->username) {
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
            User::where('id', Auth::user()->id)->update([
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
            'passwordLama' => ['required', new MatchOldPassword],
            'passwordBaru' => ['required', 'max:200', 'min:4'],
            'passwordKonfirmasi' => ['required', 'same:passwordBaru'],
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'passwordLama.required' => 'Password lama harus diisi.',
            'passwordBaru.required' => 'Password baru harus diisi.',
            'passwordBaru.max' => 'Password baru tidak boleh lebih dari 200 karakter.',
            'passwordBaru.min' => 'Password baru minimal 4 karakter.',
            'passwordKonfirmasi.required' => 'Password konfirmasi harus diisi.',
            'passwordKonfirmasi.same' => 'Password konfirmasi tidak cocok.',
        ];

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * ubah password pada database
         */
        try {
            User::where('id', Auth::user()->id)->update([
                'password' => bcrypt($request->passwordBaru),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('profil.akun')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal memperbarui password. ' . $e->getMessage(),
                ]);
        }

        return redirect()->route('profil.akun')
            ->with('alert', [
                'type' => 'success',
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
            'tema' => ['required', 'in:light,dark'],
            'sidebar' => ['required', 'in:default,light,dark']
        ];

        /**
         * Pesan error validasi
         */
        $validateErrorMessage = [
            'tema.required' => 'Tema harus dipilih',
            'tema.in' => 'Pilih tema terang atau gelap.',
            'sidebar.required' => 'Sidebar harus dipilih',
            'sidebar.in' => 'Pilih sidebar default, terang atau gelap.',
        ];

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        try {

            /**
             * update tema
             */
            Pengaturan::where('user_id', Auth::user()->id)->update($validatedData);
        } catch (\Exception $e) {

            /**
             * response jika update gagal
             */
            return redirect()->route('profil.pengaturan')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal memperbarui tema. ' . $e->getMessage(),
                ]);
        }

        /**
         * response update sukses
         */
        return redirect()->route('profil.pengaturan')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Tema berhasil diperbarui.',
            ]);
    }
}
