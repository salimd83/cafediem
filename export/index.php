<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=winners.csv");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../models/users.php');
require_once('../models/user.php');

require_once('../includes/create_conn.php');

$users = Users::retrieveAll($conn);

?>

Full Name, Email, Mobile, Submit Date, Score, is winner
<?php
foreach($users as $user){
	$isWinner = '';
	$score = $user->getScore();
	if($score > 14){
		$isWinner = 'Yes';
	}else{
		$isWinner = 'No';
	}
	echo "{$user->getName()},"; 
	echo "{$user->getEmail()},";
	echo "{$user->getMobile()},"; 
	echo "{$user->getSubmitDate()},";
	echo "{$user->getScore()},";
	echo "{$isWinner}\n";
}