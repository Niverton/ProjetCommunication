<?php

use Illuminate\Database\Seeder;

use App\Session;
use App\Auteur;
use App\Oeuvre;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $session = new Session;
        $session->description = str_random(100);
        $session->date_debut = Carbon::now();
        $fin = Carbon::now();
        $fin->addMonth();
        $session->date_fin = $fin;
        $session->save();

        $a1 = new Auteur;
        $a1->nom = "Dire Straits";
        $a1->save();

        $o1 = new Oeuvre;
        $o1->nom = "Money for Nothing";
        $o1->date = "1985";
        $o1->url_image = "http://www.popjoust.com/images/jousters/jouster-5177-Money_for_nothing_clip.jpg";
        $o1->auteur()->associate($a1); //A test
        $o1->description = str_random(50);
        $o1->save();

        $o2 = new Oeuvre;
        $o2->nom = "Sultans of Swing";
        $o2->date = "1977";
        $o2->url_image = "http://images.45cat.com/dire-straits-sultans-of-swing-vertigo-7.jpg";
        $o2->description = str_random(50);
        $o2->auteur()->associate($a1);
        $o2->save();

        //TODO Ajouter d'autres au besoin

        //Une fois qu'on a save les oeuvres et les sessions, on peut lier les deux
        $session->oeuvres()->attach($o1->id_oeuvre, [ 'score' => 0]);
        $session->oeuvres()->attach($o2->id_oeuvre, [ 'score' => 10]);
    }
}
