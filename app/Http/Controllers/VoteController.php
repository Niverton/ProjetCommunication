<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Session;
use App\Auteur;
use App\Oeuvre;

use Carbon\Carbon;

class VoteController extends Controller
{

    /*
     * Returns list of active sessions ordered by ID
     */
    private function getActiveSessions()
		{
        $sessions = Session::all();

        //On rejète toutes les sessions inactives (celles dont la date de fin est plus petite que la date actuelle)
        $filter = $sessions->reject(function ($value, $key) {
            $d = new Carbon($value->date_fin);
            return $d->lte(Carbon::now());
        });

        //On trie les sessions par ID
        $filter->sortBy('id_session');
        //On préchauffe les oeuvres, réduit le nombre de requêtes plus tard
        $filter->load('oeuvres');

        return $filter;
    }



    /*
     * Shows the author list view
     */
    public function showAuthors()
		{
        $sessions = $this->getActiveSessions();

        $session = $sessions->last();
        if (is_null($session))
            return "Pas de session en cours !"; //TODO View

				//On récupère la liste des IDs des auteurs
        $oeuvres = $session->oeuvres()->get();
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
                'image' => "" //TODO Un peu vide, trouver une solution ? Ajouter des images des auteurs à la BDD ?
            ];
        }

        //TODO Temp ? Changer de vue, changer desc/titre ?
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
    public function showAuthorsContent($aut)
		{
        $sessions = $this->getActiveSessions();

        $session = $sessions->last();
        if (is_null($session))
            return "Pas de session en cours !"; //TODO View

        $auteur = Auteur::where('id_auteur', urldecode($aut))->get()->last();
        if (is_null($auteur))
            return 'Auteur non trouvé dans la session.'; //TODO
        $contents = $session->oeuvres()->where('auteur_id_auteurs', $auteur->id_auteur)->get();

        $artworks = [];
        foreach ($contents as $c) {
            $a = $c->auteur()->get()->last();
            $artworks[] = [
                'id' => $c->id_oeuvre,
                'name' => $c->nom,
                'author' => $a->nom,
                'author_id' => $a->id_auteur,
                'date' => $c->date,
                'description' => $c->description,
                'image' => $c->url_image
            ];
        }

        //TODO Changer desc ?
        $args = [
            'id' => $session->id,
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

        //On récupère toutes les oeuvres attachées à la session
        $contents = $session->oeuvres()->withPivot('score')->orderBy('score', 'desc')->get();

        $artworks = [];
        foreach ($contents as $c) {
            $a = $c->auteur()->get()->last();
            $artworks[] = [
                'id' => $c->id_oeuvre,
                'name' => $c->nom,
                'author' => $a->nom,
                'author_id' => $a->id_auteur,
                'date' => $c->date,
                'description' => $c->description,
                'image' => $c->url_image
            ];
        }

        $args = [
            'sessionId' => $session->id_session,
            'sessionDescription'=> $session->description,
            'fromDate'=> $session->date_debut,
            'toDate'=> $session->date_fin,
            'artworks'=> $artworks
        ];

        return view("vote", $args);
    }



    /*
     * Upvotes an artwork in the current active session
     * @param id: oeuvre id
     * @return: "true" if the request went ok, "false" if there was an error
     */
    public function upvote($id) {
        $isOK = "false"; //Code retour requète

        $sessions = $this->getActiveSessions();
        $session = $sessions->last();
        
        
        if (!is_null($session)) {
            $o = $session->oeuvres()->where('id_oeuvre', $id)->get()->last();
            if (!is_null($o)) {
                $session->oeuvres()->updateExistingPivot($id, ['score' => $o->pivot->score + 1]);  
                $isOK = "true";
            }
        }
        
        return $isOK;
    }

}
