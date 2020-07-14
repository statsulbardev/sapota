<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Row;
use App\Models\Column;
use App\Models\Data;
use App\Models\Verification;
use App\Models\TemplateData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use TCG\Voyager\Models\User;
use DB;

class DataController extends Controller
{
    public function index()
    {
        // retrieve informasi indikator berdasarkan id user
        $templates = Template::where('assign', Auth::id())->get();
        // retrieve pemeriksaan terakhir dari setiap indikator yang dimiliki berdasarkan id user
        $verifications = array();
        $index = 0;
        foreach($templates as $template) {
            if($template->number_of_tables === 0) continue;
            $check = $template->verificationId()->orderBy('updated_at', 'desc')->get();
            if(count($check) >= 1) {
                foreach($check as $item) array_push($verifications, $item);
            }
        }

        return view('vendor.voyager.data.browse', compact('templates', 'verifications'));
    }

    public function show($id, $year = null)
    {
        $template = Template::findOrFail($id);

        if($template->number_of_table === 0) {
            if($year === null) {
                $output = view('_include._notfound')->render();
                return response()->json([
                    'success' => true,
                    'output'  => $output
                ]);
            } else {
                $output = view('_include._notfound')->render();
                return response()->json([
                    'success'     => true,
                    'output'      => $output,
                    'contentzone' => true
                ]);
            }
        } else {
            $supervisors = array();
            $contentzone = false;

            ($year === null) ?
                $supervisors = $template->verificationId()
                               ->orderBy('year', 'desc')
                               ->orderBy('updated_at', 'desc')
                               ->get() :

                array_push(
                    $supervisors,
                    $template->verificationId()
                    ->where('year', $year)
                    ->orderBy('updated_at', 'desc')
                    ->first()
                );

            if($supervisors[0] !== null) {
                $output = view('_include._data', ['pemeriksaan' => $supervisors])->render();
            } else {
                $output = view('_include._notfound')->render();
                $contentzone = true;
            }

            return response()->json([
                'success'     => true,
                'output'      => $output,
                'contentzone' => $contentzone
            ]);
        }
    }

    public function create($id, $year)
    {
        $tahapan = 'tambah';

        $template = Template::findOrFail($id);

        // mendapatkan judul baris "$row->name"
        $row = Row::where('id', $template->row_id)->first();
        // mendapatkan item baris yang berelasi dengan judul baris
        $rowDetail = $row->rowDetail()->get();

        $columnDecoded = json_decode($template->column_id);

        $column = $columnDetail = array();

        for($i = 0; $i < count($columnDecoded); $i++) {
            // mendapatkan judul kolom "$column->name"
            $column[$i] = Column::where('id', $columnDecoded[$i])->first();
            // mendapatkan item kolom yang berelasi dengan judul kolom
            $columnDetail[$i] = $column[$i]->columnDetail()->get();
        }

        return view('vendor.voyager.data.add-edit-table', compact(
            'tahapan',
            'template',
            'row',
            'rowDetail',
            'column',
            'columnDetail',
            'year'
        ));
    }

    public function save($id, $year)
    {
        $informasi = Input::get();

        $templateData = new TemplateData;
        $templateData->template_id = $id;
        $templateData->year_id = $year;

        foreach($informasi as $nama => $nilai) {
            if($nama !== "_token") {
                if ($nama === "source") {
                    (!is_null($nilai)) ?
                        $templateData->source = $nilai :
                        $templateData->source = Auth::user()->name;
                } else if ($nama === 'description') {
                    $templateData->description = $nilai['description'];
                } else {
                    DB::table('data')->insert([
                        'template_id'      => $id,
                        'row_id'           => explode('_', $nama)[0],
                        'row_detail_id'    => explode('_', $nama)[1],
                        'column_id'        => explode('_', $nama)[2],
                        'column_detail_id' => explode('_', $nama)[3],
                        'value'            => doubleval($nilai),
                        'year'             => $year
                    ]);
                }
            }
        }

        $templateData->save();

        // update jumlah_tabel di tabel indikator
        $template    = Template::findOrFail($id);
        $numOfTable  = $template->number_of_tables;
        $numOfTable  = $numOfTable + 1;

        $template->number_of_tables = $numOfTable;
        $template->save();

        // isian awal tabel pemeriksaan
        $verification = new Verification;
        $verification->template_id = $id;
        $verification->year = $year;
        $verification->check = false;
        $verification->status = false;
        $verification->note = array();
        $verification->date_check = array();
        $verification->supervisor = array();
        $verification->save();

        return redirect()
            ->route('voyager.data.index')
            ->with([
                'message'    => 'Sukses Menambahkan Tabel Baru',
                'alert-type' => 'success'
            ]);
    }

    public function edit($id, $year)
    {
        $tahapan = 'edit';
        // ambil indikator_id dan tahun berdasarkan id pemeriksa
        $verification = Verification::findOrFail($id);
        // ambil informasi indikator
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

        $data = Data::where('template_id', $verification->template_id)
            ->where('year', $verification->year)->get();

        $templateData = TemplateData::where('template_id', $verification->template_id)->get();

        return view('vendor.voyager.data.add-edit-table', compact(
            'tahapan',
            'data',
            'verification',
            'template',
            'row',
            'rowDetail',
            'column',
            'columnDetail',
            'year',
            'templateData'
        ));
    }

    public function update($id, $year)
    {
        // ambil semua hasil inputan
        $informasi = Input::get();

        foreach($informasi as $nama => $nilai) {
            if($nama !== "_token" && $nama !== "_method") {
                Data::where('id', $nama)
                ->update(['value' => doubleval($nilai)]);
            }
        }

        Verification::where('template_id', $id)
                 ->where('year', $year)
                 ->update([
                    'check'  => false,
                    'status' => false,
                 ]);

        return redirect()
            ->route('voyager.data.index')
            ->with([
                'message'    => 'Sukses Memperbaharui Tabel',
                'alert-type' => 'success'
            ]);
    }

    public function view($id, $year)
    {
        // ambil informasi pemeriksa
        $verification = Verification::findOrFail($id);
        // ambil informasi indikator
        $template = Template::findOrFail($verification->template_id);
        // mendapatkan judul baris dan item baris
        $row = Row::where('id', $template->row_id)->first();
        $rowDetail = $row->rowDetail()->get();

        $columnDecoded = json_decode($template->column_id);

        $column = $columnDetail = array();

        for($i = 0; $i < count($columnDecoded); $i++) {
            // mendapatkan judul kolom "$column->name"
            $column[$i] = Column::where('id', $columnDecoded[$i])->first();
            // mendapatkan item kolom yang berelasi dengan judul kolom
            $columnDetail[$i] = $column[$i]->columnDetail()->get();
        }

        // data dari tabel
        $data = Data::where('template_id', $verification->template_id)
                ->where('year', $verification->year)->get();

        // nama pemeriksa
        $supervisor = $verification->user()->associate(User::find($verification->supervisor));

        $templateData = TemplateData::where('template_id', $verification->template_id)->get();

        return view('vendor.voyager.data.view', compact(
            'verification',
            'template',
            'data',
            'row',
            'rowDetail',
            'column',
            'columnDetail',
            'supervisor',
            'templateData'
        ));
    }

    public function destroy($id, $year)
    {
        $verification = Verification::where([
            'id'   => $id,
            'year' => $year
        ])->get();

        $template_id = $verification[0]->template_id;

        // hapus record pemeriksa by $id
        Verification::where([
            'id'   => $id,
            'year' => $year
        ])->delete();

        // hapus data by id dan tahun
        Data::where([
            'template_id' => $template_id,
            'year'        => $year
        ])->delete();

        // hapus data template
        TemplateData::where([
            'template_id' => $template_id,
            'year_id'     => $year
        ])->delete();

        $template   = Template::findOrFail($template_id);
        $numOfTable = $template->number_of_tables;
        $numOfTable = $numOfTable - 1;

        // update jumlah tabel
        $template->number_of_tables = $numOfTable;
        $template->save();

        return back();
    }
}
