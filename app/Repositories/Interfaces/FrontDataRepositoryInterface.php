<?php

namespace App\Repositories\Interfaces;

interface FrontDataRepositoryInterface
{
    /**
     * Mengambil seluruh informasi daftar data
     * yang sudah disetujui untuk tampil.
     *
     * @param int $paginate
     * @return void
     */
    public function getListData($paginate);

    /**
     * Mengambil informasi data menurut id dan tahun data.
     *
     * @param int $id
     * @param int $year
     * @return mix
     */
    public function getDetailData($id, $year);

    /**
     * Mengambil informasi data menurut ID instansi.
     *
     * @param int $institution_id
     * @param int $paginate
     * @return void
     */
    public function getDataByInstitution($institution_id, $paginate);

    /**
     * Mengambil informasi jumlah data yang boleh ditampilkan
     * menurut instansi.
     *
     * @return void
     */
    public function getTotalDataByInstitution();
}