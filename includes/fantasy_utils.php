<?php
// add a generic error display function

//function attempt_login()
//args: $dbh, $username, $password
//return: user_id or false
function attempt_login($dbh, $username, $password){
	//verify username exists
	$resultFindOwner = find_owner_by_name($dbh, $username);
	if (!$resultFindOwner){
		//username not found return false
		return false;
	} else {
		foreach ($resultFindOwner as $row) { 
			$user_id = $row['id'];
		}
	}
	//now check the password
	$legit = password_check($dbh, $user_id, $password);
	if(!$legit){
		return false;
	} else {
		$_SESSION["user_id"] = $user_id;
		$_SESSION["username"] = $username;
		return true;
	}
}

//function password_check()
//args: db obj, user_id, password
//return boolean
function password_check($dbh, $user_id, $password){
//first grab the hashed pw from the db
	try{
		$sql = 'SELECT password FROM owner
				WHERE id
				LIKE :id';

		$stmt = $dbh->getInstance()->prepare($sql);

		$stmt->bindParam(':id', $user_id, PDO::PARAM_STR); 

		$stmt->execute();
		$resultsPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		echo $e;
	}
		if (!$resultsPassword){
			//user not found return false
			return false;
		} else {
			foreach ($resultsPassword as $row) { 
				$hash = $row['password'];
			}
		$verified = password_verify($password, $hash);
		if (!$verified) {
			return false;
		} else {
			return true;
		}
	}
}

//function hash_password()
//args: password
//returns $hash
function hash_password($password){
    $hash = password_hash($password, PASSWORD_BCRYPT);
    return $hash;
}


//function create_account()
//args db obj, desired username, email and password
//returns $creationMessage
function create_account($dbh, $username, $email, $password){
	//first make sure the user name (owner name) doesn't already exist
    $isNameTaken = find_owner_by_name($dbh, $username);
    if ($isNameTaken){
    	$creationMessage = "User Name taken, try again";
    	return $creationMessage;
    } else {
    	//hash the password and create the record
    	$hashed = hash_password($password);
    	$created = insert_owner($dbh, $email, $username, $hashed);
    	$creationMessage = "Welcome " . $username;
    	return $creationMessage;
    }
}


//function find_owner_by_name()
//args: db obj, username
//returns: id
function find_owner_by_name($dbh, $username){
	try{
		$sql = 'SELECT id FROM owner
				WHERE owner_name
				LIKE :username';
				
		$stmt = $dbh->getInstance()->prepare($sql);

		$stmt->bindParam(':username', $username, PDO::PARAM_STR); 

		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;	
	} catch(PDOException $e) {
		echo $e;
	}
}


//function find_all_owners
//args: database connection
//returns: an array of rows containing owner data
function find_all_owners($dbh){
	try{
		$sql = 'SELECT * FROM owner
				ORDER BY id';
				
		$stmt = $dbh->getInstance()->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;	
	} catch(PDOException $e) {
		echo $e;
	}
}

//function insert_owner
//args: db connection, email address, owners desired user name and (hashed)password
//returns: nothing
function insert_owner($dbh, $email, $username, $password){
	try {
		$sql = "INSERT INTO owner(
			email, 
			owner_name, 
			password,
			created,
			modified
		) 
		VALUES(
			:email, 
			:owner_name, 
			:password, 
			:created, 
			:modified
		)";

		$stmt = $dbh->getInstance()->prepare($sql);
		//timestamp fields are passed NULL so that MYSQL will auto populate them properly
		$created = NULL;
		$modified = NULL;

		$stmt->bindParam(':email', $email, PDO::PARAM_STR);       
		$stmt->bindParam(':owner_name', $username, PDO::PARAM_STR); 
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);   
		$stmt->bindParam(':created', $created);
		$stmt->bindParam(':modified', $modified);

		$stmt->execute();
		return true;

	} 
	catch(PDOException $e) {
		echo $e;
	}
}

function update_owner($dbh, $email, $owner_name, $password, $id){
	try {
		$sql = "Update owner SET
			email = :email, 
			owner_name = :owner_name, 
			password = :password,
			modified = :modified
			WHERE id LIKE :owner_id";

		$stmt = $dbh->getInstance()->prepare($sql);
		//timestamp fields are passed NULL so that MYSQL will auto populate them properly
		$modified = NULL;

		$stmt->bindParam(':email', $email, PDO::PARAM_STR);       
		$stmt->bindParam(':owner_name', $owner_name, PDO::PARAM_STR); 
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);   
		$stmt->bindParam(':modified', $modified);
		$stmt->bindParam(':owner_id', $id);

		$stmt->execute();

	} 
	catch(PDOException $e) {
		echo $e;
	}
}

function delete_owner($dbh, $id){
	try{
		$sql = 'DELETE FROM owner
				WHERE id LIKE :owner_id';
				
		$stmt = $dbh->getInstance()->prepare($sql);
		$stmt->bindParam(':owner_id', $id);
		$stmt->execute();	
	} catch(PDOException $e) {
		echo $e;
	}
}



//function insert_tournament
//args: db connection, $tournamentname, $startdate, $enddate, $format, $tournamentadmin, $tournamentadminemail
//returns: boolean
function insert_tournament($dbh, $tournamentname, $startdate, $enddate, $format, $tournamentadmin, $tournamentadminemail){
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
		echo $e;
	}
}

//function find_all_tournaments
//args: database connection
//returns: an array of rows containing all tournament data
function find_all_tournaments($dbh){
	try{
		$sql = 'SELECT * FROM tournament
				ORDER BY id';
				
		$stmt = $dbh->getInstance()->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;	
	} catch(PDOException $e) {
		echo $e;
	}
}

//function insert_league
//args: db connection, email address, owners desired user name and (hashed)password
//returns: nothing
function insert_league($dbh, $leaguename, $num_teams, $tournamentid){
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

//function find_all_leagues
//args: database connection
//returns: an array of rows containing all tournament data
function find_all_leagues($dbh){
	try{
		$sql = 'SELECT * FROM league
				ORDER BY id';
				
		$stmt = $dbh->getInstance()->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;	
	} catch(PDOException $e) {
		echo $e;
	}
}

//function insert_fantasy_team
//args: db connection, email address, owners desired user name and (hashed)password
//returns: nothing
function insert_fantasy_team($dbh, $teamname, $owner_id, $leagueid){
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

		$stmt = $dbh->getInstance()->prepare($sql);

		$stmt->bindParam(':teamname', $teamname, PDO::PARAM_STR);    
		$stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_STR);     
		$stmt->bindParam(':league_id', $leagueid, PDO::PARAM_STR); 

		$stmt->execute();
		return true;

	} 
	catch(PDOException $e) {
		echo $e;
	}
}

?>