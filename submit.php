<?php session_start() ?>

<?php 
if(!isset($_SESSION['userid'])){
	header('Location: ../subscribe.php');
}
?>

<?php 
	require_once('models/questions.php');
	require_once('models/question.php');
	require_once('models/choice.php');
	require_once('models/users.php');
	require_once('models/user.php');

	require_once('includes/create_conn.php');

	//var_export($_POST) ."\n\r";

	$userId = $_SESSION['userid'];

	//$query = "select * from users where id = {$userId}";
	//$result = $conn->query($query);

	//$row = $result->fetch_assoc();

	$user = Users::retrieveByPk($userId, $conn);

	//echo $user->getName();
	//echo "\n\r-----------------\n\r";

	$points = 0;
	foreach($_POST as $key => $value){
		$questionId = $key;
		$choiceId = $value;

		//var_export($choiceId.", is_numeric: ". is_numeric($choiceId));
		//echo "\n\r";

		//first check if the choice(=question) exist in the db 
		//in case the user chose a custom question
		if(is_numeric($choiceId)){
			$user->addChoice($choiceId, $conn);

			$query = "select * from choices where id = $choiceId";
			//echo $query."\r\n";
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			if($row['is_correct']){
				$points++;
				//echo "added 1 points \n\r";
			}
		}else if(is_array($choiceId)){
			foreach($choiceId as $key => $value){
				if(is_numeric($value) && $value != 0){
					$user->addChoice($value, $conn);

					$query = "select * from choices where id = $value";
					//echo $query."\r\n";
					$result = $conn->query($query);
					$row = $result->fetch_assoc();
					if($row['is_correct']){
						$points++;
						//echo "added 1 points \n\r";
					}
				}
			}
		}else{
			$query = "select * from choices where LOWER(answer) = LOWER('$choiceId')";
			//echo $query."\r\n";
			$result = $conn->query($query);
			if($row = $result->fetch_assoc()){
				$choiceId = $row['id'];
			}else{
				//insert the custom answer as a choice in the database
				$query = "insert into choices (answer, is_correct, question_id, is_custom) values ('$choiceId', 0, $questionId, 1)";
				//echo $query."\r\n";
				$result = $conn->query($query);
				$choiceId = mysqli_insert_id($conn);
			}

			$user->addChoice($choiceId, $conn);
		}
		
		$question = Questions::retrieveByPk($questionId, $conn);
		//echo $question->getType()."\n\r";
	}

	$date = date('Y-m-d H:i:s');
	$user->setSubmitDate($date);
	$user->setHasSubmit(1);
	$user->setScore($points);
	$query = $user->save();

	if($points > 9){
		$to  = $user->getEmail(); // note the comma

		// subject
		$subject = 'Congratulation you have won';
		// message
		$message = "
		<html>
		<head>
		  <title>Congratulation you're a winner.</title>
		</head>
		<body>
		  <p>
		  	Thank you for participating in CafeDiem quiz.<br />
		  	You won an invitation for 2 person. Your name and email has been registered in our system.<br />
		  	You can visit us any time before 01/01/2013.<br />
		  	<br />
		  	--<br />
		  	CafeDiem.com<br /><br />
		  </p>
		</body>
		</html>
		";

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: '.$user->getName().' <'.$user->getEmail().'>' . "\r\n";
		$headers .= 'From: Wonder Eight <salim@wondereight.com>' . "\r\n";

		// Mail it
		@mail($to, $subject, $message, $headers);
	}

	if(isset($_SESSION['userid']))
	  unset($_SESSION['userid']);

	session_destroy();

	echo($points);