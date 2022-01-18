<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    /**
     * Method view arsip dokumen
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        return view('pages.arsip.dokumen.index');
    }
}
