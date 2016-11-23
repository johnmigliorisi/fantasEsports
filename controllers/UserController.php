<?php
require_once ('model/ClassUser.php');

/** 
* UserController class
* The purpose of this class is to provide CRUD functionality for users (owners)
*/

class UserController 
{
	/**
	* obtain records for all users or a specific user
	* @param $id id if any
	* return array
	*/
	public function find($id=null)
	{
		$userObj = new User();
		$results = $userObj->find_owners($id);
		if (!$results) {
			return array();
		}
		$users = array();
		foreach ($results as $result) {
			$user = array (
				'id' => $result['id'],
				'owner_name' => $result['owner_name'],
				'image' => $result['image'],
				'email' => $result['email'],
				'created' => $result['created'],
				'modified' => $result['modified'],
				);
			$users[] = $user;
		}
		return $users;
	}

	/**
	* delete record for specific user
	* @param $id id
	* return boolean
	*/
	public function delete($id)
	{
		$userObj = new User();
		$results = $userObj->delete_owner($id);
		return $results;
	}


}