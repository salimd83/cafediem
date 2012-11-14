<?php

if(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))){
	define("HOST", 'localhost');
	define("USER", 'root');
	define("PASS", '');
	define("DATABASE", 'cafediem');
}else{
	define("HOST", 'localhost');
	define("USER", 'luapocom_diem');
	define("PASS", '4yrIre@u1Ovo');
	define("DATABASE", 'luapocom_cafediem');
}

$conn = new mysqli(HOST, USER, PASS, DATABASE);

/* check connection */
if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}