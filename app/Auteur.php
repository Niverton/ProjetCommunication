<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    public $primaryKey = "id_auteur";

    public $timestamps = false;

    public function oeuvres() {
        return $this->hasMany('App\Oeuvre', 'auteur_id_auteurs');
    }
}