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
  <li> <a href="/admin">/admin</a> </li>
</ul>
';
});

/* [VIEW] Liste d'auteurs de la session active */
//$app->get ("/vote/auteurs"                      , 'VoteController@showAuthors');

/* [VIEW] Liste des oeuvres de {auteur} */
//$app->get ("/vote/auteurs/{auteur}"             , 'VoteController@showAuthorsContent');

/* [VIEW] Liste des oeuvres de la session active */
$app->get ("/vote"                              , 'VoteController@showArtworks');

/* [AJAX] Upvote */
$app->get ("/vote/upvote/{id}"                  , 'VoteController@upvote');

/* [VIEW] Admin */
$app->get ("/admin"                             , "AdminController@home");
$app->get ("/admin/close"                       , "AdminController@close");
$app->get ("/admin/results/{sessionId}"         , "AdminController@results");
$app->get ("/admin/create"                      , "AdminController@createSession");

/* [AJAX] Admin */
$app->get ("/admin/create/add_to_cart/{id}"     , "AdminController@addToCart");
$app->get ("/admin/create/remove_from_cart/{id}", "AdminController@removeFromCart");

/* [REDIRECT] Admin */
$app->post("/admin/create/submit"               , "AdminController@submitSession");
$app->get ("/admin/create/validate"             , "AdminController@newSession");

//TODO REMOVE ME
//$app->get ("/test/{data}"                       , "AdminController@test");
