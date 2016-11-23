<?php
require_once ('model/ClassTournament.php');

/** 
* TournamentController class
* The purpose of this class is to provide CRUD functionality for Tournaments
*/

class TournamentController 
{
	/**
	* obtain records for all tournaments or a specific tournament
	* @param $id id if any
	* return array
	*/
	public function find($id=null){
		$tournamentObj = new Tournament();
		$results = $tournamentObj->find_tournaments($id);

		if (!$results) {
			return array();
		}
		$tournaments = array();
		foreach ($results as $result) {
			$tournament = array (
				'id' => $result['id'],
				'tournament_name' => $result['tournament_name'],
				'start_date' => $result['start_date'],
				'end_date' => $result['end_date'],
				'format' => $result['format'],
				'admin' => $result['admin'],
				'admin_email' => $result['admin_email'],
				);
			$tournaments[] = $tournament;
		}
		return $tournaments;
	}
}