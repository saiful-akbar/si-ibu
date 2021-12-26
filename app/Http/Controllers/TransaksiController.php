<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTransaksiExport;
use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
     * view halaman transaksi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Validasi rule
         */
        $validateRules = [
            'periodeAwal' => [],
            'periodeAkhir' => [],
            'divisi' => [],
            'jenisBelanja' => [],
            'noDokumen' => [],
        ];

        /**
         * Pesan error validasi
         */
        $validateErrorMessage = [
            'periodeAwal.required' => 'Periode harus diisi.',
            'periodeAwal.date' => 'Periode harus tanggal yang valid.',
            'periodeAkhir.required' => 'Periode harus diisi.',
            'periodeAkhir.date' => 'Periode harus tanggal yang valid.',
            'divisi.exists' => 'Divisi tidak ada. Pilih divisi yang ditentukan.',
            'jenisBelanja.exists' => 'Jenis belanja tidak ada. Pilih jenis belanja yang ditentukan.',
            'noDokumen.exists' => 'No dokumen tidak ditemukan.',
        ];

        /**
         * jika periodeAwal & periodeAkhir dikirim tambahkan validasi
         */
        if ($request->periodeAwal || $request->periodeAkhir) {
            array_push($validateRules['periodeAwal'], 'required', 'date');
            array_push($validateRules['periodeAkhir'], 'required', 'date');
        }

        /**
         * jika divisi dipilih tambahkan validasi
         */
        if ($request->divisi != null) {
            array_push($validateRules['divisi'], 'exists:divisi,nama_divisi');
        }

        /**
         * jika no dokumen diisi tambahkan validasi
         */
        if ($request->noDokumen != null) {
            array_push($validateRules['noDokumen'], 'exists:transaksi,no_dokumen');
        }

        /**
         * jika jenis belanja dipilah tambahkan validasi
         */
        if ($request->jenisBelanja != null) {
            array_push($validateRules['jenisBelanja'], 'exists:jenis_belanja,kategori_belanja');
        }

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * Query join table transaksi, divisi, user & profil
         */
        $query = Transaksi::with(['divisi', 'jenisBelanja', 'user.profil'])
            ->whereBetween('transaksi.tanggal', [$request->periodeAwal, $request->periodeAkhir]);

        /**
         * jika divisi dipilih tambahkan query
         */
        if ($request->divisi != null) {
            $divisi = Divisi::where('nama_divisi', $request->divisi)->first();
            $query->where('divisi_id',  $divisi->id);
        }

        /**
         * jika jenis belanja dipilih tambahkan query
         */
        if ($request->jenisBelanja != null) {
            $jenisBelanja = JenisBelanja::where('kategori_belanja', $request->jenisBelanja)->first();
            $query->where('jenis_belanja_id',  $jenisBelanja->id);
        }

        /**
         * jika no dokumen dipilih tambahkan validasi
         */
        if ($request->noDokumen != null) {
            $query->where('no_dokumen',  $request->noDokumen);
        }

        /**
         * buat order
         */
        $query->orderBy('tanggal', 'desc')->orderBy('divisi_id', 'asc');

        return view('pages.transaksi.index', [
            'transactions' => $query->paginate(25)->withQueryString(),
            'userAccess' => Auth::user()->menuItem->where('href', '/belanja')->first(),
            'divisi' => Divisi::all(),
            'jenisBelanja' => JenisBelanja::all(),
        ]);
    }

    /**
     * view halaman tambah transaksi
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
     * Tambah data transaksi ke database
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
            $validateErrorMessage['file_dokumen.max'] = 'Ukuran file dokumen tidak boleh lebih dari 5 megabytes / 5.000 kilobytes.';
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
                ->route('belanja.create')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menambahkan data belanja ditambahkan. ' . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('belanja.create')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Data belanja berhasil ditambahkan.',
            ]);
    }

    /**
     * View detail data transaksi
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        $query = Transaksi::with('divisi', 'jenisBelanja', 'user.profil')
            ->where('id', $transaksi->id)
            ->first();

        return response()->json([
            'transaksi' => $query,
        ]);
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
     * Update data transaksi
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
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
        ];

        /**
         * cek apakah no dokumen dirubah atau tidak
         */
        if ($request->no_dokumen != $transaksi->no_dokumen) {
            $validateRules['no_dokumen'] = ['required', 'unique:transaksi,no_dokumen', 'max:100'];
            $validateErrorMessage['no_dokumen.required'] = 'Nomer dokumen harus diisi.';
            $validateErrorMessage['no_dokumen.unique'] = 'Nomer dokumen sudah digunakan.';
            $validateErrorMessage['no_dokumen.max'] = 'Nomer dokumen tidak boleh lebih dari 100 karakter.';
        }

        /**
         * cek jika file dokumen di upload
         */
        if ($request->file_dokumen) {
            $validateRules['file_dokumen'] = ['file', 'max:5000'];
            $validateErrorMessage['file_dokumen.file'] = 'File dokumen gagal diupload.';
            $validateErrorMessage['file_dokumen.max'] = 'Ukuran file dokumen tidak boleh lebih dari 5 megabytes / 5.000 kilobytes.';
        }

        /**
         * jalankan validasi
         */
        $validatedData = $request->validate($validateRules, $validateErrorMessage);

        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['divisi_id'] = Auth::user()->divisi->id;
        $validatedData['uraian'] = $request->uraian ?? null;

        /**
         * cek jika no_dokumen dirubah tetapi file_dokumen tidak dirubah
         * maka rename nama file dokumen di storage
         */
        if ($request->no_dokumen != $transaksi->no_dokumen && !$request->hasFile('file_dokumen')) {
            $fileDokumenNewName = str_replace($transaksi->no_dokumen, $request->no_dokumen, $transaksi->file_dokumen);
            Storage::move($transaksi->file_dokumen, $fileDokumenNewName);
            $validatedData['file_dokumen'] = $fileDokumenNewName;
        }

        /**
         * cek file_dokumen dirubah atau tidak.
         * jika dirubah hapus file_dokumen yang lama dan upload file_dokumen yang baru.
         */
        if ($request->hasFile('file_dokumen')) {
            Storage::delete($transaksi->file_dokumen);

            $file = $request->file('file_dokumen');
            $extension = $file->extension();
            $fileName = strtoupper($request->no_dokumen) . '.' . $extension;
            $validatedData['file_dokumen'] = $file->storeAs('transaksi', $fileName);
        }

        /**
         * update database
         */
        try {
            Transaksi::where('id', $transaksi->id)->update($validatedData);
        } catch (\Exception $e) {
            return redirect()
                ->route('belanja.edit', ['transaksi' => $transaksi->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Data belanja gagal dirubah. ' . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('belanja.edit', ['transaksi' => $transaksi->id])
            ->with('alert', [
                'type' => 'success',
                'message' => 'Data belanja berhasil dirubah.',
            ]);
    }

    /**
     * hapus data transaksi
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function delete(Transaksi $transaksi)
    {
        try {
            Transaksi::destroy($transaksi->id);
            Storage::delete($transaksi->file_dokumen);
        } catch (\Exception $e) {
            return redirect()
                ->route('belanja')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menghapus dihapus. ' . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('belanja')
            ->with('alert', [
                'type' => 'success',
                'message' => '1 data belanja berhasil dihapus.',
            ]);
    }

    /**
     * Download file dokumen
     *
     * @param Transaksi $transaksi
     *
     * @return void
     */
    public function download(Transaksi $transaksi)
    {
        if ($transaksi->file_dokumen) {
            return Storage::download($transaksi->file_dokumen);
        } else {
            return redirect()
                ->route('belanja')
                ->with('alert', [
                    'type' => 'info',
                    'message' => 'File dokumen tidak tersedia.',
                ]);
        }
    }

    /**
     * filter data untuk export excel & print pdf
     *
     * @param mixed $request
     *
     * @return array
     */
    public function fillter($request)
    {
        /**
         * Query join table transaksi, divisi, user & profil
         */
        $query = Transaksi::with(['divisi', 'jenisBelanja', 'user.profil'])
            ->whereBetween('transaksi.tanggal', [$request->periodeAwal, $request->periodeAkhir]);

        /**
         * cek apakan request divis dipilih atau tidak
         */
        if ($request->divisi != null) {
            $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

            if ($divisi) {
                $query->where('divisi_id',  $divisi->id);
            }
        }

        /**
         * hitung jumlah nominal;
         */
        $totalTransaksi = $query->sum('jumlah_nominal');

        /**
         * buat order
         */
        $laporanTransaksi = $query->orderBy('tanggal', 'asc')->orderBy('divisi_id', 'asc')->get();


        return [
            'laporanTransaksi' => $laporanTransaksi,
            'totalTransaksi' => $totalTransaksi,
        ];
    }

    /**
     * export excel
     *
     * @param Request $request
     *
     * @return download
     */
    public function exportExcel(Request $request)
    {
        $data = $this->fillter($request);
        return Excel::download(new LaporanTransaksiExport($data), 'laporan-transaksi.xlsx');
    }

    /**
     * print PDF
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function exportPdf(Request $request)
    {
        $data = $this->fillter($request);

        return PDF::loadView('pages.laporan-transaksi.export-pdf', $data)
            ->setPaper('a4', 'landscape')
            ->download('laporan-transaksi.pdf');
    }
}
