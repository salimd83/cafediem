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

Full Name, Email, Submit Date, Score
<?php
foreach($users as $user){
	echo "{$user->getName()},"; 
	echo "{$user->getEmail()},"; 
	echo "{$user->getSubmitDate()},";
	echo "{$user->getScore()}\n";
}