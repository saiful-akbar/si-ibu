<?php

namespace App\Traits;

/**
 * Connection Trait
 */
trait ConnectionTrait
{
    /**
     * method untuk mengambil type koneksi
     *
     * @param string $conn
     *
     * @return string
     */
    public function getConnection(string $conn = 'default'): string
    {
        switch (strtolower($conn)) {
            case 'default':
                return config('database.default');
                break;

            case 'second':
                return config('database.second');
                break;

            default:
                return config('database.default');
                break;
        }
    }

    /**
     * Method untuk mengambil nama database
     *
     * @param string $db
     *
     * @return string
     */
    public function getDatabase(string $db = 'default'): string
    {
        switch (strtolower($db)) {
            case 'default':
                return config('database.db.default');
                break;

            case 'second':
                return config('database.db.second');
                break;

            default:
                return config('database.db.default');
                break;
        }
    }
}
