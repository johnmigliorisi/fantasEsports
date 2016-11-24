<?php
require_once ('model/ClassLeague.php');

/** 
* LeagueController class
* The purpose of this class is to provide CRUD functionality for leagues
*/

class LeagueController 
{
	/**
	* obtain records for all leagues or a specific league
	* @param $id id if any
	* return array
	*/
	public function find($id=null){
		$leagueObj = new League();
		$results = $leagueObj->find_leagues($id);

		if (!$results) {
			return array();
		}
		$leagues = array();
		foreach ($results as $result) {
			$league = array (
				'id' => $result['id'],
				'name' => $result['name'],
				'active' => $result['active'],
				'chairman' => $result['chairman'],
				'num_teams' => $result['num_teams'],
				'tournament_id' => $result['tournament_id'],
				);
			$leagues[] = $league;
		}
		return $leagues;
	}
}