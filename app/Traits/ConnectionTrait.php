<?php

namespace App\Traits;

/**
 * Connection Trait
 */
trait ConnectionTrait
{
    private $anggaran = 'anggaran';
    private $arsip = 'arsip';

    /**
     * method untuk mengambil type koneksi
     *
     * @param string $conn
     *
     * @return string
     */
    public function getConnection(string $conn = 'anggaran'): string
    {
        if (strtolower($conn) == 'anggaran' || strtolower($conn) == 'first') {
            return $this->anggaran;
        }

        return $this->arsip;
    }

    /**
     * Method untuk merubah nama koneksi
     *
     * @param string $conn
     * @param string $value
     *
     * @return void
     */
    public function setConnection(string $conn = 'anggaran', string $value): void
    {
        if (strtolower($conn) == 'anggaran' || strtolower($conn) == 'first') {
            $this->anggaran = $value;
        } else {
            $this->arsip = $value;
        }
    }
}
