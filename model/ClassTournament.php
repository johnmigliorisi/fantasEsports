<?php
require_once ('utils/ClassDbhandler.php');

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
    private $tournamentname;
    /**
    * @var timestamp
    */
    private $startdate;
    /**
    * @var timestamp
    */
    private $enddate;
    /**
    * @var string
    */
    private $format;
    /**
    * @var string
    */
    private $tournamentadmin;
    /**
    * @var string
    */
    private $tournamentadminemail;

    /**
	* creates a new tournament record
	* @param $tournamentname 
	* @param $startdate
	* @param $enddate
	* @param $format
	* @param $tournamentadmin
	* @param $tournamentadminemail
	* returns: boolean
	*/
	public function insert_tournament($tournamentname, $startdate, $enddate, $format, $tournamentadmin, $tournamentadminemail){
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

			$dbh = new DBHandler();
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

	/**
	* deprecate this if find_tournaments works
	* function find_all_tournaments
	* returns object
	*/
	public function find_all_tournaments(){
		try{
			$sql = 'SELECT * FROM tournament
					ORDER BY id';
			
			$dbh = new DBHandler();		
			$stmt = $dbh->getInstance()->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;	
		} catch(PDOException $e) {
			echo $e->getMessage();
	        exit;
		}
	}

	/**
	* function find_tournaments
	* returns object
	*/
	public function find_tournaments($id = null){
		
		$sql = 'SELECT * FROM tournament
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