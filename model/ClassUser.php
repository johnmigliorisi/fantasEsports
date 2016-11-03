<?php
require_once (utils/ClassDbhandler.php);

/*
* The purpose of this class is to provide access to the data for Operations around users (owners)
*/
class User
{
	/**
    * @var int
    */
    private $id;
    /**
    * @var string
    */
    private $owner_name;
    /**
    * @var string
    */
    private $email;
    /**
    * @var string
    */
    private $image;
    /**
    * @var BCRYPT
    */
    private $password;
    /**
    * @var timestamp
    */
    private $created;
    /**
    * @var timestamp
    */
    private $modified;
	
    /*function is_logged_in()
    * args none
    * return boolean
    */
    public function is_logged_in()
    {
	    $loggedIn = (isset($_SESSION["user_id"]) ? true : false); 
		return $loggedIn;
    }

    /* 
    *function attempt_login()
    *args: $dbh, $username, $password
    *return: user_id or false
    */
    public function attempt_login($dbh, $username, $password)
    {
	//verify username exists
	    $resultFindOwner = find_owner_by_name($dbh, $username);
	    if (!$resultFindOwner){
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

    /*
    * function password_check()
    * args: db obj, user_id, password
    * return boolean
    */
    public function password_check($dbh, $user_id, $password){
        //first grab the hashed pw from the db
	    try {
		    $sql = 'SELECT password FROM owner
				    WHERE id
				    LIKE :id';

		    $stmt = $dbh->getInstance()->prepare($sql);

		    $stmt->bindParam(':id', $user_id, PDO::PARAM_STR); 

		    $stmt->execute();
		    $resultsPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    } catch(PDOException $e) {
		    echo $e->getMessage();
            exit;
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

    /*
    * function hash_password()
    * args: password
    * returns $hash
    */
    public function hash_password($password){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        return $hash;
    }

    /*
	* function create_account()
	* args db obj, desired username, email and password
	* returns string
	*/
	public function create_account($dbh, $username, $email, $password){
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

	/*
	* function find_owner_by_name()
	* args: db obj, username
	* returns object
	*/
	public function find_owner_by_name($dbh, $username){
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
			echo $e->getMessage();
            exit;
		}
	}

	/*
	* function find_all_owners
	* args: database connection
	* returns object
	*/
	public function find_all_owners($dbh){
		try{
			$sql = 'SELECT * FROM owner
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

	/*
	* function insert_owner
	* args: db connection, email address, owners desired user name and (hashed)password
	* returns boolean
	*/
	public function insert_owner($dbh, $email, $username, $password){
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

			//make this return lastinsertid()
			return true;

		} 
		catch(PDOException $e) {
			echo $e->getMessage();
            exit;
		}
	}

	/*
	* function update_owner
	* args: db connection, email address, owners desired user name and (hashed)password
	* returns nothing
	*/
	public function update_owner($dbh, $email, $owner_name, $password, $id){
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
			echo $e->getMessage();
            exit;
		}
	}

	/*
	* function delete_owner
	* args: db connection, id
	* returns nothing
	*/
	public function delete_owner($dbh, $id){
		try{
			$sql = 'DELETE FROM owner
					WHERE id LIKE :owner_id';
					
			$stmt = $dbh->getInstance()->prepare($sql);
			$stmt->bindParam(':owner_id', $id);
			$stmt->execute();	
		} catch(PDOException $e) {
			echo $e->getMessage();
            exit;
		}
	}



}