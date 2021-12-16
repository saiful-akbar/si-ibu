<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * View halaman user
     * 
     * @param  Request $request [description]
     * @return view
     */
    public function index(Request $request)
    {
        $search = '';
        if (isset($request->search) && !empty($request->search)) {
            $search = $request->search;
        }

        $users = User::with('profil')
            ->where('user.username', 'like', '%' . $search . '%')
            ->get();
            // ->simplePaginate(25)
            // ->withQueryString();

            dd($users);

        // return view('pages.user.index', compact('users', 'search'));
    }
}
