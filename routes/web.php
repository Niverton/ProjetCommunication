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

$app->get("/vote", 'VoteController@show');

$app->get("/admin", function() use ($app) {
   
   return "Hello, world! :)";
   
});
