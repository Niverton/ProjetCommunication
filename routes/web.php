<?php

/*
   |--------------------------------------------------------------------------
   | Application Routes
   |--------------------------------------------------------------------------
   |
   | Here is where you can register all of the routes for an application.
   | It is a breeze. Simply tell Lumen the URIs it should respond to
   | and give it the Closure to call when that URI is requested.
   |
 */

use App\Session;
use App\Auteur;
use App\Oeuvre;
use Carbon\Carbon;

$app->get("/", function() use ($app) {
   return '
<h1>Coucou !</h1>
<ul>
   <li> <a href="/vote">/vote</a> </li>
   <li> <a href="/admin">/admin</a> </li>
</ul>
';
});

$app->get("/vote", function() use ($app) {
   //On récupère une des sessions active
   $sessions = Session::all();
   $sessions = $sessions->reject(function ($value, $key) { //Rejète toutes les sessions inactives
      $d = new Carbon($value->date_fin);
      return $d->lte(Carbon::now());
   });
   $sessions->sortBy('id_session');
   $session = $sessions->last();
   //On récupère toutes les sessions atachées à la session
   $oeuvres = $session->oeuvres()->get();

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
});

$app->get("/admin", function() use ($app) {
   
   return "coucou :)";
   
});

