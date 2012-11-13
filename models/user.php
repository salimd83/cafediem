<?php

class User{

	private $name;
	private $email;
	private $hasSubmit;
	private $submitDate;
	private $id;

	public function __construct(array $array){
		$this->name = $array['name'];
		$this->email = $array['email'];
		$this->has_submit = $array['has_submit'];
		$this->submitDate = $array['submit_date'];
		$this->id = $array['id'];
	}

	public function getName(){
		return $this->name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function hasSubmit(){
		return $this->hasSubmit;
	}

	public function getDate(){
		return $this->submitDate;
	}

	public function getId(){
		return $this->id;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setHasSubmit($hasSubmit){
		$this->hasSubmit = $hasSubmit;
	}

	public function setDate($submitDate){
		$this->submitDate = $submitDate;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function save(){}

	public function addchoice($choiceId, $conn){
		$query = "insert into users_choices (user_id, choice_id) values ($this->id, $choiceId)";
		$conn->query($query);

		return $conn->insert_id;
	}

}