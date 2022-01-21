<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\MSARSCategory;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    /**
     * View index master kategori arsip
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        /**
         * Query master kategori
         */
        $query = MSARSCategory::select('MSARSCategory_PK', 'Nama');

        /**
         * cek jika ada request search
         */
        if ($request->search) {
            $query->where('Nama', 'like', "%{$request->search}%");
        }

        /**
         * Query order
         */
        $query->orderBy('Nama', 'asc');

        /**
         * Pagination
         */
        $arsCategories = $query->simplePaginate(10)->withQueryString();

        /**
         * return view
         */
        return view('pages.arsip.master.category.index', compact('arsCategories'));
    }
}