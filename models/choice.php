<?php

class Choice{

	private $answer;
	private $is_correct;
	private $questionId;
	private $isCustom;
	private $id;

	public function getAnswer(){
		return $this->answer;
	}

	public function isCorrect(){
		return $this->isCorrect;
	}

	public function getQuestionId(){
		return $this->questionId;
	}

	public function isCustom(){
		return $this->isCustom;
	}

	public function getId(){
		return $this->id;
	}

	public function setAnswer($answer){
		$this->answer = $answer;
	}

	public function setIsCorrect($isCorrect){
		$this->isCorrect = $isCorrect;
	}

	public function setQuestionId($questionId){
		$this->questionId = $questionId;
	}

	public function setIsCustom($isCustom){
		$this->isCustom = $isCustom;
	}

	public function setId($id){
		$this->id = $id;
	}

}