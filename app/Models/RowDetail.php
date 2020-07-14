<?php

namespace App\Models;

use App\Models\Row;
use Illuminate\Database\Eloquent\Model;

class RowDetail extends Model
{
    // set tabel ke model
    protected $table = 'row_details';

    // Set Mass Assignment ketika insert data ke database
    protected $fillable = ['name', 'row_id'];

    // set relasi inverse ke model RowGroup
    public function row()
    {
        return $this->belongsTo(Row::class);
    }
}
