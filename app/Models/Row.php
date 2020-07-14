<?php

namespace App\Models;

use App\Models\Template;
use App\Models\RowDetail;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    //set tabel ke model
    protected $table = 'rows';

    public function template()
    {
        return $this->hasMany(Template::class);
    }

    public function rowDetail()
    {
        return $this->hasMany(RowDetail::class);
    }
}
