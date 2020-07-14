<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\RowRepositoryInterface;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as Controller;

class RowController extends Controller
{
    protected $row;

    /**
     * Konstruktor RowController
     *
     * @param RowRepositoryInterface $row
     */
    public function __construct(RowRepositoryInterface $row)
    {
        $this->row = $row;
    }

    /**
     * Menampilkan halaman membuat variabel baris.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $value = $this->params('create');
        
        return view('vendor.voyager.component.add', compact('value'));
    }

    /**
     * Menyimpan data baris ke dalam database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:255',
            'item' => 'required'
        ));

        $this->row->storeRowName($request->name);

        $row = $this->row->getRowByName($request->name);

        $this->row->storeRowDetail($row, $request->item);

        return redirect()
            ->route("voyager.rows.index")
            ->with([
                'message'    => "Sukses Membuat Variabel Baru",
                'alert-type' => 'success',
            ]);
     }

    /**
     * Menampilkan halaman mengedit variabel baris.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $value = $this->params();

        $row = $this->row->getRowById($id);

        $items = $this->row->getRowDetail($row);

        return view('vendor.voyager.component.edit',
            compact('row', 'items', 'value'));
    }

    /**
     * Mengupdate informasi variabel baris.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            "name" => "required|max:255",
            "item" => "required"
        ));

        $this->row->updateRowName($id, $request->name);

        $row = $this->row->getRowById($id);

        $this->row->updateRowDetail($row, $request->item);

        return redirect()
            ->route("voyager.rows.index")
            ->with([
                'message'    => "Sukses Memperbaharui Variabel",
                'alert-type' => 'success',
            ]);
    }

    /**
     * Menghapus informasi variabel baris.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $row = $this->row->getRowById($id);

        $this->row->deleteRowDetail($row);

        $this->row->deleteRowName($id);

        return redirect()
            ->route("voyager.rows.index")
            ->with([
                'message'    => "Sukses Menghapus Variabel",
                'alert-type' => 'success',
            ]);
    }

    /**
     * Konfigurasi label untuk halaman baris.
     *
     * @param String $route
     * @return Value
     */
    private function params($route = 'edit')
    {
        ($route === 'create') ? $default = route('voyager.rows.store') : $default = "rows";

        $val = array(
            "route"       => $default,
            "judulPendek" => "Variabel - Baris",
            "judul"       => "Membuat Variabel Baris dan Indikatornya",
            "labelNama"   => "Nama Variabel",
            "placeNama"   => "Misalnya 'Wilayah', 'Tingkat Pendidikan'",
            "labelItem"   => "Indikator Variabel",
            "placeItem"   => "Misalnya 'Majene', 'Mamuju', 'SD', 'SMP', 'SMA' dll"
        );

        return $val;
    }
}
