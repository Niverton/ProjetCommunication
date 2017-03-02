<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    public $primaryKey = "id_oeuvre";

    public $timestamps = false;

    public function sessions()
    {
        return $this->belongsToMany('App\Session');
    }
}

