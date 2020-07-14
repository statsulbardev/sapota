<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Verification;
use App\Models\Row;
use App\Models\Column;
use App\Models\Data;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use TCG\Voyager\Models\User;
use DB;

class VerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // header query
        $tableInfo   = Verification::all();

        // table check
        $datas = DB::table('users')
                 ->rightJoin('templates', 'users.id', '=', 'templates.assign')
                 ->rightJoin('verifications', 'templates.id', '=', 'verifications.template_id')
                 ->select(
                    'users.name',
                    'templates.name',
                    'verifications.id',
                    'verifications.year',
                    'verifications.check',
                    'verifications.status'
                 )->get();

        return view('vendor.voyager.verifications.browse', compact(
            'tableInfo',
            'datas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchIndikator(Request $request)
    {
        $id_instansi = $request->input('instansi');

        if($id_instansi === 0) {
            $output = '<option value="">Pilih Indikator</option>';
            echo $output;
        } else {
            $template = Template::where('assign', $id_instansi)->get();
            $output = '<option value="0">Pilih Indikator</option>';
            foreach($template as $item) {
                $output .= '<option value="'. $item->id .'">'. $item->name .'</option>';
            }
            echo $output;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function fetchData($id)
    {
        // Ambil informasi indikator dengan $id
        $template = Template::findOrFail($id);

        if($template->number_of_tables === 0) {
            $output = view('_include._notfound')->render();
            echo $output;
        } else {
            // ambil data unik menurut indikator_id dan tahun
            // $data return collection see https://laravel.com/docs/5.8/collections
            // $data = Data::distinct()->where('indikator_id', $id)->get(['indikator_id', 'tahun']);

            // ambil data pemeriksa seluruh tahun berdasarkan $id
            // $pemeriksa = Pemeriksa::where('indikator_id', $id)->get();
            $verification = Verification::where('template_id', $id)
                            ->orderBy('year', 'desc')
                            ->orderBy('updated_at', 'desc')
                            ->get();

            $output = view('_include._table', [
                        'indikator' => $template,
                        'pemeriksaan' => $verification])->render();

            echo $output;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @param [type] $tahun
     * @return void
     */
    public function view($id, $year)
    {
        // mengambil informasi indikator
        $verification = Verification::findOrFail($id);

        // mengambil data tahun dan tahun - 1 untuk diperiksa
        $template = Template::findOrFail($verification->template_id);
        // mendapatkan judul baris
        $row = Row::where('id', $template->row_id)->first();
        // mendapatkan item baris
        $rowDetail = $row->rowDetail()->get();

        $columnDecoded = json_decode($template->column_id);

        $column = $columnDetail = array();

        for($i = 0; $i < count($columnDecoded); $i++) {
            // mendapatkan judul kolom
            $column[$i] = Column::where('id', $columnDecoded[$i])->first();
            // mendapatkan item kolom
            $columnDetail[$i] = $column[$i]->columnDetail()->get();
        }

        $data = Data::where([
            'template_id' => $template->id,
            'year' => $year
        ])->get();

        $old_data = Data::where([
            'template_id' => $template->id,
            'year' => ($year - 1)
        ])->get();

        return view('vendor.voyager.verifications.view', compact(
            'verification',
            'template',
            'row',
            'rowDetail',
            'column',
            'columnDetail',
            'year',
            'data',
            'old_data'
        ));
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @param [type] $tahun
     * @return void
     */
    public function store(Request $request, $id, $year)
    {
        $verification = Verification::findOrFail($id);

        $verification->check = true;
        $verification->year  = $year;

        $note = $verification->note;
        $data_catatan = (is_null($request->catatan)) ? 'Tidak Ada Catatan' : $request->catatan;
        array_push($note, $data_catatan);
        $verification->note = $note;

        $date = $verification->date_check;
        array_push($date, Carbon::now());
        $verification->date_check = $date;

        $supervisor = $verification->supervisor;
        array_push($supervisor, Auth::id());
        $verification->supervisor = $supervisor;

        $verification->status = $request->status;
        $verification->save();

        return back()
            ->with([
                    'message'    => "Informasi Berhasil Disimpan",
                    'alert-type' => 'success',
                ]);
    }

    public function getDataByStatus($check, $status)
    {
        $tableInfo  = Verification::all();

        $data = Verification::where([
                    'check'  => $check,
                    'status' => $status
                ])->get();

        return compact('tableInfo', 'data');
        // return json_encode($array_data);
    }
}
