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
		/*private function getActiveSession()
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
		}*/



		/**
			Returns finished sessions informations with artworks ordered by score
		**/
		/*private function getResults()
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->gte(Carbon::now());
			});
			
			$session = $sessions->last();
			if (is_null($session))
				return null;
			
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
		}*/



		/**
			Shows active session and finished sessions informations
		**/
		/*public function showHome()
		{
			$args = [
				'activesession' => $this->getActiveSession(),
				'results' => $this->getResults()
			];
			
			return view("admin", $args);
		}*/



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
		private function initSession()
		{
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
		public function addToCart($id)
		{
			$this->initSession();
			
			if (isset($_SESSION['cart'][$id]))
				return "false";
			else {
				$_SESSION['cart'][$id] = true;
				return "true";
			}
		}



		/**
			Removes an artwork from the stored cart
		**/
		public function removeFromCart($id)
		{
			$this->initSession();
			
			unset($_SESSION['cart'][$id]);
			return "true";
		}



		/**
			Shows informations needed to create a new session
		**/
		public function createSession()
		{
			$this->initSession();
			
			$artworks = $this->getOeuvres();
			$cart = array();
			
			foreach ($artworks as $a) {
				$id = $a["id"];    
				if (isset($_SESSION['cart'][$id]))
					array_push($cart, $a);
			}
			
			$args = [
				"sessionDescription" => $_SESSION['desc'],
				"fromDate" => Utils::dateToRfc($_SESSION['fromDate']),
				"toDate" => Utils::dateToRfc($_SESSION['toDate']),
				"artworks" => $artworks,
				"cartArtworks" => $cart
			];
			
			return view("admin_create_session", $args);
		}



		public function home()
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->lt(Carbon::now()->subDays(1));
			});
			
			$session = $sessions->last();
			if (is_null($session))
				$active = null;
			else
				$active = [
					"fromDate" => $session->date_debut,
					"toDate" => $session->date_fin,
					"id" => $session->id_session
				];
			
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->gte(Carbon::now()->subDays(1));
			});
			
			$history = [];
			$session = $sessions->last();
			if (!is_null($session))
				foreach ($sessions as $s)
					$history[] = [
						'fromDate' => $s->date_debut,
						'toDate' => $s->date_fin,
						'id' => $s->id_session
					];
			
			$args = [
				"active"  => $active,
				"history" => $history
			];

			return view("admin_home", $args);
		}



		public function close()
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->lt(Carbon::now()->subDays(1));
			});
			
			$session = $sessions->last();
			if (is_null($session))
				return "Pas de session active !";
			
			$contents = $session->oeuvres()->withPivot('score')->orderBy('score', 'desc')->get();
			foreach ($contents as $c)
				$c->pivot->delete();
			
			$session->delete();
			
			return redirect("/admin");
		}



		public function results($sessionID)
		{
			$sessions = $this->getSessions();
			
			$session = null;
			foreach ($sessions as $s)
				if ($s->id_session == $sessionID)
					$session = $s;
			
			if (is_null($session))
				return "Pas de session avec cet ID !";
			
			$contents = $session->oeuvres()->withPivot('score')->orderBy('score', 'desc')->get();
			$artworks = [];
			foreach ($contents as $c) {
				$a = $c->auteur()->get()->last();
				$artworks[] = [
					"votes" => $c->pivot->score,
					"id" => $c->id_oeuvre,
					"name" => $c->nom,
					"author_id" => $a->id_auteur,
					"author" => $a->nom,
					"date" => $c->date,
					"description" => $c->description,
					"image" => $c->url_image
				];
			}
			
			$args = [
				"sessionDescription" => $session->description,
				"fromDate" => $session->date_debut,
				"toDate" => $session->date_fin,
				"artworks" => $artworks
			];
			
			return view("admin_results", $args);
		}



		public function submitSession()
		{
			$this->initSession();
			
			$_SESSION['desc'] = trim($_POST['description']);

			$fromDate = Utils::rfcToDate($_POST['fromDate']);
			$toDate = Utils::rfcToDate($_POST['toDate']);

			if ($fromDate === null || $toDate === null)
				return redirect("/admin/create#invalid-dates");
			else {
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;               
				return redirect("/admin/create");
			}                   
		}



		/**
			Creates new session; shows active session and finished sessions informations
		**/
		public function newSession()
		{
			$this->initSession();

			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			$description = $_SESSION['desc'];
			$cart = $_SESSION['cart'];

			$from = new Carbon($fromDate);
			if ($from->lt(Carbon::now()->subDays(1)))
				return redirect("/admin/create#invalid-dates");

			$to = new Carbon($toDate);
			if ($to->lt($from))
				return redirect("/admin/create#invalid-dates");

			if ($fromDate === null || $toDate === null)
				return redirect("/admin/create#invalid-dates");
			else if (empty($cart))
				return redirect("/admin/create#empty-cart");
			else {
				$session = new Session;
			   
				$session->date_debut = $fromDate;
				$session->date_fin = $toDate;
				$session->description = $description;
			   
				$session->save();

				foreach ($cart as $id => $_)
					$session->oeuvres()->attach($id, ['score' => 0]);
                           
				session_destroy();
				return redirect("/admin");
			}
		}



		/**
			Deletes active session; shows active session and finished sessions informations
		**/
		/*public function deleteSession()
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
		}*/



		/**
			Changes active session "description"
		**/
		/*public function setDescription($description)
		{
			$sessions = $this->getSessions();
			
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->lt(Carbon::now());
			});
			
			$session = $sessions->last();
			if (is_null($session))
				return "Pas de session active !";
			
			$session->description = $description;
			
			return showHome();
		}*/



		/**
			Changes active session "from date" if "from date" is not passed
			Shows active session and finished sessions informations
		**/
		/*public function setFromDate($fromDate)
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
		}*/



		/**
			Changes active session "to date" if "to date" is not passed
			Shows active session and finished sessions informations
		**/
		/*public function setToDate($toDate)
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
		}*/



		/**
			Changes active session "from date" if "from date" is not passed
			Changes active session "to date" if "to date" is not passed
			Shows active session and finished sessions informations
		**/
		/*public function setDate($fromDate, $toDate)
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
		}*/



}
