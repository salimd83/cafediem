<?php
session_start();

require('../config.php');

$conn = new mysqli(HOST, USER, PASS, DATABASE);

/* check connection */
if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

if(isset($_GET['a']) && $_GET['a']=='create'){

	$name = $_POST['name'];
	$email = $_POST['email'];

	if(empty($name) || empty($email)){
		header('Location: ../subscribe.php?required');
		exit;
	}

	$query = "select * from users where email = '{$email}' limit 1";

	if ($result = $conn->query($query)) {
		$rows = $result->num_rows;

		//check if email is used
	    if($result->num_rows){
	    	//if used make sure the user has filled quizz
	    	$row = $result->fetch_assoc();
	    	$hasSubmit = $row['has_submit'];
	    	if($hasSubmit){
	    		header('Location: ../subscribe.php?hasubmit');
				exit;
	    	}
	    	$_SESSION['userid']= $row['id'];
		    header('Location: ../quiz.php');
		    $result->close();
			exit;
	    }else{
	    	//create new user
	    	$query = "insert into users (name, email) values ('{$name}', '{$email}')";
	    	echo $query;
	    	if ($conn->query($query) === TRUE) {
			    $_SESSION['userid']= $conn->insert_id;
			    header('Location: ../quiz.php');
				exit;
			}
	    }
	    
	} 
}