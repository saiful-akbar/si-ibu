<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMenuAccess
{
    /**
     * Cek hak akses user untuk setiap menu dan
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $path, $access)
    {
        $menuItem = User::with('menuItem')->find(Auth::user()->id)->menuItem->where('href', $path)->first();

        if (!empty($menuItem)) {
            if ($access == 'create' && $menuItem->pivot->create == 1) {
                return $next($request);
            }

            if ($access == 'read' && $menuItem->pivot->read == 1) {
                return $next($request);
            }

            if ($access == 'update' && $menuItem->pivot->update == 1) {
                return $next($request);
            }

            if ($access == 'delete' && $menuItem->pivot->delete == 1) {
                return $next($request);
            }

            return abort(403);
        }

        return abort(404);
    }
}
