<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ColumnRepositoryInterface;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as Controller;

class ColumnController extends Controller
{
    protected $column;

    /**
     * Konstruktor ColumnController.
     *
     * @param ColumnRepositoryInterface $column
     */
    public function __construct(ColumnRepositoryInterface $column)
    {
        $this->column = $column;
    }

    /**
     * Menampilkan halaman membuat variabel kolom.
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
     * Menyimpan data kolom ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:255',
            'item' => 'required'
        ));

        $this->column->storeColumnName($request->name);

        $column = $this->column->getColumnByName($request->name);

        $this->column->storeColumnDetail($column, $request->item);

        return redirect()
            ->route("voyager.columns.index")
            ->with([
                'message'    => "Sukses Membuat Variabel Baru",
                'alert-type' => 'success',
            ]);
     }

    /**
     * Menampilkan halaman mengedit variabel kolom.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $value = $this->params();

        $column = $this->column->getColumnById($id);

        $items = $this->column->getColumnDetail($column);

        return view('vendor.voyager.component.edit',
            compact('column', 'items', 'value'));
    }

    /**
     * Mengupdate informasi variabel kolom.
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

        $this->column->updateColumnName($id, $request->name);

        $column = $this->column->getColumnById($id);

        $this->column->updateColumnDetail($column, $request->item);

        return redirect()
            ->route("voyager.columns.index")
            ->with([
                'message'    => "Sukses Memperbaharui Variabel",
                'alert-type' => 'success',
            ]);
    }

    /**
     * Menghapus informasi variabel kolom.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $column = $this->column->getColumnById($id);

        $this->column->deleteColumnDetail($column);

        $this->column->deleteColumnName($id);

        return redirect()
            ->route("voyager.columns.index")
            ->with([
                'message'    => "Sukses Menghapus Variabel",
                'alert-type' => 'success',
            ]);
    }

    /**
     * Konfigurasi label untuk halaman kolom.
     *
     * @param String $route
     * @return Value
     */
    private function params($route = 'edit')
    {
        ($route === 'create') ? $default = route('voyager.columns.store') : $default = "columns";

        $val = array(
            "route"       => $default,
            "judulPendek" => "Variabel - Kolom",
            "judul"       => "Membuat Variabel Kolom dan Indikatornya",
            "labelNama"   => "Nama Variabel",
            "placeNama"   => "Misalnya 'Jenis Kelamin', 'Status Pekerjaan'",
            "labelItem"   => "Indikator Variabel",
            "placeItem"   => "Misalnya 'Laki-laki', 'Perempuan', 'Mencari Kerja', 'Bekerja', dll"
        );

        return $val;
    }
}
