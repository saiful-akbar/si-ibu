<?php

namespace App\Http\Controllers;

use App\Models\AkunBelanja;
use Illuminate\Http\Request;

class AkunBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.akun-belanja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AkunBelanja  $akunBelanja
     * @return \Illuminate\Http\Response
     */
    public function edit(AkunBelanja $akunBelanja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AkunBelanja  $akunBelanja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AkunBelanja $akunBelanja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AkunBelanja  $akunBelanja
     * @return \Illuminate\Http\Response
     */
    public function destroy(AkunBelanja $akunBelanja)
    {
        //
    }
}
