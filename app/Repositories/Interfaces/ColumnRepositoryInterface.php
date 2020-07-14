<?php

namespace App\Repositories\Interfaces;

use App\Models\Column;

interface ColumnRepositoryInterface
{
    /**
     * Mendapatkan seluruh informasi variabel kolom.
     *
     * @return mixed
     */
    public function all();

    /**
     * Mendapatkan informasi variabel kolom berdasarkan ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getColumnById($id);

    /**
     * Mendapatkan informasi variabel kolom berdasarkan nama kolom.
     *
     * @param string $name
     * @return mixed
     */
    public function getColumnByName($name);

    /**
     * Menyimpan informasi judul variabel kolom.
     *
     * @param String $name
     * @return mixed
     */
    public function storeColumnName($name);

    /**
     * Mengupdate informasi judul variabel kolom.
     *
     * @param Int $id
     * @param String $name
     * @return mixed
     */
    public function updateColumnName($id, $name);

    /**
     * Menghapus informasi judul variabel kolom.
     *
     * @param int $id
     * @return mixed
     */
    public function deleteColumnName($id);

    /**
     * Menampilkan informasi setiap item variabel kolom.
     *
     * @param Column $column
     * @return mixed
     */
    public function getColumnDetail(Column $column);

    /**
     * Menyimpan informasi setiap item variabel kolom.
     *
     * @param Column $column
     * @param Array $items
     * @return void
     */
    public function storeColumnDetail(Column $column, array $items);

    /**
     * Mengupdate informasi setiap item variabel kolom.
     *
     * @param Column $column
     * @param array $items
     * @return void
     */
    public function updateColumnDetail(Column $column, array $items);

    /**
     * Menghapus informasi setiap item variabel kolom.
     *
     * @param Column $column
     * @return mixed
     */
    public function deleteColumnDetail(Column $column);
}