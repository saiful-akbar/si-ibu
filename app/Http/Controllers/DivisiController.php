<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;

class DivisiController extends Controller
{
    /**
     * View halaman divisi
     * 
     * @return view
     */
    public function index(Request $request)
    {
        $search = '';
        if (isset($request->search) && !empty($request->search)) {
            $search = $request->search;
        }

        $divisi = Divisi::where('nama_divisi', 'like', '%' . $search . '%')
            ->simplePaginate(25)
            ->withQueryString();

        return view('pages.divisi.index', compact('divisi', 'search'));
    }
}
