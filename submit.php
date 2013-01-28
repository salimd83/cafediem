<?php 
session_start();
if(!isset($_SESSION['userid'])){
	header('Location: ../subscribe.php');
	exit;
}

print_r($_POST)
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
		if(is_numeric($choiceId) && $questionId != 20){
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

			if($questionId == 20){
				$age = $choiceId;
				if($age >= 26) $points++;
			}

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

	if($points > 14){
		$to  = $user->getEmail(); // note the comma

		// subject
		$subject = 'Congratulations! You Have Won!';
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
				<a href='http://www.facebook.com/cafediemrestaurant'>
					http://www.facebook.com/cafediemrestaurant
				</a>
			</p>

			<p>The CAFE DIEM team</p>

		</body>
		</html>
		";

		$headers = "MIME-Version: 1.0\r\n"
		  ."Content-Type: text/html; charset=utf-8\r\n"
		  ."Content-Transfer-Encoding: 8bit\r\n"
		  ."From: =?UTF-8?B?". base64_encode('CAFE DIEM - Artisan Kitchen') ."?= <info@cafediem.com>\r\n"
		  ."X-Mailer: PHP/". phpversion();

		// To send HTML mail, the Content-type header must be set
		//$headers  = 'MIME-Version: 1.0' . "\r\n";
		//$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		// Additional headers
		//$headers .= 'To: '.$user->getName().' <'.$user->getEmail().'>' . "\r\n";
		//$headers .= 'From: CAFE DIEM - Artisan Kitchen <info@cafediem.fr>' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers, "-f info@cafediem.com");


		//send email to admins
		$to2  = 'boudy@wondereight.com, care@cjb.me, salim@wondereight.com, yasmine@wondereight.com'; // note the comma

		// subject
		$subject2 = 'A visitor has won at cafediem.fr';
		// message
		$message2 = "
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

		$headers = "MIME-Version: 1.0\r\n"
		  ."Content-Type: text/plain; charset=utf-8\r\n"
		  ."Content-Transfer-Encoding: 8bit\r\n"
		  ."From: =?UTF-8?B?". base64_encode('Café Diem - Artisan Kitchen') ."?= <info@cafediem.com>\r\n"
		  ."X-Mailer: PHP/". phpversion();

		// To send HTML mail, the Content-type header must be set
		//$headers2  = 'MIME-Version: 1.0' . "\r\n";
		//$headers2 .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		// Additional headers
		//$headers2 .= 'To: Boudy Nasrala <boudy@wondereight.com>' . "\r\n";
		//$headers2 .= 'From: Café Diem - Artisan Kitchen <info@cafediem.fr>' . "\r\n";

		// Mail it
		mail($to2, $subject2, $message2, $headers2, "-f info@cafediem.com");
	}

	if(isset($_SESSION['userid'])) unset($_SESSION['userid']);

	session_destroy();

	echo($points);