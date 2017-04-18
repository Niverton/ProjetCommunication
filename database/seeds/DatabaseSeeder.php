<?php

use Illuminate\Database\Seeder;

use App\Session;
use App\Auteur;
use App\Oeuvre;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    private function artworkArray() {
        $a = [
            [
                "name" => "La Joconde", "author" => "Léonard de Vinci", "date" => "1940", "description" => "un magnifique tableau sur toile de léonard", "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/260px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg"
            ],
            [
                "name" => "Autoportrait", "author" => "Vincent Van Gogh", "date" => "1889", "description" => "un magnifique tableau sur toile de notre amis à l'oreille coupé", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux019.jpg"
            ],
            [
                "name" => "Leçon d'anatomie du Docteur Tulp", "author" => "Rembrandt", "date" => "1930", "description" => "un superbe tableau", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux016.jpg"
            ],
            [
                "name" => "American Gothic", "author" => "Brant Wood", "date" => "1910", "description" => "absolument sublime", "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux000.jpg"
            ],
            [
                "name" => "Portrait d'homme",
                "author" => "Anonyme français XVIIIème",
                "date" => "18e siècle",
                "description" => "Ancienne collection d'Auguste Poirson.",
                "image" => "http://collections-musees.bordeaux.fr/ow4/mba/images/024-045-4821.JPG"
            ],
            [
                "name" => "Portrait de femme",
                "author" => "Anonyme français XIXème",
                "date" => "19e siècle",
                "description" => "Ancienne collection d'Auguste Poirson.",
                "image" => "http://collections-musees.bordeaux.fr/ow4/mba/images/009-047-2049.JPG"
            ],
            [
                "name" => "Portrait d'homme",
                "author" => "Léon BELLINEAU",
                "date" => "1850",
                "description" => "",
                "image" => "http://collections-musees.bordeaux.fr/ow4/mba/images/004-046-838.JPG"
            ],
            [
                "name" => "Portrait de femme",
                "author" => "Edmond Louis DUPAIN",
                "date" => "1886",
                "description" => "Ancienne collection Homener.",
                "image" => "http://collections-musees.bordeaux.fr/ow4/mba/images/008-074-1822.JPG"
            ],
            [
                "name" => "Portrait de femme à la rose",
                "author" => "DURAND dit DARSONVAL",
                "date" => "1796",
                "description" => "Ancienne collection d'Auguste Poirson",
                "image" => "http://collections-musees.bordeaux.fr/ow4/mba/images/019-023-3611.JPG"
            ],
            [
                "name" => "Portrait d'une femme en sibylle",
                "author" => "Anonyme français XIXème",
                "date" => "19e siècle",
                "description" => "Ancienne collection Poirson.",
                "image" => "http://collections-musees.bordeaux.fr/ow4/mba/images/1069-265-FDeval-2616.JPG"
            ]
        ];

        return $a;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artworks = $this->artworkArray();
        foreach ($artworks as $a) {
            $auteur = new Auteur;
            $auteur->nom = $a["author"];
            $auteur->save();

            $o = new Oeuvre;
            $o->nom = $a["name"];
            $o->date = $a["date"];
            $o->url_image = $a["image"];
            $o->auteur()->associate($auteur);
            $o->description = $a["description"];
            $o->save();
        }
    }

}
