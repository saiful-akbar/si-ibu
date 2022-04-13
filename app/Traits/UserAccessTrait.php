<?php

namespace App\Traits;

use App\Models\User;


/**
 * Trait user access
 */
trait UserAccessTrait
{
    private $href = null;
    private $userId = null;
    private $access = null;
    private $isAdmin = false;

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
        $this->userId = !empty($userId) ? $userId : auth()->user()->id;
        $this->href = $href;

        /**
         * query menu_item berdasarkan user_id dan href
         */
        $query = User::with('menuItem')
            ->find($this->userId)
            ->menuItem()
            ->where('href', $this->href)
            ->first();

        /**
         * set properti $access
         */
        $this->access = $query->pivot;

        /**
         * set properti isAdmin jika user memiliki full akses
         */
        if (
            $this->access->create == 1 &&
            $this->access->read == 1 &&
            $this->access->update == 1 &&
            $this->access->delete == 1
        ) {
            $this->isAdmin = true;
        }

        /**
         * return access menu
         */
        return $this->access;
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
        $id = empty($userId) ? auth()->user()->id : $userId;

        /**
         * cek params $userId & $href sama atau tidak dengan nilai properti yang ada
         */
        if ($this->href == $href &&$this->userId == $id) {
            return $this->isAdmin;
        }

        /**
         * panggil method get access untuk mendapatkan akses user menu
         */
        $this->getAccess(href: $href, userId: $id);

        /**
         * return isAdmin
         */
        return $this->isAdmin;
    }
}
