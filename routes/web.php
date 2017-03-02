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

$app->get("/vote", function() use ($app) {
    

    $artworks = [
        ["id" => 0, "name" => "la joconde", "author" => "léonard", "date" => "1940", "description" => "un magnifique tableau sur toile de léonard", "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/260px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg"],

        ["id" => 1, "name" => "Autoportrait", "author" => "Vincent Van Gogh", "date" => "1889", "description" => "un magnifique tableau sur toile de notre amis à l'oreille coupé", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux019.jpg"],

        ["id" => 2, "name" => "Leçon d'anatomie du Docteur Tulp", "author" => "Rembrandt", "date" => "1930", "description" => "un superbe tableau", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux016.jpg"],

        ["id" => 3, "name" => "American Gothic", "author" => "Brant Wood", "date" => "1910", "description" => "absolument sublime", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux000.jpg"],

        ["id" => 4, "name" => "la joconde", "author" => "léonard", "date" => "1940", "description" => "un magnifique tableau sur toile de léonard", "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/260px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg"],

        ["id" => 5, "name" => "Autoportrait", "author" => "Vincent Van Gogh", "date" => "1889", "description" => "un magnifique tableau sur toile de notre amis à l'oreille coupé", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux019.jpg"],

        ["id" => 6, "name" => "Leçon d'anatomie du Docteur Tulp", "author" => "Rembrandt", "date" => "1930", "description" => "un superbe tableau", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux016.jpg"],

        ["id" => 7, "name" => "American Gothic", "author" => "Brant Wood", "date" => "1910", "description" => "absolument sublime", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux000.jpg"],

        ["id" => 8, "name" => "la joconde", "author" => "léonard", "date" => "1940", "description" => "un magnifique tableau sur toile de léonard", "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/260px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg"],

        ["id" => 9, "name" => "Autoportrait", "author" => "Vincent Van Gogh", "date" => "1889", "description" => "un magnifique tableau sur toile de notre amis à l'oreille coupé", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux019.jpg"],

        ["id" => 10, "name" => "Leçon d'anatomie du Docteur Tulp", "author" => "Rembrandt", "date" => "1930", "description" => "un superbe tableau", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux016.jpg"],

        ["id" => 11, "name" => "American Gothic", "author" => "Brant Wood", "date" => "1910", "description" => "absolument sublime", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux000.jpg"],

        ["id" => 12, "name" => "la joconde", "author" => "léonard", "date" => "1940", "description" => "un magnifique tableau sur toile de léonard", "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/260px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg"],

        ["id" => 13, "name" => "Autoportrait", "author" => "Vincent Van Gogh", "date" => "1889", "description" => "un magnifique tableau sur toile de notre amis à l'oreille coupé", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux019.jpg"],

        ["id" => 14, "name" => "Leçon d'anatomie du Docteur Tulp", "author" => "Rembrandt", "date" => "1930", "description" => "un superbe tableau", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux016.jpg"],

        ["id" => 15, "name" => "American Gothic", "author" => "Brant Wood", "date" => "1910", "description" => "absolument sublime", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux000.jpg"]
    ];
    
    $args = [
        "sessionDescription" => "Coucou ! C'est le musée ! Votez pour l'œvre que vous aimeriez voir lors de la prochaine expo !!",
        "artworks" => $artworks
    ];
    
    return view("vote", $args);
});

$app->get("/admin", function() use ($app) {
    
    return "coucou :)";
    
});

