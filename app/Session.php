<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $primaryKey = "id_session";

    public $timestamps = false;

    public function oeuvres()
    {
        return $this->belongsToMany('App\Oeuvre', "sessions_has_oeuvres", "id_sessions", "id_oeuvres")->withPivot('score');
    }

}