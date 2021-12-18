<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $user = User::with('menuHeader', 'menuItem')->find(1);

        // dd($user->menuItem->find(1));

        return view('pages.dashboard.index');
    }
}
