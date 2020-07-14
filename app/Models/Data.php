<?php

namespace App\Models;

use App\Models\Template;
use TCG\Voyager\Models\User;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    // set tabel ke model
    protected $table = 'data';

    // disable timestamps
    public $timestamps = false;

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
