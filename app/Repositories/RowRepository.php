<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RowRepositoryInterface;
use App\Models\Row;
use App\Models\RowDetail;
use DB;

class RowRepository implements RowRepositoryInterface
{
    public function all()
    {
        return Row::all();
    }

    public function getRowById($id)
    {
        return Row::where('id', $id)->first();
    }

    public function getRowByName($name)
    {
        return Row::where('name', $name)->first();
    }

    public function storeRowName($name)
    {
        return DB::table('rows')
               ->insert(['name' => $name]);
    }

    public function updateRowName($id, $name)
    {
        return DB::table('rows')
               ->where('id', $id)
               ->update(['name' => $name]);
    }

    public function deleteRowName($id)
    {
        return DB::table('rows')
               ->where('id', $id)
               ->delete();
    }

    public function getRowDetail(Row $row)
    {
        return $row->rowDetail()->get();
    }

    public function storeRowDetail(Row $row, array $items)
    {
        for($i = 0; $i < count($items); $i++) {
            $item = new RowDetail(['name' => $items[$i]]);
            $row->rowDetail()->save($item);
        }
    }

    public function updateRowDetail(Row $row, array $items)
    {
        $this->deleteRowDetail($row);

        $this->storeRowDetail($row, $items);
    }

    public function deleteRowDetail(Row $row)
    {
        return $row->rowDetail()->delete();
    }
}
