<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    public $primaryKey = "id_oeuvre";

    public $timestamps = false;

    public function sessions()
    {
        return $this->belongsToMany('App\Session', "sessions_has_oeuvres", "id_oeuvres", "id_sessions")->withPivot('score');
    }

    public function auteur() {
        return $this->belongsTo('App\Auteur', "auteur_id_auteurs");
    }
}

