<?php

namespace App\Traits;

use App\Models\User;


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
    public function getAccess(int $userId, string $path): object
    {
        $access = User::with('menuItem')
            ->find($userId)
            ->menuItem
            ->where('href', $path)
            ->first();

        return $access->pivot;
    }
}
