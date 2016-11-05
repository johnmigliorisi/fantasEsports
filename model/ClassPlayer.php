<?php
require_once (utils/ClassDbhandler.php);

/*
* The purpose of this class is to provide access to the data for Operations around players
*/
class Player
{
	/**
    * @var string
    */
    private $playername;
    /**
    * @var string
    */
    private $playerTag;
    /**
    * @var string
    */
    private $bio;
    /**
    * @var string
    */
    private $playerPic;
    /**
    * @var string
    */
    private $playerPic;

	/**
	* obtain list of all player records
	* return object
	*/
	public function find_all_players(){
		try{
			$sql = 'SELECT * FROM player
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
	* obtain specific player record
	* @param $playername player_name
	//returns: id
	*/
	public function find_player_by_name($playername){
		try{
			$sql = 'SELECT id FROM player
					WHERE player_name
					LIKE :playername';
			
			$dbh = new DBHandler();	
			$stmt = $dbh->getInstance()->prepare($sql);

			$stmt->bindParam(':playername', $playername, PDO::PARAM_STR); 

			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;	
		} catch(PDOException $e) {
			echo $e->getMessage();
            exit;
		}
	}

	/**
	* create new player record
	* @param $playerName player_name
	* @param $playerTag player_tag
	* @param $bio bio
	* @param $playerPic image
	* @param $ranking ranking
	* return boolean
	*/
	public function insert_player($playerName, $playerTag, $bio, $playerPic, $ranking){
		try {
			$sql = "INSERT INTO player(
				player_name, 
				player_tag,
				created,
				modified,
				bio,
				image,
				ranking
			) 
			VALUES(
				:player_name, 
				:player_tag,
				:created,
				:modified,
				:bio,
				:image,
				:ranking
			)";

			$dbh = new DBHandler();
			$stmt = $dbh->getInstance()->prepare($sql);

			//timestamp fields are passed NULL so that MYSQL will auto populate them properly
			$created = NULL;
			$modified = NULL;

			$stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);    
			$stmt->bindParam(':player_tag', $playerTag, PDO::PARAM_STR);   
			$stmt->bindParam(':created', $created);
			$stmt->bindParam(':modified', $modified);  
			$stmt->bindParam(':bio', $bio, PDO::PARAM_STR); 
			$stmt->bindParam(':image', $playerPic, PDO::PARAM_STR); 
			$stmt->bindParam(':ranking', $ranking, PDO::PARAM_STR); 

			$stmt->execute();
			return true;

		} 
		catch(PDOException $e) {
			echo $e->getMessage();
            exit;
		}
	}
}