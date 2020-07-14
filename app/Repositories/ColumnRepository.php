<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ColumnRepositoryInterface;
use App\Models\Column;
use App\Models\ColumnDetail;
use DB;

class ColumnRepository implements ColumnRepositoryInterface
{
    public function all()
    {
        return Column::all();
    }

    public function getColumnById($id)
    {
        return Column::where('id', $id)->first();
    }

    public function getColumnByName($name)
    {
        return Column::where('name', $name)->first();
    }

    public function storeColumnName($name)
    {
        return DB::table('columns')
               ->insert(['name' => $name]);
    }

    public function updateColumnName($id, $name)
    {
        return DB::table('columns')
               ->where('id', $id)
               ->update(['name' => $name]);
    }

    public function deleteColumnName($id)
    {
        return DB::table('columns')
               ->where('id', $id)
               ->delete();
    }

    public function getColumnDetail(Column $column)
    {
        return $column->columnDetail()->get();
    }

    public function storeColumnDetail(Column $column, array $items)
    {
        for($i = 0; $i < count($items); $i++) {
            $item = new ColumnDetail(['name' => $items[$i]]);
            $column->columnDetail()->save($item);
        }
    }

    public function updateColumnDetail(Column $column, array $items)
    {
        $this->deleteColumnDetail($column);

        $this->storeColumnDetail($column, $items);
    }

    public function deleteColumnDetail(Column $column)
    {
        return $column->columnDetail()->delete();
    }
}
