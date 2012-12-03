<?php

class Question{

	private $question;
	private $type;
	private $id;

	public function __construct(array $array = array()){
		if(!empty($array)){
			$this->question = $array['question'];
			$this->type = $array['type'];
			$this->id = $array['id'];
		}
	}

	public function getQuestion(){
		return $this->question;
	}

	public function getType(){
		return $this->type;
	}

	public function getId(){
		return $this->id;
	}

	public function setQuestion($question){
		$this->question = $question;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getChoices($conn){
		$query = "select * from choices where question_id = {$this->getId()} and is_custom = 0 order by rank";
		$result = $conn->query($query);
		$array = array();

		while($row = $result->fetch_assoc()){
			$choice = new Choice();

			$choice->setAnswer($row['answer']);
			$choice->setIsCorrect((bool) $row['is_correct']);
			$choice->setQuestionId($row['question_id']);
			$choice->setIsCustom((bool) $row['is_custom']);
			$choice->setId($row['id']);

			array_push($array, $choice);
		}

		return $array;
	}

}