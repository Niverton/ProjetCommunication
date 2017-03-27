<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Session;
use App\Auteur;
use App\Oeuvre;
use Carbon\Carbon;

class VoteController extends Controller
{

    /**
     * Returns list of active sessions ordered by ID
     */
    private function getActiveSessions() {
        $sessions = Session::all(); 
        //On rejète toutes les sessions inactives (celles dont la date de fin est plus petite que la date actuelle)
        $filter = $sessions->reject(function ($value, $key) {
            $d = new Carbon($value->date_fin);
            return $d->lte(Carbon::now());
        });
        $filter->sortBy('id_session');
        //On préchauffe les oeuvres, réduit le nombre de requêtes plus tard
        $filter->load('oeuvres');
        return $filter;
    }

    /*
     * Shows the author list view
     */
    public function showAuthors() {
        $sessions = $this->getActiveSessions();
        $session = $sessions->last();
        if (is_null($session))
            return "Pas de session en cours !"; //TODO View

        $oeuvres = $session->oeuvres()->get(); //La liste des IDs des auteurs d'oeuvres
        $auteurs = [];
        foreach ($oeuvres as $o)
            $auteurs[] = $o->auteur_id_auteurs;
        $array = array_unique($auteurs);
        $contents = Auteur::whereIn('id_auteur', $array)->get();

        $artworks = [];
        foreach ($contents as $c) {
            $artworks[] = [
                'id' => $c->id_auteur,
                'name' => $c->nom,
                'author' => "",
                'date' => "",
                'description' => "",
                'image' => "" //TODO Un peu vide, trouvrer une solution ? Ajouter des images des auteurs à la BDD ?
            ];
        }

        //TODO temp ? Changer de vue, changer desc/titre ?
        $args = [
            'sessionDescription'=> $session->description,
            'fromDate'=> $session->date_debut,
            'toDate'=> $session->date_fin,

            'artworks'=> $artworks
        ];

        return view("vote", $args);
    }

    /*
     * Shows the author's artworks list view
     */
    public function showAuthorsContent($aut) {
        $sessions = $this->getActiveSessions();
        $session = $sessions->last();
        if (is_null($session))
            return "Pas de session en cours !"; //TODO View

        $auteur = Auteur::where('nom', urldecode($aut))->get()->last(); //Url de code remplace les %20 par des espaces par ex
        if (is_null($auteur))
            return 'Auteur non trouvé dans la session.'; //TODO

        $contents = $session->oeuvres()->where('auteur_id_auteurs', $auteur->id_auteur)->get();

        $artworks = [];
        foreach ($contents as $c) {
            $artworks[] = [
                'id' => $c->id_oeuvre,
                'name' => $c->nom,
                'author' => $c->auteur()->get()->last()->nom,
                'date' => $c->date,
                'description' => $c->description,
                'image' => $c->url_image
            ];
        }
        

        //TODO Changer desc ??
        $args = [
            'sessionDescription'=> $session->description,
            'fromDate'=> $session->date_debut,
            'toDate'=> $session->date_fin,

            'artworks'=> $artworks
        ];

        return view("vote", $args);
    }

    /*
     * Shows the artworks vue
     */
    public function showArtworks() {
        $sessions = $this->getActiveSessions();
        $session = $sessions->last();
        if (is_null($session))
            return "Pas de session en cours !"; //TODO View
        
        //On recupère toutes les oeuvres atachées à la session
        $contents = $session->oeuvres()->get();
        
        $artworks = [];
        foreach ($contents as $c) {
            $artworks[] = [
                'id' => $c->id_oeuvre,
                'name' => $c->nom,
                'author' => $c->auteur()->get()->last()->nom,
                'date' => $c->date,
                'description' => $c->description,
                'image' => $c->url_image
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

    /*
     * Upvotes an artwork in the current active session.
     * @param request: the HTTP request
     */
    public function upvote(Request $request) {
        $sessions = $this->getActiveSessions();
        $session = $sessions->last();
        //Pas vraiment certain, à voir comment les requètes AJAX fonctionnent
        if (is_null($session))
            return;

        $id = $request->input('id');

        $o = $session->oeuvres()->where('id_oeuvre', $id)->get()->last();
        if (is_null($o))
            return; //La même
        
        $session->oeuvres()->updateExistingPivot($id, ['score' => $o->pivot->score + 1]);        
    }
}
