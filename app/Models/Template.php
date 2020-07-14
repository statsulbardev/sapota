<?php

namespace App\Models;

use App\Models\Row;
use App\Models\Column;
use App\Models\Data;
use App\Models\Verification;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    // set tabel ke model
    protected $table = "templates";

    public function rowId()
    {
        return $this->belongsTo(Row::class);
    }

    public function columnId()
    {
        return $this->belongsTo(Column::class);
    }

    public function data()
    {
        return $this->hasMany(Data::class);
    }

    public function verificationId()
    {
        return $this->hasMany(Verification::class);
    }
}
