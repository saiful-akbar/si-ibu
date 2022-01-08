<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTransaksiExport;
use App\Models\Budget;
use App\Models\Divisi;
use App\Models\JenisBelanja;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    /**
     * generate nomer dokumen baru
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

        return trim($format);
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
            'periode_awal' => [],
            'periode_akhir' => [],
            'divisi' => [],
            'jenis_belanja' => [],
            'no_dokumen' => [],
        ];

        /**
         * Pesan error validasi
         */
        $validateErrorMessage = [
            'periode_awal.required' => 'Periode harus diisi.',
            'periode_awal.date' => 'Periode harus tanggal yang valid.',
            'periode_akhir.required' => 'Periode harus diisi.',
            'periode_akhir.date' => 'Periode harus tanggal yang valid.',
            'divisi.exists' => 'Divisi tidak ada. Pilih divisi yang ditentukan.',
            'jenis_belanja.exists' => 'Jenis belanja tidak ada. Pilih jenis belanja yang ditentukan.',
            'no_dokumen.exists' => 'No dokumen tidak ditemukan.',
        ];

        /**
         * jika periode_awal & periode_akhir dikirim tambahkan validasi
         */
        if ($request->periode_awal || $request->periode_akhir) {
            array_push($validateRules['periode_awal'], 'required', 'date');
            array_push($validateRules['periode_akhir'], 'required', 'date');
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
        if ($request->no_dokumen != null) {
            array_push($validateRules['no_dokumen'], 'exists:transaksi,no_dokumen');
        }

        /**
         * jika jenis belanja dipilah tambahkan validasi
         */
        if ($request->jenis_belanja != null) {
            array_push($validateRules['jenis_belanja'], 'exists:jenis_belanja,kategori_belanja');
        }

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * Query join table transaksi, divisi, user & profil
         */
        $query = Transaksi::leftJoin('budget', 'budget.id', '=', 'transaksi.budget_id')
            ->leftJoin('jenis_belanja', 'jenis_belanja.id', '=', 'budget.jenis_belanja_id')
            ->leftJoin('divisi', 'divisi.id', '=', 'budget.divisi_id')
            ->leftJoin('user', 'user.id', '=', 'transaksi.user_id')
            ->leftJoin('profil', 'profil.user_id', '=', 'user.id')
            ->select([
                'transaksi.id',
                'transaksi.budget_id',
                'transaksi.tanggal',
                'transaksi.kegiatan',
                'transaksi.jumlah_nominal',
                'transaksi.approval',
                'transaksi.no_dokumen',
                'transaksi.file_dokumen',
                'transaksi.created_at',
                'transaksi.updated_at',
                'budget.divisi_id',
                'budget.jenis_belanja_id',
                'jenis_belanja.kategori_belanja',
                'divisi.nama_divisi',
                'profil.nama_lengkap',
            ])
            ->whereBetween('transaksi.tanggal', [$request->periode_awal, $request->periode_akhir]);

        /**
         * jika divisi dipilih tambahkan query
         */
        if ($request->divisi != null) {
            $query->where('divisi.nama_divisi',  $request->divisi);
        }

        /**
         * jika jenis belanja dipilih tambahkan query
         */
        if ($request->jenis_belanja != null) {
            $query->where('jenis_belanja.kategori_belanja',  $request->jenis_belanja);
        }

        /**
         * jika no dokumen dipilih tambahkan validasi
         */
        if ($request->no_dokumen != null) {
            $query->where('transaksi.no_dokumen',  $request->no_dokumen);
        }

        /**
         * buat order
         */
        $query->orderBy('tanggal', 'desc')->orderBy('divisi_id', 'asc');

        /**
         * return view
         */
        return view('pages.transaksi.index', [
            'transactions' => $query->simplePaginate(25)->withQueryString(),
            'userAccess' => Auth::user()->menuItem->where('href', '/belanja')->first(),
            'divisi' => Divisi::where('active', 1)->get(),
            'jenisBelanja' => JenisBelanja::where('active', 1)->get(),
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
        return view('pages.transaksi.create', compact('noDocument'));
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

            // budget
            'budget_id' => ['required', 'exists:budget,id'],
            'nama_divisi' => ['required', 'exists:divisi,nama_divisi'],
            'kategori_belanja' => ['required', 'exists:jenis_belanja,kategori_belanja'],
            'tahun_anggaran' => ['required', 'numeric', 'exists:budget,tahun_anggaran'],
            'sisa_budget' => ['required', 'numeric'],

            // kegiatan
            'tanggal' => ['required', 'date'],
            'kegiatan' => ['required', 'max:100'],
            'approval' => ['required', 'max:100'],
            'jumlah_nominal' => ['required', 'numeric', 'min:0', "max:{$request->sisa_budget}"],

            // dokumen
            'no_dokumen' => ['required', 'unique:transaksi,no_dokumen', 'max:100'],

            // uraian
            'uraian' => ['required'],
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [

            // budget
            'budget_id.required' => 'Akun belanja harus dipilih.',
            'budget_id.exists' => 'Akun belanja tidak ada. Pilih akun belanja yang ditentukan.',

            'nama_divisi.required' => 'Bagian harus diisi.',
            'nama_divisi.exists' => 'Bagian tidak ada.',

            'kategori_belanja.required' => 'Akun belanja harus dipilih.',
            'kategori_belanja.exists' => 'Akun belanja tidak ada. Pilih akun belanja yang ditentukan.',

            'tahun_anggaran.required' => 'Tahun anggaran harus diisi.',
            'tahun_anggaran.numeric' => 'Tahun anggaran harus tahun yang valid (yyyy).',
            'tahun_anggaran.exists' => 'Tidak ada budget pada tahun anggaran yang masukan.',

            'sisa_budget.required' => 'Sisa budget harus diisi.',
            'sisa_budget.numeric' => 'Sisa budget harus bertipe angka yang valid.',

            // kegiatan
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Tanggal tidak valid, masukan tanggal yang valid.',

            'kegiatan.required' => 'Kegiatan harus diisi.',
            'kegiatan.max' => 'Kegiatan tidak boleh lebih dari 100 karakter.',

            'approval.required' => 'Nama approval harus diisi.',
            'approval.max' => 'Nama approval tidak lebih dari 100 karakter.',

            'jumlah_nominal.required' => 'Jumlah nominal harus diisi.',
            'jumlah_nominal.numeric' => 'Jumlah nominal harus bertipe angka yang valid.',
            'jumlah_nominal.min' => 'Jumlah nominal tidak boleh kurang dari 0.',
            'jumlah_nominal.max' => 'Jumlah nominal melebihi sisa nominal budget.',

            // dokumen
            'no_dokumen.required' => 'Nomer dokumen harus diisi.',
            'no_dokumen.unique' => 'Nomer dokumen sudah digunakan.',
            'no_dokumen.max' => 'Nomer dokumen tidak boleh lebih dari 100 karakter.',

            // uraian
            'uraian.required' => 'Uraian harus diisi.'
        ];

        /**
         * cek file dokmen diupload atau tidak
         * jika diupload tambah validari rules & pesan error validasi.
         */
        if ($request->file_dokumen) {
            $validateRules['file_dokumen'] = ['file', 'max:5000'];
            $validateErrorMessage['file_dokumen.file'] = 'File dokumen gagal diupload.';
            $validateErrorMessage['file_dokumen.max'] = 'Ukuran file dokumen tidak boleh lebih dari 5.000 kilobytes.';
        }

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * Ambil data budget berdasarkan "id" budget yang di-request
         */
        $budget = Budget::find($request->budget_id);

        /**
         * cek file_dokumen di upload atau tidak
         * jika di upload simpan pada storage
         */
        $fileDocument = null;
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $extension = $file->extension();
            $fileName = strtoupper($request->no_dokumen) . '.' . $extension;
            $fileDocument = $file->storeAs('transaksi', $fileName);
        }

        try {

            /**
             * tambah transaksi
             */
            Transaksi::create([
                'user_id' => Auth::user()->id,
                'budget_id' => $request->budget_id,
                'tanggal' => $request->tanggal,
                'kegiatan' => $request->kegiatan,
                'jumlah_nominal' => $request->jumlah_nominal,
                'approval' => $request->approval,
                'no_dokumen' => $request->no_dokumen,
                'file_dokumen' => $fileDocument,
                'uraian' => $request->uraian ?? null,
            ]);

            /**
             * kurangi sisa_nominal pada budget
             */
            $budget->sisa_nominal -= $request->jumlah_nominal;
            $budget->save();
        } catch (\Exception $e) {

            /**
             * return jika proses simpan gagal
             */
            return redirect()
                ->route('belanja.create')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Gagal menambahkan data belanja ditambahkan. ' . $e->getMessage(),
                ]);
        }

        /**
         * return jika proses simpan sukses.
         */
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
        $result = Transaksi::with('budget.divisi', 'budget.jenisBelanja', 'user.profil')
            ->find($transaksi->id);
        $linkDownload = $result->file_dokumen != null ? route('belanja.download', ['transaksi' => $result->id]) : null;

        return response()->json([
            'transaksi' => $result,
            'download' => $linkDownload
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
        return view('pages.transaksi.edit', compact('transaksi'));
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
            'budget_id' => ['required', 'exists:budget,id'],
            'nama_divisi' => ['required', 'exists:divisi,nama_divisi'],
            'kategori_belanja' => ['required', 'exists:jenis_belanja,kategori_belanja'],
            'tahun_anggaran' => ['required', 'numeric', 'exists:budget,tahun_anggaran'],
            'sisa_budget' => ['required', 'numeric'],
            'tanggal' => ['required', 'date'],
            'kegiatan' => ['required', 'max:100'],
            'approval' => ['required', 'max:100'],
            'jumlah_nominal' => ['required', 'numeric', 'min:0', "max:{$request->sisa_budget}"],
            'uraian' => ['required'],
        ];

        /**
         * pesan error validasi
         */
        $validateErrorMessage = [
            'budget_id.required' => 'Akun belanja harus dipilih.',
            'budget_id.exists' => 'Akun belanja tidak ada. Pilih akun belanja yang ditentukan.',
            'nama_divisi.required' => 'Bagian harus diisi.',
            'nama_divisi.exists' => 'Bagian tidak ada.',
            'kategori_belanja.required' => 'Akun belanja harus dipilih.',
            'kategori_belanja.exists' => 'Akun belanja tidak ada. Pilih akun belanja yang ditentukan.',
            'tahun_anggaran.required' => 'Tahun anggaran harus diisi.',
            'tahun_anggaran.numeric' => 'Tahun anggaran harus tahun yang valid (yyyy).',
            'tahun_anggaran.exists' => 'Tidak ada budget pada tahun anggaran yang masukan.',
            'sisa_budget.required' => 'Sisa budget harus diisi.',
            'sisa_budget.numeric' => 'Sisa budget harus bertipe angka yang valid.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Tanggal tidak valid, masukan tanggal yang valid.',
            'kegiatan.required' => 'Kegiatan harus diisi.',
            'kegiatan.max' => 'Kegiatan tidak boleh lebih dari 100 karakter.',
            'approval.required' => 'Nama approval harus diisi.',
            'approval.max' => 'Nama approval tidak lebih dari 100 karakter.',
            'jumlah_nominal.required' => 'Jumlah nominal harus diisi.',
            'jumlah_nominal.numeric' => 'Jumlah nominal harus bertipe angka yang valid.',
            'jumlah_nominal.min' => 'Jumlah nominal tidak boleh kurang dari 0.',
            'jumlah_nominal.max' => 'Jumlah nominal melebihi sisa nominal budget.',
            'uraian.required' => 'Uraian harus diisi.'
        ];

        /**
         * cek apakah no dokumen dirubah atau tidak
         * jika dirubah tambahkan validasi
         */
        if ($request->no_dokumen != $transaksi->no_dokumen) {
            $validateRules['no_dokumen'] = ['required', 'unique:transaksi,no_dokumen', 'max:100'];
            $validateErrorMessage['no_dokumen.required'] = 'Nomer dokumen harus diisi.';
            $validateErrorMessage['no_dokumen.unique'] = 'Nomer dokumen sudah digunakan.';
            $validateErrorMessage['no_dokumen.max'] = 'Nomer dokumen tidak boleh lebih dari 100 karakter.';
        }

        /**
         * cek jika file dokumen di upload
         * jika diupload tambahakan validasi
         */
        if ($request->file_dokumen) {
            $validateRules['file_dokumen'] = ['file', 'max:5000'];
            $validateErrorMessage['file_dokumen.file'] = 'File dokumen gagal diupload.';
            $validateErrorMessage['file_dokumen.max'] = 'Ukuran file dokumen tidak boleh lebih dari 5.000 kilobytes.';
        }

        /**
         * jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * cek jika no_dokumen dirubah tetapi file_dokumen tidak dirubah
         * maka rename nama file_dokumen di storage
         */
        $fileDokumen = $transaksi->file_dokumen;

        if (
            $request->no_dokumen != $transaksi->no_dokumen &&
            !$request->hasFile('file_dokumen')
        ) {
            $namaFileDokumen = str_replace($transaksi->no_dokumen, $request->no_dokumen, $transaksi->file_dokumen);
            Storage::move($transaksi->file_dokumen, $namaFileDokumen);
            $fileDokumen = $namaFileDokumen;
        }

        /**
         * cek file_dokumen dirubah atau tidak.
         * jika dirubah hapus file_dokumen yang lama dan upload file_dokumen yang baru.
         */
        if ($request->hasFile('file_dokumen')) {

            /**
             * hapus file_dokumen lama dari storage
             */
            Storage::delete($transaksi->file_dokumen);

            /**
             * simpan file_dokumen baru ke storage
             */
            $file = $request->file('file_dokumen');
            $extension = $file->extension();
            $fileName = strtoupper($request->no_dokumen) . '.' . $extension;
            $fileDokumen = $file->storeAs('transaksi', $fileName);
        }

        /**
         * update database
         */
        try {

            /**
             * cek budget dirubah atau tidak
             * jika dirubah tambah nominal dan sisa_budget pada budget yang lama.
             * kurangi nominal dan sisa_nominal pada budget yang baru.
             */
            if ($transaksi->budget_id != $request->budget_id) {

                /**
                 * kembalikan (tambah) sisa_budget pada budget akun belanja yang lama
                 */
                $budgetLama = Budget::find($transaksi->budget_id);
                $budgetLama->sisa_nominal += $transaksi->jumlah_nominal;
                $budgetLama->save();

                /**
                 * kurangi sisa_nominal pada budget akun belanja yang baru
                 */
                $budgetBaru = Budget::find($request->budget_id);
                $budgetBaru->sisa_nominal -= $request->jumlah_nominal;
                $budgetBaru->save();
            } else {

                /**
                 * ambil data budget lama
                 */
                $budgetLama = Budget::find($transaksi->budget_id);

                /**
                 * jika budget tidak dirubah
                 * cek jumlah nominal lebih banyak atau lebih sedikit dari jumlah_nominal sebelumnya.
                 * update sisa_nominal budget pada akun belanja (jenis_belanja) yang lama.
                 */
                if ($request->jumlah_nominal > $transaksi->jumlah_nominal) {

                    /**
                     * kurangi sisa_nominal pada budget lama
                     */
                    $budgetLama->sisa_nominal -= $request->jumlah_nominal - $transaksi->jumlah_nominal;
                    $budgetLama->save();
                } else if ($request->jumlah_nominal < $transaksi->jumlah_nominal) {

                    /**
                     * jika jumlah_nominal baru lebih sedikit dari jumlah_nominal lama.
                     * tambahkan sisa_nominal budget pada akun belanja (jenis_belanja) lama.
                     */
                    $budgetLama->sisa_nominal += $transaksi->jumlah_nominal - $request->jumlah_nominal;
                    $budgetLama->save();
                }
            }

            /**
             * update data transaksi (belanja)
             */
            Transaksi::where('id', $transaksi->id)
                ->update([
                    'user_id' => Auth::user()->id,
                    'budget_id' => $request->budget_id,
                    'tanggal' => $request->tanggal,
                    'jumlah_nominal' => $request->jumlah_nominal,
                    'approval' => $request->approval,
                    'no_dokumen' => $request->no_dokumen,
                    'file_dokumen' => $fileDokumen,
                    'uraian' => $request->uraian,
                ]);
        } catch (\Exception $e) {

            /**
             * response jika proses update gagal
             */
            return redirect()
                ->route('belanja.edit', ['transaksi' => $transaksi->id])
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Data belanja gagal dirubah. ' . $e->getMessage(),
                ]);
        }

        /**
         * response update sukses
         */
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
        $query = Transaksi::leftJoin('budget', 'budget.id', '=', 'transaksi.budget_id')
            ->leftJoin('jenis_belanja', 'jenis_belanja.id', '=', 'budget.jenis_belanja_id')
            ->leftJoin('divisi', 'divisi.id', '=', 'budget.divisi_id')
            ->leftJoin('user', 'user.id', '=', 'transaksi.user_id')
            ->leftJoin('profil', 'profil.user_id', '=', 'user.id')
            ->select([
                'transaksi.id',
                'transaksi.budget_id',
                'transaksi.tanggal',
                'transaksi.kegiatan',
                'transaksi.jumlah_nominal',
                'transaksi.approval',
                'transaksi.no_dokumen',
                'transaksi.file_dokumen',
                'transaksi.uraian',
                'transaksi.created_at',
                'transaksi.updated_at',
                'budget.divisi_id',
                'budget.jenis_belanja_id',
                'jenis_belanja.kategori_belanja',
                'divisi.nama_divisi',
                'profil.nama_lengkap',
            ])->whereBetween('transaksi.tanggal', [$request->periode_awal, $request->periode_akhir]);

        /**
         * jika divisi dipilih tambahkan query
         */
        if ($request->divisi != null) {
            $query->where('divisi.nama_divisi',  $request->divisi);
        }

        /**
         * jika jenis belanja dipilih tambahkan query
         */
        if ($request->jenis_belanja != null) {
            $query->where('jenis_belanja.kategori_belanja',  $request->jenis_belanja);
        }

        /**
         * jika no dokumen dipilih tambahkan validasi
         */
        if ($request->no_dokumen != null) {
            $query->where('transaksi.no_dokumen',  $request->no_dokumen);
        }

        /**
         * hitung jumlah nominal;
         */
        $totalTransaksi = $query->sum('transaksi.jumlah_nominal');

        /**
         * buat order
         */
        $laporanTransaksi = $query
            ->orderBy('transaksi.tanggal', 'asc')
            ->orderBy('divisi.nama_divisi', 'asc')
            ->orderBy('jenis_belanja.kategori_belanja', 'asc')
            ->get();


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
        return Excel::download(new LaporanTransaksiExport($data), 'Laporan Transaksi Belanja ' . date('Y-m-d h.i.s') . '.xlsx');
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

        // return view('export.pdf.pdf-transaksi', $data);

        return PDF::loadView('export.pdf.pdf-transaksi', $data)
            ->setPaper('a4', 'landscape')
            ->download('Laporan Transaksi Belanja ' . date('Y-m-d h.i.s') . '.pdf');
    }

    /**
     * Fungsi membuat data tabel jenis_belanja
     *
     */
    public function dataTable()
    {
        $budgets = Budget::leftJoin('divisi', 'divisi.id', '=', 'budget.divisi_id')
            ->leftJoin('jenis_belanja', 'jenis_belanja.id', '=', 'budget.jenis_belanja_id')
            ->select([
                'budget.id',
                'budget.tahun_anggaran',
                'budget.sisa_nominal',
                'divisi.nama_divisi',
                'jenis_belanja.kategori_belanja',
            ])->orderBy('budget.tahun_anggaran', 'desc')
            ->orderBy('divisi.nama_divisi', 'asc')
            ->orderBy('jenis_belanja.kategori_belanja', 'asc')
            ->get();

        return DataTables::of($budgets)
            ->addColumn('action', function ($budget) {
                return "
                    <button
                        onclick='transaksi.setFormValue({$budget->id}, {$budget->tahun_anggaran}, \"{$budget->nama_divisi}\", \"{$budget->kategori_belanja}\", {$budget->sisa_nominal})'
                        class='btn btn-sm btn-success btn-rounded btn-sm'
                    >
                        <i class='mdi mdi-hand-pointing-up'></i>
                        <span>Pilih</span>
                    </button>
                ";
            })->make(true);
    }
}
