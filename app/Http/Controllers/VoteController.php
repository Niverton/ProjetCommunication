<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Session;
use App\Auteur;
use App\Oeuvre;
use Carbon\Carbon;

class VoteController extends Controller
{

    /*
     * @brief: Returns the latest active session
     */
    private function getActiveSession() {
        $sessions = Session::all();
        $sessions = $sessions->reject(function ($value, $key) { //Permet de rejeter les sessions inactives
            $d = new Carbon($value->date_fin);
            return $d->lte(Carbon::now());
        });
        $sessions->sortBy('id_session');
        return $sessions->last();
    }

    public function show() {
        $session = $this->getActiveSession();
        $oeuvres = $session->oeuvres()->get(); //Permet de récupérer les oeuvres attachées à une session

        $artworks = [];
        foreach ($oeuvres as $oeuvre) {
            $artworks[] = [
            'id' => $oeuvre->id_oeuvre,
            'name' => $oeuvre->nom,
            'author' => $oeuvre->auteur()->get()->last()->nom,
            'date' => $oeuvre->date,
            'description' => $oeuvre->description,
            'image' => $oeuvre->url_image
            ];
        }
        $args = [
            'sessionDescription'=> $session->description,
            'fromDate'=> $session->date_debut,
            'toDate'=> $session->date_fin,

            'artworks'=> $artworks
        ];

        return view("vote", $args);
    }
}
