<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\MSARSType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MasterTypeController extends Controller
{
    public function index(Request $request)
    {
        /**
         * query master type
         */
        $query = MSARSType::with(['MSARSCategory' => fn ($q) => $q->orderBy('Name', 'asc')]);

        /**
         * cek jika ada request search
         */
        if ($request->search) {
            $query->where('Name', 'like', "%{$request->search}%")
                ->orWhere('Description', 'like', "%{$request->search}%")
                ->orWhereHas('MSARSCategory', fn (Builder $q) => $q->where('Name', 'like', "%{$request->search}%"));
        }

        /**
         * pagination
         */
        $arsTypes = $query->orderBy('Name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.arsip.master.type.index', compact('arsTypes'));
    }
}
