<?php session_start() ?>

<?php 
	require_once('models/questions.php');
	require_once('models/question.php');
	require_once('models/choice.php');
	require_once('models/user.php');

	require_once('includes/create_conn.php');

	var_export($_POST) ."\n\r";

	$userId = $_SESSION['userid'];

	$query = "select * from users where id = {$userId}";
	$result = $conn->query($query);

	$row = $result->fetch_assoc();

	$user = new User($row);

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
			$query = "insert into users_choices (user_id, choice_id) values ($userId, $choiceId)";
			echo $query."\r\n";
			$conn->query($query);

			$query = "select * from choices where id = $choiceId";
			echo $query."\r\n";
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			if($row['is_correct']){
				$points++;
				echo "added 1 points \n\r";
			}
		}else if(is_array($choiceId)){
			foreach($choiceId as $key => $value){
				if(is_numeric($value) && $value != 0){
					$query = "insert into users_choices (user_id, choice_id) values ($userId, $value)";
					echo $query."\r\n";
					$conn->query($query);

					$query = "select * from choices where id = $value";
					echo $query."\r\n";
					$result = $conn->query($query);
					$row = $result->fetch_assoc();
					if($row['is_correct']){
						$points++;
						echo "added 1 points \n\r";
					}
				}
			}
		}else{
			$query = "select * from choices where LOWER(answer) = LOWER('$choiceId')";
			echo $query."\r\n";
			$result = $conn->query($query);
			if($row = $result->fetch_assoc()){
				$choiceId = $row['id'];
			}else{
				//insert the custom answer as a choice in the database
				$query = "insert into choices (answer, is_correct, question_id, is_custom) values ('$choiceId', 0, $questionId, 1)";
				echo $query."\r\n";
				$result = $conn->query($query);
				$choiceId = mysqli_insert_id($conn);
			}
			echo $choiceId."\r\n";
			$query = "insert into users_choices (user_id, choice_id) values ($userId, $choiceId)";
			echo $query."\r\n";
			$result = $conn->query($query);
		}
		
		$question = Questions::retrieveByPk($questionId, $conn);
		//echo $question->getType()."\n\r";
	}

	echo "Total points collected: ".$points."\r\n";