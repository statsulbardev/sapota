<?php

namespace App\Models;

use App\Models\Column;
use Illuminate\Database\Eloquent\Model;

class ColumnDetail extends Model
{
    // set tabel ke model
    protected $table = 'column_details';

    // Set Mass Assignment ketika insert data ke database
    protected $fillable = ['name', 'column_id'];

    // Set relasi inverse ke model Variable
    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}
