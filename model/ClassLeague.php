<?php
require_once ('utils/ClassDbhandler.php');

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
	* function find_leagues
	* returns object
	*/
	public function find_leagues($id = null){
		
		$sql = 'SELECT * FROM league
					ORDER BY id';
		if (is_int($id)) {
            $sql .= " WHERE id = :id";
        }

		try{	
			$dbh = new DBHandler();			
			$stmt = $dbh->getInstance()->prepare($sql);
			if (is_int($id)) {
            	$stmt->bindParam(':id', $id, PDO::PARAM_STR); 
        	}
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;	
		} catch(PDOException $e) {
			echo $e->getMessage();
            exit;
		}
	}

}