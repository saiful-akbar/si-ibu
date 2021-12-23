<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * generate no dokumen baru
     *
     * @return string
     */
    public function generateNoDocument()
    {
        /**
         * buat format
         */
        $format = 'DOK-' . date('Y-m') . '-';

        /**
         * ambil no dokumen tertinggi berdasarkan bulan dan tahun sekarang
         */
        $maxDoc = Transaksi::select('no_dokumen')
            ->where('no_dokumen', 'like', '%' . date('Y-m') . '%')
            ->max('no_dokumen');

        /**
         * ambil no unique dokumen dan tambahkan 1
         */
        $no = (int) substr($maxDoc, 12) + 1;

        /**
         * cek panjang nomer unique $no
         */
        switch (strlen($no)) {
            case 1:
                $format .= "000{$no}";
                break;

            case 2:
                $format .= "00{$no}";
                break;

            case 3:
                $format .= "0{$no}";
                break;

            default:
                $format .= $no;
                break;
        }

        return $format;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * query join tabel transaki, user, profil & divisi
         */
        $query = Transaksi::leftJoin('user', 'transaksi.user_id', '=', 'user.id')
            ->leftJoin('divisi', 'transaksi.divisi_id', '=', 'divisi.id')
            ->select(
                'transaksi.id',
                'transaksi.tanggal',
                'transaksi.kegiatan',
                'transaksi.jumlah_nominal',
                'transaksi.no_dokumen',
                'transaksi.updated_at',
                'divisi.nama_divisi'
            );

        /**
         * cek jika ada request pencarian
         */
        if ($request->search) {
            $query->where('transaksi.tanggal', 'like', "%{$request->search}%")
                ->orWhere('transaksi.kegiatan', 'like', "%{$request->search}%")
                ->orWhere('transaksi.jumlah_nominal', 'like', "%{$request->search}%")
                ->orWhere('transaksi.no_dokumen', 'like', "%{$request->search}%")
                ->orWhere('transaksi.updated_at', 'like', "%{$request->search}%")
                ->orWhere('divisi.nama_divisi', 'like', "%{$request->search}%");
        }

        /**
         * buat pagination
         */
        $transactions = $query->orderBy('transaksi.tanggal', 'desc')
            ->simplePaginate(25)
            ->withQueryString();

        /**
         * ambil user akses untuk menu transaksi
         */
        $userAccess = Auth::user()->menuItem->where('href', '/transaksi')->first();

        return view('pages.transaksi.index', compact('transactions', 'userAccess'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $noDocument = $this->generateNoDocument();
        $jenisBelanja = JenisBelanja::all();

        return view('pages.transaksi.create', compact('jenisBelanja', 'noDocument'));
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
        $validateRules = [
            'tanggal' => ['required', 'date'],
            'approval' => ['required', 'max:100'],

            // kegiatan
            'jenis_belanja_id' => ['required', 'exists:jenis_belanja,id'],
            'kegiatan' => ['required', 'max:100'],
            'jumlah_nominal' => ['required', 'numeric', 'min:0'],

            // dokumen
            'no_dokumen' => ['required', 'unique:transaksi,no_dokumen', 'max:100']
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'tanggal.date' => 'Tanggal tidak valid, masukan tanggal yang valid.',
            'approval.required' => 'Nama approval tidak boleh kosong.',
            'approval.max' => 'Nama approval tidak lebih dari 100 karakter.',

            // kegiatan
            'jenis_belanja_id.required' => 'Jenis belanja harus dipilih.',
            'jenis_belanja_id.exists' => 'Jenis belanja tidak terdaftar. Silakan pilih jenis belanja.',
            'kegiatan.required' => 'Kegiatan tidak boleh kosong.',
            'kegiatan.max' => 'Kegiatan tidak boleh lebih dari 100 karakter.',
            'jumlah_nominal.required' => 'Jumlah nominal tidak boleh kosong.',
            'jumlah_nominal.numeric' => 'Jumlah nominal harus bertipe angka yang valid.',
            'jumlah_nominal.min' => 'Jumlah nominal tidak boleh kurang dari 0.',

            // dokumen
            'no_dokumen.required' => 'Nomer dokumen harus diisi.',
            'no_dokumen.unique' => 'Nomer dokumen sudah digunakan.',
            'no_dokumen.max' => 'Nomer dokumen tidak boleh lebih dari 100 karakter.',
        ];

        /**
         * cek jika file dokumen di upload
         */
        if ($request->file_dokumen) {
            $validateRules['file_dokumen'] = ['file', 'max:5000'];
            $validateErrorMessage['file_dokumen.file'] = 'File dokumen gagal diupload.';
            $validateErrorMessage['file_dokumen.size'] = 'Ukuran file dokumen tidak boleh lebih dari 5 megabytes / 5.000 kilobytes.';
        }

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['divisi_id'] = Auth::user()->divisi->id;
        $validatedData['uraian'] = $request->uraian ?? null;

        /**
         * cek file_dokumen di upload atau tidak
         * jika di upload simpan pada storage
         */
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $extension = $file->extension();
            $fileName = strtoupper($request->no_dokumen) . '.' . $extension;
            $validatedData['file_dokumen'] = $file->storeAs('transaksi', $fileName);
        }

        /**
         * simpan ke database
         */
        try {
            Transaksi::create($validatedData);
        } catch (\Exception $e) {
            return redirect()
                ->route('transaksi.create')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Transaksi gagal ditambahkan. ' . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('transaksi')
            ->with('alert', [
                'type' => 'success',
                'message' => '1 transaksi berhasil ditambahkan.',
            ]);
    }

    /**
     * View edit data transaksi
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        $jenisBelanja = JenisBelanja::all();
        return view('pages.transaksi.edit', compact('transaksi', 'jenisBelanja'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
