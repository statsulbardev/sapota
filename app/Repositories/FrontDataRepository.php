<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FrontDataRepositoryInterface;
use App\Models\Verification;
use DB;

class FrontDataRepository implements FrontDataRepositoryInterface
{
    public function getListData($paginate)
    {
        return Verification::where('status', 1)->paginate($paginate);
    }

    public function getDetailData($id, $year)
    {

    }

    public function getDataByInstitution($institution_id, $paginate)
    {
        $listTables = DB::table('templates')
                      ->rightJoin('verifications', 'templates.id', '=', 'verifications.template_id')
                      ->where(['assign' => $institution_id, 'verifications.status' => 1])
                      ->paginate($paginate);

        return $listTables;
    }

    public function getTotalDataByInstitution()
    {
        $totalData = DB::table('templates')
                     ->rightJoin('verifications', 'templates.id', '=', 'verifications.template_id')
                     ->selectRaw('templates.assign, sum(verifications.status) as sum')
                     ->where('verifications.status', 1)
                     ->groupBy('templates.assign')->orderBy('sum', 'DESC')->get();

        return $totalData;
    }
}