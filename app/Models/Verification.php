<?php

namespace App\Models;

use App\Models\Template;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\User;

class Verification extends Model
{
    protected $table = "verifications";

    protected $casts = [
        'date_check' => 'array',
        'supervisor'  => 'array',
        'note'     => 'array'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
