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

$app->get("/", function() use ($app) {
   return '
<h1>Coucou !</h1>
<ul>
  <li> <a href="/vote">/vote</a> </li>
  <li> <a href="/vote/auteurs">/vote/auteurs</a> </li>
  <li> <a href="/admin/create">/admin/create</a> </li>
</ul>
';
});

/* Liste d'auteurs de la session active */
$app->get("/vote/auteurs", 'VoteController@showAuthors');

/* Liste des oeuvres de {auteur} */
$app->get("/vote/auteurs/{auteur}", 'VoteController@showAuthorsContent');

/* Liste des oeuvres de la session active */
$app->get("/vote", 'VoteController@showArtworks');

/* Upvote */
$app->get("/vote/upvote/{id}", 'VoteController@upvote');

$app->get("/admin/create", "AdminController@createSession");
$app->get("/admin/create/add_to_cart/{id}", "AdminController@addToCart");
$app->get("/admin/create/remove_from_cart/{id}", "AdminController@removeFromCart");
$app->post("/admin/create/submit", "AdminController@submitSession");

//TODO REMOVE ME
$app->get("/test/{data}", "AdminController@test");
