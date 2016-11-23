<?php
require_once (utils/ClassDbhandler.php);

/*
* The purpose of this class is to provide access to the data for Operations around Leagues
*/

class League 
{
	/**
    * @var string
    */
    private $leaguename;
    /**
    * @var string
    */
    private $num_teams;
    /**
    * @var string
    */
    private $tournamentid;
	
	/**
	* create a new league record
	* @param $leaguename name
	* @param $num_teams num_teams
	* @param $tournamentid tournament_id
	* returns: nothing
	*/
	public function insert_league($leaguename, $num_teams, $tournamentid){
		try {
			$sql = "INSERT INTO league(
				name, 
				num_teams,
				tournament_id
			) 
			VALUES(
				:leaguename, 
				:num_teams,
				:tournamentid
			)";

			$dbh = new DBHandler();
			$stmt = $dbh->getInstance()->prepare($sql);

			$stmt->bindParam(':leaguename', $leaguename, PDO::PARAM_STR);    
			$stmt->bindParam(':num_teams', $num_teams, PDO::PARAM_STR);     
			$stmt->bindParam(':tournamentid', $tournamentid, PDO::PARAM_STR); 

			$stmt->execute();
			return true;

		} 
		catch(PDOException $e) {
			echo $e;
		}
	}

	/**
	* obtain list of all league records
	* returns: object
	*/
	public function find_all_leagues(){
		try{
			$sql = 'SELECT * FROM league
					ORDER BY id';
			
			$dbh = new DBHandler();	
			$stmt = $dbh->getInstance()->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;	
		} catch(PDOException $e) {
			echo $e;
	}
}
