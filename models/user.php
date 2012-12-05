<?php

class User{

	private $name;
	private $email;
	private $mobile;
	private $hasSubmit;
	private $submitDate;
	private $score;
	private $id;

	private $conn;

	public function __construct(array $array = array(), $conn){
		if(!empty($array)){
			$this->name = $array['name'];
			$this->email = $array['email'];
			$this->mobile = $array['mobile'];
			$this->hasSubmit = $array['has_submit'];
			$this->submitDate = $array['submit_date'];
			$this->score = $array['score'];
			$this->id = $array['id'];
		}

		$this->conn = $conn;
	}

	public function getName(){
		return $this->name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getMobile(){
		return $this->mobile;
	}

	public function hasSubmit(){
		return $this->hasSubmit;
	}

	public function getSubmitDate(){
		return $this->submitDate;
	}

	public function getScore(){
		return $this->score;
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

	public function setMobile($mobile){
		$this->mobile = $mobile;
	}

	public function setHasSubmit($hasSubmit){
		$this->hasSubmit = $hasSubmit;
	}

	public function setSubmitDate($submitDate){
		$this->submitDate = $submitDate;
	}

	public function setScore($score){
		$this->score = $score;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function save(){
		$query = "update users 
				  set name='$this->name', 
				  	  email='$this->email',
				  	  mobile='$this->mobile', 
				  	  has_submit=$this->hasSubmit, 
				  	  submit_date='$this->submitDate',
				  	  score=$this->score
				  where id = $this->id";
		
		$this->conn->query($query);
		return $query;
	}

	public function addchoice($choiceId){
		$query = "insert into users_choices (user_id, choice_id) values ($this->id, $choiceId)";
		$this->conn->query($query);

		return $this->conn->insert_id;
	}

}