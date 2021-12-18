<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMenuAkses
{
    /**
     * Cek hak akses user untuk setiap menu dan
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $menu, $akses)
    {
        $menuItem = User::with('menuItem')
            ->find(Auth::user()->id)
            ->menuItem
            ->where('nama_menu', strtolower($menu))
            ->first();

        if (!empty($menuItem)) {
            if ($akses == 'create' && $menuItem->pivot->create == 1) {
                return $next($request);
            }

            if ($akses == 'read' && $menuItem->pivot->read == 1) {
                return $next($request);
            }

            if ($akses == 'update' && $menuItem->pivot->update == 1) {
                return $next($request);
            }

            if ($akses == 'delete' && $menuItem->pivot->delete == 1) {
                return $next($request);
            }

            return abort(403);
        }

        return abort(404);
    }
}
