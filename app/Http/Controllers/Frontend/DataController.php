<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Row;
use App\Models\Column;
use App\Models\Template;
use App\Models\TemplateData;
use App\Repositories\Interfaces\FrontDataRepositoryInterface;

class DataController extends Controller
{
    protected $data;

    /**
     * Konstruktor FrontDataController.
     *
     * @param FrontDataRepositoryInterface $data
     */
    public function __construct(FrontDataRepositoryInterface $data)
    {
        $this->data = $data;
    }

    /**
     * Menampilkan daftar seluruh tabel yang sudah layak tampil
     * ke halaman data di frontend.
     *
     * @return view
     */
    public function showListData()
    {
        $listOfData = $this->data->getListData(10);
        $sumOfData  = $this->data->getTotalDataByInstitution();

        return view('frontend.data.data', compact('listOfData', 'sumOfData'));
    }

    /**
     * Menampilkan halaman detail dari tabel yang ditampilkan
     *
     * @param int $id as indikator
     * @param int $year as tahun data
     * @return view
     */
    public function showDataDetail($id, $year)
    {
        $template = Template::findOrFail($id);

        $row = Row::where('id', $template->row_id)->first();
        $rowDetail = $row->rowDetail()->get();

        $columnDecode = json_decode($template->column_id);

        $column = $columnDetail = array();

        for($i = 0; $i < count($columnDecode); $i++) {
            $column[$i] = Column::where('id', $columnDecode[$i])->first();
            $columnDetail[$i] = $column[$i]->columnDetail()->get();
        }

        $data = Data::where(['template_id' => $id, 'year' => $year])->get();

        $templateData = TemplateData::where([
            'template_id' => $id,
            'year_id'     => $year
        ])->get();

        return view('frontend.data.detail', compact(
            'template',
            'data',
            'row',
            'rowDetail',
            'column',
            'columnDetail',
            'templateData'
        ));
    }

    /**
     * Menampilkan daftar data menurut instansi pemiliki data.
     *
     * @param integer $institution_id
     * @return view
     */
    public function showDataByInstitution($institution_id)
    {
        $listOfData = $this->data->getDataByInstitution($institution_id, 10);
        $sumOfData  = $this->data->getTotalDataByInstitution();

        return view('frontend.data.institution', compact('listOfData', 'sumOfData'));
    }
}
