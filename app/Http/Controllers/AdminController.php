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
				'activesession' => getActiveSession(),
				'results' => getResults()
			];
			
			return view("admin", $args);
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
				return "Pas d'oeuvre !";
			
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
			if (!isset($_SESSION['cart'])) {
				$_SESSION['cart'] = [];
			}
		}

		/**
			Adds an artwork to the stored cart
		**/
		public function addToCart($id) {
			$this->initSession();

			if (array_search($id, $_SESSION['cart']))
				return "false";
			$_SESSION['cart'][] = $id;
            
			return "true";
		}

		/**
			Removes an artwork from the stored cart
		**/
		public function removeFromCart($id) {
			$this->initSession();

			$k = array_search($id, $_SESSION['cart']);
			if ($k)
				unset($_SESSION['cart'][$k]);
            
			return ($k) ? "true" : "false";
		}

		/**
			Shows informations needed to create new session
		**/
		public function createSession()
		{
			$artworks = array_merge($this->getOeuvres(), Utils::dummyArtworks());
			$cartArtworks = []; //Utils::dummyArtworks();
			
			for ($i = 0; $i < 3; $i++) {
				$artworks = array_merge($artworks, $artworks);
				$cartArtworks = array_merge($cartArtworks, $cartArtworks);
			}
			
			$args = [
				"sessionDescription" => "", // doit être vide si la session est nouvellement créé, sinon contient la description
                
				"fromDate"           => "", // doit être vide si la session est nouvellement créé, sinon contient la date
				"toDate"             => "",
                
				"artworks"           => $artworks,
				"cartArtworks"       => $cartArtworks
			];
			
			return view("admin_create_session", $args);
		}


		/**
			Creates new session; shows active session and finished sessions informations
		**/
		public function newSession($fromDate, $toDate, $description, $oeuvres)
		{
			$session = new Session;
			
			$session->date_debut = $fromDate;
			$session->date_fin = $toDate;
			$session->description = $description;
			
			$session->save();
			
			foreach ($oeuvres as $o) {
				$session->oeuvres()->attach($o->id_oeuvre, ['score' => 0]);
			}
			
			return showHome();
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
