<?php

namespace App\Repositories\Interfaces;

use App\Models\Row;

interface RowRepositoryInterface
{
    /**
     * Mendapatkan seluruh informasi variabel baris.
     *
     * @return mixed
     */
    public function all();

    /**
     * Mendapatkan informasi variabel baris berdasarkan ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getRowById($id);

    /**
     * Mendapatkan informasi variabel baris berdasarkan nama baris.
     *
     * @param string $name
     * @return mixed
     */
    public function getRowByName($name);

    /**
     * Menyimpan informasi judul variabel baris.
     *
     * @param String $name
     * @return mixed
     */
    public function storeRowName($name);

    /**
     * Mengupdate informasi judul variabel baris.
     *
     * @param Int $id
     * @param String $name
     * @return mixed
     */
    public function updateRowName($id, $name);

    /**
     * Menghapus informasi judul variabel baris.
     *
     * @param int $id
     * @return mixed
     */
    public function deleteRowName($id);

    /**
     * Menampilkan informasi setiap item variabel baris.
     *
     * @param Row $row
     * @return mixed
     */
    public function getRowDetail(Row $row);

    /**
     * Menyimpan informasi setiap item variabel baris.
     *
     * @param Row $row
     * @param Array $items
     * @return void
     */
    public function storeRowDetail(Row $row, array $items);

    /**
     * Mengupdate informasi setiap item variabel baris.
     *
     * @param Row $row
     * @param array $items
     * @return void
     */
    public function updateRowDetail(Row $row, array $items);

    /**
     * Menghapus informasi setiap item variabel baris.
     *
     * @param Row $row
     * @return mixed
     */
    public function deleteRowDetail(Row $row);
}