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

        //Session 1
            $s1 = new Session;
            $s1->description = str_random(100);
            $s1->date_debut = Carbon::now();
            $fin = Carbon::now();
            $fin->addMonth();
            $s1->date_fin = $fin;
            $s1->save();
            
            $a1 = new Auteur;
            $a1->nom = "Dire Straits";
            $a1->save();

            $o1 = new Oeuvre;
            $o1->nom = "Money for Nothing";
            $o1->date = "1985";
            $o1->url_image = "http://www.popjoust.com/images/jousters/jouster-5177-Money_for_nothing_clip.jpg";
            $o1->auteur()->associate($a1);
            $o1->description = str_random(50);
            $o1->save();

            $o2 = new Oeuvre;
            $o2->nom = "Sultans of Swing";
            $o2->date = "1977";
            $o2->url_image = "http://images.45cat.com/dire-straits-sultans-of-swing-vertigo-7.jpg";
            $o2->description = str_random(50);
            $o2->auteur()->associate($a1);
            $o2->save();

            //Une fois qu'on a save les oeuvres et les sessions, on peut lier les deux
            $s1->oeuvres()->attach($o1->id_oeuvre, [ 'score' => 0]);
            $s1->oeuvres()->attach($o2->id_oeuvre, [ 'score' => 10]);

        //Session 2
            $s2 = new Session;
            $s2->description = str_random(100);
            $d2 = Carbon::now();
            $d2->month -= 1;
            $s2->date_debut = $d2;
            $f2 = Carbon::now();
            $f2->day -= 1;
            $s2->date_fin = $f2;
            $s2->save();

            $a2 = new Auteur;
            $a2->nom = "The Cranberries";
            $a2->save();

            $o3 = new Oeuvre;
            $o3->nom = "Zombie";
            $o3->date = "1994";
            $o3->url_image = "https://i.ytimg.com/vi/6Ejga4kJUts/maxresdefault.jpg";
            $o3->auteur()->associate($a2);
            $o3->description = str_random(50);
            $o3->save();

            $o4 = new Oeuvre;
            $o4->nom = "Animal Instinct";
            $o4->date = "1999";
            $o4->url_image = "https://i.ytimg.com/vi/bSQ7CJSTTxo/hqdefault.jpg";
            $o4->description = str_random(50);
            $o4->auteur()->associate($a2);
            $o4->save();

            $s2->oeuvres()->attach($o3->id_oeuvre, [ 'score' => 0]);
            $s2->oeuvres()->attach($o4->id_oeuvre, [ 'score' => 10]);

            //On rajoute aussi à la session 1 pour avoir plusieurs auteurs dans une seule session (tests affichage par auteur)
            $s1->oeuvres()->attach($o3->id_oeuvre, [ 'score' => 15]);
            $s1->oeuvres()->attach($o4->id_oeuvre, [ 'score' => 25]);
    }
}
