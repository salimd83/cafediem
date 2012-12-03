<?php
session_start();

require('../includes/create_conn.php');

if(isset($_GET['a']) && $_GET['a']=='create'){

	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];

	if(empty($name) || empty($email) || empty($mobile)){
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
	    	$query = "insert into users (name, email, mobile) values ('{$name}', '{$email}', '{$mobile}')";
	    	echo $query;
	    	//echo $query;
	    	if ($conn->query($query)) {
			    $_SESSION['userid']= $conn->insert_id;
			    header('Location: ../quiz.php');
				exit;
			}
	    }
	    
	} 
}