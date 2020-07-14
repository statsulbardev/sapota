<?php

namespace App\Models;

use App\Models\Template;
use App\Models\ColumnDetail;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    // set tabel ke model
    protected $table = 'columns';

    // set eloquent relation
    public function template()
    {
        return $this->hasMany(Template::class);
    }

    public function columnDetail()
    {
        return $this->hasMany(ColumnDetail::class);
    }
}
