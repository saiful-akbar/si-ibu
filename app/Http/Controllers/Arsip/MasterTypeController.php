<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\MSARSType;
use Illuminate\Http\Request;

class MasterTypeController extends Controller
{
    public function index(Request $request)
    {
        /**
         * query master type
         */
        $query = MSARSType::with(['MSARSCategory' => fn ($q) => $q->orderBy('Nama', 'asc')]);

        /**
         * cek jika ada request search
         */
        if ($request->search) {
            $query->orWhere('Nama', 'like', "%{$request->search}%")
                ->orWhereHas('MSARSCategory', fn ($q) => $q->where('Nama', 'like', "%{$request->search}%"));
        }

        /**
         * pagination
         */
        $arsTypes = $query->orderBy('Nama', 'asc')
            ->simplePaginate(10)
            ->withQueryString();

        return view('pages.arsip.master.type.index', compact('arsTypes'));
    }
}
