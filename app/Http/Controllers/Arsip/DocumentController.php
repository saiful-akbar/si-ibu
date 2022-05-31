<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\ARSDocument;
use App\Models\Arsip\MSARSCategory;
use App\Traits\ConnectionTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mimey\MimeTypes;

class DocumentController extends Controller
{
    use ConnectionTrait;

    private $conn;
    private $db;

    public function __construct()
    {
        $this->conn = $this->getConnection('second');
        $this->db = $this->getDatabase('second');
    }

    /**
     * Method view arsip dokumen
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        /**
         * Validate rules
         */
        $validateRules = [
            'first_period' => [],
            'last_period'  => [],
            'number'       => [],
            'nama_file'    => [],
            'ars_category' => [],
            'ars_type'     => [],
        ];

        /**
         * Pesan error validasi
         */
        $validateErrorMessage = [
            'first_period.required' => 'Periode harus diisi.',
            'first_period.date'     => 'Periode harus tanggal yang valid.',
            'last_period.required'  => 'Periode harus diisi.',
            'last_period.date'      => 'Periode harus tanggal yang valid.',
            'number.exists'         => 'Nomor tidak ditemukan.',
            'ars_category.exists'   => 'Kategori arsip tidak ada. Pilih kategori arsip yang ditentukan.',
            'ars_type.exists'       => 'Type arsip tidak ada. Pilih type arsip yang ditentukan.',
        ];

        /**
         * jika periode_awal & periode_akhir dikirim tambahkan validasi
         */
        if ($request->periode_awal || $request->periode_akhir) {
            array_push($validateRules['first_period'], 'required', 'date');
            array_push($validateRules['last_period'], 'required', 'date');
        }

        /**
         * cek jika ada request ars_category
         */
        if (!empty($request->ars_category)) {
            array_push($validateRules['ars_category'], "exists:{$this->conn}.MSARSCategory,Name");
        }

        /**
         * cek jika ada request ars_type
         */
        if (!empty($request->ars_type)) {
            array_push($validateRules['ars_type'], "exists:{$this->conn}.MSARSType,Name");
        }

        /**
         * cek jika ada request nomer
         */
        if (!empty($request->number)) {
            array_push($validateRules['number'], "exists:{$this->conn}.ARSDocument,Number");
        }

        /**
         * Jalankan validasi
         */
        $request->validate($validateRules, $validateErrorMessage);

        /**
         * default periode
         */
        $firstPeriod = $request->first_period ?? date('Y-m-d', time() - (60 * 60 * 24 * 13));
        $lastPeriod = $request->last_period ?? date('Y-m-d');

        /**
         * Query dokumen arsip
         */
        $query = ARSDocument::with('MSARSType.MSARSCategory')
            ->whereBetween('DateDoc', [$firstPeriod, $lastPeriod]);

        /**
         * query jika request ars_category dipilih
         */
        if (!empty($request->ars_category)) {
            $query->whereHas('MSARSType.MSARSCategory', fn (Builder $q) => $q->where('Name', $request->ars_category));
        }

        /**
         * query jika request ars_type dipilih
         */
        if (!empty($request->ars_type)) {
            $query->whereHas("MSARSType", fn (Builder $q) => $q->where('Name', $request->ars_type));
        }

        /**
         * query jika request number dipilih
         */
        if (!empty($request->number)) {
            $query->where('Number', $request->number);
        }

        /**
         * query jika request nama_file diinput
         */
        if (!empty($request->nama_file)) {
            $query->where('NamaFile', 'like', "%{$request->nama_file}%");
        }

        /**
         * Query order & paginate
         */
        $arsDocuments = $query->orderBy('Years', 'desc')
            ->orderBy('DateDoc', 'desc')
            ->paginate(20)
            ->withQueryString();

        /**
         * ambil data kategori & type arsip
         */
        $arsCategories = MSARSCategory::with(['MSARSType' => fn ($q) => $q->orderBy('Name', 'asc')])
            ->orderBy('Name', 'asc')
            ->get();

        /**
         * return view
         */
        return view('pages.arsip.document.index', compact('arsDocuments', 'arsCategories', 'firstPeriod', 'lastPeriod'));
    }

    /**
     * Method download file dokumen
     *
     * @param ARSDocument $arsDocument
     */
    public function download(ARSDocument $arsDocument)
    {
        /**
         * get mime type
         */
        $finfo = new \finfo(FILEINFO_MIME);
        $mimeType = strpos($finfo->buffer($arsDocument->Dokumen), ';');
        $mimeType = substr($finfo->buffer($arsDocument->Dokumen), 0, $mimeType);

        /**
         * get extesion
         */
        $mimes = new MimeTypes;
        $ext = $mimes->getExtension($mimeType);

        /**
         * download file dokumen
         */
        return response($arsDocument->Dokumen)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'Arsip Dokumen')
            ->header('Content-Type', $mimeType)
            ->header('Content-length', strlen($arsDocument->Dokumen))
            ->header('Content-Disposition', "attachment; filename={$arsDocument->NamaFile}.{$ext}")
            ->header('Content-Transfer-Encoding', 'binary');
    }
}
