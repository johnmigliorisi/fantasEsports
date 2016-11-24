<?php
require_once ('utils/ClassDbhandler.php');

/*
* The purpose of this class is to provide access to the data for Operations around Teams
*/
class Team 
{
	/**
    * @var string
    */
    private $teamname;
    /**
    * @var string
    */
    private $owner_id;
    /**
    * @var string
    */
    private $leagueid;


	public function insert_fantasy_team($teamname, $owner_id, $leagueid){
		try {
			$sql = "INSERT INTO fantasy_team(
				name, 
				owner_id,
				league_id
			) 
			VALUES(
				:teamname, 
				:owner_id,
				:league_id
			)";

			$dbh = new DBHandler();
			$stmt = $dbh->getInstance()->prepare($sql);

			$stmt->bindParam(':teamname', $teamname, PDO::PARAM_STR);    
			$stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_STR);     
			$stmt->bindParam(':league_id', $leagueid, PDO::PARAM_STR); 

			$stmt->execute();
			return true;

		} 
		catch(PDOException $e) {
			echo $e->getMessage();
            exit;
		}
	}

}