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
            case 'second':
                return config('database.connections.arsip.database');
                break;

            default:
                return config('database.connections.anggaran.database');
                break;
        }
    }
}
