<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $users = User::with(['role', 'divisi'])->get();

    foreach ($users as $user) {
        echo 'username => ' . $user->username . '; role level => ' . $user->role->level . '; Divisi => ' . $user->divisi->nama_divisi . '<br/>';
    }
});
