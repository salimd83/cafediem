<?php

class Users{

	static public function retrieveAll($conn){
		$query = "select * from users";

		$result = $conn->query($query);
		$array = array();

		while($row = $result->fetch_assoc()) {
			$user = new User($row, $conn);

			array_push($array, $user);
		}

		return $array;
	}

	static public function retieveWinners($conn){
		$query = "select * from users order by rank";

		$result = $conn->query($query);
		$array = array();

		while($row = $result->fetch_assoc()) {
			$user = new User();
			$user->setType($row['type']);
			$user->setQuestion($row['question']);
			$user->setId($row['id']);

			array_push($array, $user);
		}

		return $array;
	}

	public static function retrieveByPk($id, $conn){
		$query = "select * from users where id = {$id} limit 1";

		$result = $conn->query($query);

		if($row = $result->fetch_assoc()){
			return new User($row, $conn);
		}else{
			return false;
		}
	}

}