<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Session;
use App\Auteur;
use App\Oeuvre;
use Carbon\Carbon;

use App\Utils;

class AdminController extends Controller
{

		/**
			Returns list of all sessions ordered by ID
		**/
		private function getSessions()
		{
			$sessions = Session::all();
			$sessions->sortBy('id_session');
			$sessions->load('oeuvres');
			
			return $sessions;
		}



		/**
			Returns active session informations with artworks ordered by score
		**/
		private function getActiveSession()
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->lt(Carbon::now());
			});
			
			$session = $sessions->last();
			if (is_null($session)) {
				$activesession = [
					'active' => 0
				];
				return $activesession;
			}
			
			$contents = $session->oeuvres()->withPivot('score')->orderBy('score', 'desc')->get();
			$results = [];
			foreach ($contents as $c) {
				$a = $c->auteur()->get()->last();
				$results[] = [
					'oeuvreID' => $c->id_oeuvre,
					'name' => $c->nom,
					'authorID' => $a->id_auteur,
					'author' => $a->nom,
					'date' => $c->date,
					'score' => $c->pivot->score
				];
			}
			
			$activesession = [
				'active' => 1,
				'sessionID' => $session->id_session,
				'fromDate' => $session->date_debut,
				'toDate' => $session->date_fin,
				'results' => $results
			];
			
			return $activesession;
		}



		/**
			Returns finished sessions informations with artworks ordered by score (= results)
		**/
		private function getResults()
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->gte(Carbon::now());
			});
			
			$session = $sessions->last();
			if (is_null($session))
				return "Pas de session terminée !";
			
			$allsessions = [];
			foreach ($sessions as $s) {
				$contents = $s->oeuvres()->withPivot('score')->orderBy('score', 'desc')->get();
				$results = [];
				foreach ($contents as $c) {
				$a = $c->auteur()->get()->last();
					$results[] = [
						'oeuvreID' => $c->id_oeuvre,
						'name' => $c->nom,
						'authorID' => $a->id_auteur,
						'author' => $a->nom,
						'date' => $c->date,
						'score' => $c->pivot->score
					];
				}
				$allsessions[] = [
					'sessionID' => $s->id_session,
					'fromDate' => $s->date_debut,
					'toDate' => $s->date_fin,
					'results' => $results
				];
			}
			
			return $allsessions;
		}



		/**
			Shows active session and finished sessions informations
		**/
		public function showHome()
		{
			$args = [
				'activesession' => $this->getActiveSession(),
				'results'       => $this->getResults()
			];
			
			//return view("admin", $args);
                        return "<h1>not implemented</h1>";
		}



		/**
			Returns list of all artworks ordered by ID
		**/
		public function getOeuvres()
		{
			$oeuvres = Oeuvre::all();
			$oeuvres->sortBy('id_oeuvre');
			
			$oeuvre = $oeuvres->last();
			if (is_null($oeuvre))
				return null;
			
			$args = [];
			foreach ($oeuvres as $o) {
				$a = $o->auteur()->get()->last();
				$args[] = [
					'id' => $o->id_oeuvre,
					'name' => $o->nom,
					'authorID' => $a->id_auteur,
					'author' => $a->nom,
					'date' => $o->date,
					'image' => $o->url_image
				];
			}
			
			return $args;
		}



		/**
			Initializes session if needed
		**/
		private function initSession() {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			if (!isset($_SESSION['fromDate'])) {
				$_SESSION['fromDate'] = NULL;
			}

			if (!isset($_SESSION['toDate'])) {
				$_SESSION['toDate'] = NULL;
			}

			if (!isset($_SESSION['desc'])) {
				$_SESSION['desc'] = "";
			}

			if (!isset($_SESSION['cart'])) {
				$_SESSION['cart'] = [];
			}
		}

		/**
			Adds an artwork to the stored cart
		**/
		public function addToCart($id) {
			$this->initSession();

			if (isset($_SESSION['cart'][$id]))
			   return "false";
                        else
                        {
                           $_SESSION['cart'][$id] = true;
                           return "true";
                        }
		}

		/**
			Removes an artwork from the stored cart
		**/
		public function removeFromCart($id) {
			$this->initSession();

                        unset($_SESSION['cart'][$id]);
                        return "true";
		}

		public function test($data) {
			$a = [];

			$a[] = $this->addToCart(12);
			$a[] = $this->addToCart(12);

			$a[] = $this->removeFromCart(12);
			$a[] = $this->removeFromCart(12);

			var_dump($a);
		}



		/**
			Shows informations needed to create new session
		**/
		public function createSession()
		{
		        $this->initSession();

			$artworks = $this->getOeuvres();
			$cart = array();

			foreach ($artworks as $a)
                        {
                           $id = $a["id"];
                
                           if ( isset($_SESSION['cart'][$id]) )
                              array_push($cart, $a);
                        }
			
			$args = [
				"sessionDescription" => $_SESSION['desc'],
				"fromDate"           => Utils::dateToRfc($_SESSION['fromDate']),
				"toDate"             => Utils::dateToRfc($_SESSION['toDate']),
				"artworks"           => $artworks,
				"cartArtworks"       => $cart
			];
			
			return view("admin_create_session", $args);
		}


                public function home()
                {
                   $active = [
                      "fromDate" => "2017-04-20",
                      "toDate"   => "2017-04-30",
                      "id"       => 10 // id de la session
                   ];

                   // historique des sessions de vote terminés (sans la session en cours)
                   // dans l'ordre : de la plus récente à la plus anciennne
                   $history = [
                      [ "fromDate" => "2017-04-20", "toDate" => "2017-04-30", "id" => 9 ],
                      [ "fromDate" => "2016-04-20", "toDate" => "2016-04-30", "id" => 8 ],
                      [ "fromDate" => "2015-04-20", "toDate" => "2015-04-30", "id" => 7 ],
                      [ "fromDate" => "2014-04-20", "toDate" => "2014-04-30", "id" => 6 ],
                      [ "fromDate" => "2013-04-20", "toDate" => "2013-04-30", "id" => 5 ],
                   ];

                   // ( $active  == null ) si aucune session de vote en cours
                   // ( $history == []   ) si historique vide

                   $args = [
                      "active"  => $active,
                      "history" => $history
                   ];

                   return view("admin_home", $args);
                }

                public function close()
                {
                   /* TODO: fermer la session active */

                   return redirect("/admin");
                }
   
                public function results($sessionId)
                {
                   $artworks = [
                      [
                         "votes" => 14,
                         "id" => 0,
                         "name" => "La Joconde",
                         "author" => "Léonard de Vinci",
                         "author_id" => 0,
                         "date" => "1940",
                         "description" => "Un magnifique tableau sur toile de léonard.",
                         "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg/260px-Mona_Lisa,_by_Leonardo_da_Vinci,_from_C2RMF_retouched.jpg"
                      ],

                      [
                         "votes" => 86,
                         "id" => 1,
                         "name" => "Autoportrait",
                         "author" => "Vincent Van Gogh",
                         "author_id" => 2,
                         "date" => "1889",
                         "description" => "Un magnifique tableau sur toile de notre amis à l'oreille coupé.",
                         "image" => "http://media.topito.com/wp-content/uploads/2012/03/Tableaux019.jpg"
                      ]
                   ];
                   
                   $args = [
                      "sessionDescription" => "Exposition de peintures.",
                      "fromDate"           => "2017-04-20",
                      "toDate"             => "2017-04-30",
                      "artworks"           => $artworks
                   ];
                   
                   return view("admin_results", $args);
                }
   
		public function submitSession()
		{
			$this->initSession();
			
		        $_SESSION['desc'] = trim($_POST['description']);

		        $fromDate = Utils::rfcToDate($_POST['fromDate']);
		        $toDate   = Utils::rfcToDate($_POST['toDate']);

                        if ($fromDate === null || $toDate === null)
                        {
			   return redirect("/admin/create#invalid-dates");
                        }
                        else
                        {
		           $_SESSION['fromDate'] = $fromDate;
 		           $_SESSION['toDate']   = $toDate;
                           
			   return redirect("/admin/create");
                        }                   
		}



		/**
			Creates new session; shows active session and finished sessions informations
		**/
		public function newSession()
                {
                        $this->initSession();

                        $fromDate    = $_SESSION['fromDate'];
                        $toDate      = $_SESSION['toDate'];
                        $description = $_SESSION['desc'];
                        $cart        = $_SESSION['cart'];
                   
                        if ($fromDate === null || $toDate === null)
                        {
                           return redirect("/admin/create#invalid-dates");
                        }
                        else if (empty($cart))
                        {
                           return redirect("/admin/create#empty-cart");
                        }
                        else
                        {
			   $session = new Session;
			   
			   $session->date_debut  = $fromDate;
			   $session->date_fin    = $toDate;
			   $session->description = $description;
			   
                           $session->save();

			   foreach ($cart as $id => $_) {
			      $session->oeuvres()->attach($id, ['score' => 0]);
			   }
                           
                           session_destroy();
			   return redirect("/"); // redirect("/path/to/admin/home");
                        }
		}



		/**
			Deletes active session; shows active session and finished sessions informations
		**/
		public function deleteSession()
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->lt(Carbon::now());
			});
			
			$session = $sessions->last();
			if (is_null($session))
				return "Pas de session active !";
			
			$session->delete();
			
			return showHome();
		}



		/**
			Changes active session "from date" if "from date" is not passed
			Shows active session and finished sessions informations
		**/
		public function setFromDate($fromDate)
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_debut);
				return $d->lt(Carbon::now());
			});
			
			$session = $sessions->last();
			if (is_null($session))
				return "Pas de session active !";
			
			$d = new Carbon($fromDate);
			if ($d->gte(Carbon::now()))
				$session->date_debut = $fromDate;
			
			return showHome();
		}



		/**
			Changes active session "to date" if "to date" is not passed
			Shows active session and finished sessions informations
		**/
		public function setToDate($toDate)
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->lt(Carbon::now());
			});
			
			$session = $sessions->last();
			if (is_null($session))
				return "Pas de session active !";
			
			$d = new Carbon($toDate);
			if ($d->gte(Carbon::now()))
				$session->date_fin = $toDate;
			
			return showHome();
		}


		/**
			Changes active session "from date" if "from date" is not passed
			Changes active session "to date" if "to date" is not passed
			Shows active session and finished sessions informations
		**/
		public function setDate($fromDate, $toDate)
		{
			$sessions = $this->getSessions();
			
			$finder = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_debut);
				return $d->gte(Carbon::now());
			});
			
			$session = $finder->last();
			if (!is_null($session)) {
				$d = new Carbon($fromDate);
				if ($d->lt(Carbon::now()))
					$session->date_debut = $fromDate;
			}
			
			$finder = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->gte(Carbon::now());
			});
			
			$session = $finder->last();
			if (!is_null($session)) {
				$d = new Carbon($toDate);
				if ($d->lt(Carbon::now()))
					$session->date_fin = $toDate;
			}
			
			return showHome();
		}

}
