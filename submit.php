<?php 
session_start();
if(!isset($_SESSION['userid'])){
	header('Location: ../subscribe.php');
	exit;
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
				Hey there!
			</p>

			<p>
				You sure know how to seize the day! You have won an invitation for 2. <br />
				We're safely guarding your information and we will contact you as soon as we open.
			</p>
			<p>
				Meanwhile, you can keep an eye on us on Facebook :) <br />
				<a href='http://www.facebook.com/pages/Caf%C3%A9-Diem/487377867960864?ref=stream'>
					http://www.facebook.com/pages/Caf%C3%A9-Diem/487377867960864?ref=stream
				</a>
			</p>

			<p>The Café Diem team</p>

			<p>PS: I thought we can advertise the Facebook page in the email, if u think that's not appropriate do tell me.</p>
		</body>
		</html>
		";

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: '.$user->getName().' <'.$user->getEmail().'>' . "\r\n";
		$headers .= 'From: Cafe Diem <info@cafediem.fr>' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);


		//send email to admins
		$to  = 'boudy@wondereight.com, care@cjb.me'; // note the comma

		// subject
		$subject = 'A visitor has won at cafediem.fr';
		// message
		$message = "
		<html>
		<head>
		  <title>A visitor has won at cafediem.fr</title>
		</head>
		<body>
			<p>
				Hey there!
			</p>

			<p>
				A new user have won,<br />
				Name: {$user->getName()}<br />
				Email: {$user->getEmail()}<br />
				Mobile: {$user->getMobile()}<br />
			</p>

		</body>
		</html>
		";

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: '.$user->getName().' <'.$user->getEmail().'>' . "\r\n";
		$headers .= 'From: Cafe Diem <info@cafediem.fr>' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);
	}

	if(isset($_SESSION['userid'])) unset($_SESSION['userid']);

	session_destroy();

	echo($points);