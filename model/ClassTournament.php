<?php
require_once (utils/ClassDbhandler.php);

/*
* The purpose of this class is to provide access to the data for CRUD Operations around Tournaments
*/
class Tournament 
{
/**
    * @var int
    */
    private $id;
    /**
    * @var string
    */
    private $tournamentname
    /**
    * @var string
    */
    private $startdate
    /**
    * @var string
    */
    private $enddate
    /**
    * @var string
    */
    private $format
    /**
    * @var string
    */
    private $tournamentadmin
    /**
    * @var string
    */
    private $tournamentadminemail

    /*
	* function insert_tournament
	* args: db connection, $tournamentname, $startdate, $enddate, $format, $tournamentadmin, $tournamentadminemail
	* returns: boolean
	*/
	public function insert_tournament($dbh, $tournamentname, $startdate, $enddate, $format, $tournamentadmin, $tournamentadminemail){
		try {
			$sql = "INSERT INTO tournament(
				tournament_name, 
				start_date, 
				end_date,
				format,
				admin,
				admin_email
			) 
			VALUES(
				:tournamentname, 
				:startdate, 
				:enddate, 
				:format,
				:tournamentadmin, 
				:tournamentadminemail
			)";

			$stmt = $dbh->getInstance()->prepare($sql);


			$stmt->bindParam(':tournamentname', $tournamentname, PDO::PARAM_STR);       
			$stmt->bindParam(':startdate', $startdate); 
			$stmt->bindParam(':enddate', $enddate);   
			$stmt->bindParam(':format', $format, PDO::PARAM_STR);
			$stmt->bindParam(':tournamentadmin', $tournamentadmin, PDO::PARAM_STR);
			$stmt->bindParam(':tournamentadminemail', $tournamentadminemail, PDO::PARAM_STR); 

			$stmt->execute();
			return true;

		} 
		catch(PDOException $e) {
			echo $e->getMessage();
	        exit;
		}
	}

	/*
	* function find_all_tournaments
	* args: database connection
	* returns: an array of rows containing all tournament data
	*/
	public function find_all_tournaments($dbh){
		try{
			$sql = 'SELECT * FROM tournament
					ORDER BY id';
					
			$stmt = $dbh->getInstance()->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;	
		} catch(PDOException $e) {
			echo $e->getMessage();
	        exit;
		}
	}
}