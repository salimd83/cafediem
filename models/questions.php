<?php

class Questions{

	static public function retrieveAll($conn){
		$query = "select * from questions order by rank";

		$result = $conn->query($query);
		$array = array();

		while($row = $result->fetch_assoc()) {
			$question = new Question();
			$question->setType($row['type']);
			$question->setQuestion($row['question']);
			$question->setId($row['id']);

			array_push($array, $question);
		}

		return $array;
	}

	public static function retrieveByPk($id, $conn){
		$query = "select * from questions where id = {$id} limit 1";

		$result = $conn->query($query);

		if($row = $result->fetch_assoc()){
			return new Question($row);
		}else{
			return false;
		}
	}
}