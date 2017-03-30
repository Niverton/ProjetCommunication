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

		private function getSessions() {
			$sessions = Session::all(); 
			$sessions->sortBy('id_session');
			$sessions->load('oeuvres');
			return $filter;
		}

		private function getActiveSession() {
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
			$contents = $s->oeuvres()->get();
			foreach ($contents as $c) {
				$results[] = [
					'oeuvreID' => $c->id_oeuvre,
					'name' => $c->nom,
					'author' => $c->auteur()->get()->last()->nom,
					'date' => $c->date,
					'score' => $c->pivot->score
				];
			}
			$activesession = [
				'active' => 1,
				'sessionID' => $s->id_session,
				'fromDate' => $s->date_debut,
				'toDate' => $s->date_fin,
				'results' => $results
			];
			return $activesession;
		}

		private function getResults() {
			$sessions = $this->getSessions();
			$sessions = $sessions->reject(function ($value, $key) {
				$d = new Carbon($value->date_fin);
				return $d->gt(Carbon::now());
			});
			$session = $sessions->last();
			if (is_null($session))
				return;
			foreach ($sessions as $s) {
				$contents = $s->oeuvres()->get();
				foreach ($contents as $c) {
					$results[] = [
						'oeuvreID' => $c->id_oeuvre,
						'name' => $c->nom,
						'author' => $c->auteur()->get()->last()->nom,
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

		public function showHome() {
			$args = [
				'activesession' => getActiveSession(),
				'results' => getResults()
			];
			return view("admin", $args);
		}

		public function getOeuvres() {
			$oeuvres = Oeuvre::all();
			$oeuvres->sortBy('id_oeuvre');
			$oeuvre = $oeuvres->last();
			if (is_null($oeuvre))
				return;
			foreach ($oeuvres as $o) {
				$args[] = [
					'id' => $o->id_oeuvre,
					'name' => $o->nom,
					'author' => $o->auteur()->get()->last()->nom,
					'date' => $o->date,
					'image' => $o->url_image
				];
			}
			return $args;
		}

        public function createSession()
        {
            $artworks = array_merge($this->getOeuvres(), Utils::dummyArtworks());
            $cartArtworks = Utils::dummyArtworks();
            for ($i = 0; $i < 3; $i++)
            {
                $artworks = array_merge($artworks, $artworks);
                $cartArtworks = array_merge($cartArtworks, $cartArtworks);
            }
            
            $args = [
                "sessionDescription" => "coucou",
                "fromDate" => "",
                "toDate" => "",

                "artworks" => $artworks,
                "cartArtworks" => $cartArtworks
            ];
            
            return view("admin_create_session", $args);
        }
}
