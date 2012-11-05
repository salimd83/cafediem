<?php session_start() ?>

<?php 
	require_once('models/questions.php');
	require_once('models/question.php');
	require_once('models/choice.php');
	require_once('models/user.php');

	require_once('includes/create_conn.php');

	var_export($_POST) ."\n\r";

	$userid = $_SESSION['userid'];

	$query = "select * from users where id = {$userid}";
	$result = $conn->query($query);

	$row = $result->fetch_assoc();

	$user = new User($row);

	echo $user->getName();
	echo "\n\r-----------------\n\r";

	foreach($_POST as $key => $value){
		$questionId = $key;
		$choiceId = $value;

		$question = Questions::retrieveByPk($questionId, $conn);
		echo $question->getType()."\n\r";
	}