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
  <li> <a href="/admin">/admin</a> </li>
</ul>
';
});

/* Liste d'auteurs de la session active */
$app->get("/vote/auteurs", 'VoteController@showAuthors');
/* Liste des oeuvres de {auteur} */
$app->get("/vote/auteurs/{auteur}", 'VoteController@showAuthorsContent');
/* Liste des oeuvres de la session active */
$app->get("/vote", 'VoteController@showArtworks');
/* Upboat */
$app->post("/vote/upboat", 'VoteController@upvote');
/* TODO REMOVE ME Spoof requète POST pour test le upboat */
$app->get("/vote/upboat/debug", function() use ($app) {
  return "
  <form action='/vote/upboat' method='post'>
    <input type='text' name='id'>
    <button type='submit' value='balance la sauce'></button>
  </form>
  ";
});

$app->get("/admin", function() use ($app) {
   
  return "Hello, world! :)";
   
});
