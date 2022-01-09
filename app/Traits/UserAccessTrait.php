<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;


/**
 * Trait user access
 */
trait UserAccessTrait
{
    /**
     * Method get user access
     *
     * @param int $userId
     * @param string $path
     *
     * @return object
     */
    public function getAccess(int $userId = null, string $href = '/dashboard'): object
    {
        $id = Auth::user()->id;

        if ($userId != null) {
            $id = $userId;
        }

        $access = User::with('menuItem')
            ->find($id)
            ->menuItem()
            ->where('href', $href)
            ->first();

        return $access->pivot;
    }

    /**
     * Method untung mengecek apakah user sebagai admin pada menu tertentu
     *
     * @param string $path
     * @param int|null $userId
     *
     * @return bool
     */
    public function isAdmin(string $href = '/dashboard', int $userId = null): bool
    {
        $userAccess = $this->getAccess(href: $href, userId: $userId);

        if (
            $userAccess->create == 1 &&
            $userAccess->read == 1 &&
            $userAccess->update == 1 &&
            $userAccess->delete == 1
        ) {
            return true;
        }

        return false;
    }
}
