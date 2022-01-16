<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\ARSBastPinjam;
use App\Models\Arsip\ARSCetakSlip;
use App\Models\Arsip\ARSDetail;
use App\Models\Arsip\ARSHeader;
use App\Models\Arsip\ESELON;
use App\Traits\ConnectionTrait;
use Illuminate\Http\Request;

/**
 * Class ArsipController
 */
class ArsipController extends Controller
{
    use ConnectionTrait;

    public function index()
    {
        $data = ESELON::offset(20)
            ->limit(10)
            ->orderBy('ESELON2_FK', 'asc')
            ->get();

        dd($data);
    }
}
