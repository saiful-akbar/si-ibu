<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\ARSDocument;
use App\Models\Arsip\MSARSCategory;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
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
        // $validateRules = [
        //     'first_period' => [],
        //     'last_period' => [],
        //     'ars_category' => [],
        //     'ars_type' => [],
        //     'number' => [],
        // ];

        /**
         * Pesan error validasi
         */
        // $validateErrorMessage = [
        //     'first_period.required' => 'Periode harus diisi.',
        //     'first_period.date' => 'Periode harus tanggal yang valid.',
        //     'last_period.required' => 'Periode harus diisi.',
        //     'last_period.date' => 'Periode harus tanggal yang valid.',
        //     'ars_category.exists' => 'Kategori arsip tidak ada. Pilih kategori arsip yang ditentukan.',
        //     'ars_type.exists' => 'Type arsip tidak ada. Pilih type arsip yang ditentukan.',
        //     'number.exists' => 'Nomor tidak ditemukan.',
        // ];

        /**
         * jika periode_awal & periode_akhir dikirim tambahkan validasi
         */
        // if ($request->periode_awal || $request->periode_akhir) {
        //     array_push($validateRules['first_period'], 'required', 'date');
        //     array_push($validateRules['last_period'], 'required', 'date');
        // }

        /**
         * cek jika ada request ars_category
         */
        // if (!empty($request->ars_category)) {
        //     array_push($validateRules['ars_category'], 'exists:MSARSCategory,Nama');
        // }

        /**
         * cek jika ada request ars_type
         */
        // if (!empty($request->ars_type)) {
        //     array_push($validateRules['ars_type'], 'exists:MSARSType,Nama');
        // }

        /**
         * cek jika ada request nomer
         */
        // if (!empty($request->number)) {
        //     array_push($validateRules['number'], 'exists:ARSDocument,Number');
        // }

        /**
         * Jalankan validasi
         */
        // $request->validate($validateRules, $validateErrorMessage);

        /**
         * default periode
         */
        $firstPeriod = $request->first_period ?? date('Y-m-d', time() - (60 * 60 * 24 * 13));
        $lastPeriod = $request->last_period ?? date('Y-m-d');

        /**
         * Query dokumen arsip
         */
        $query = ARSDocument::with([
            'MSARSType' => fn ($q) => $q->orderBy('Nama', 'asc'),
            'MSARSType.MSARSCategory' => fn ($q) => $q->orderBy('Nama', 'asc'),
        ])->where('Is_Publish', 1)
            ->whereBetween('Date_Doc', [$firstPeriod, $lastPeriod]);

        /**
         * query jika request ars_category dipilih
         */
        if (!empty($request->ars_category)) {
            $query->whereHas('MSARSType.MSARSCategory', fn ($q) => $q->where('Nama', $request->ars_category));
        }

        /**
         * query jika request ars_type dipilih
         */
        if (!empty($request->ars_type)) {
            $query->whereHas('MSARSType', fn ($q) => $q->where('Nama', $request->ars_type));
        }

        /**
         * query jika request number dipilih
         */
        if (!empty($request->number)) {
            $query->where('Number', $request->number);
        }

        /**
         * Query order & paginate
         */
        $arsDocuments = $query->orderBy('years', 'desc')
            ->orderBy('Date_Doc', 'desc')
            ->simplePaginate(10)
            ->withQueryString();

        /**
         * ambil data kategori & type arsip
         */
        $arsCategories = MSARSCategory::with(['MSARSType' => fn ($q) => $q->orderBy('Nama', 'asc')])
            ->orderBy('Nama', 'asc')
            ->get();

        /**
         * return view
         */
        return view('pages.arsip.document.index', compact('arsDocuments', 'arsCategories', 'firstPeriod', 'lastPeriod'));
    }
}
