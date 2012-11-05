<?php
require_once('config.php');

$conn = new mysqli(HOST, USER, PASS, DATABASE);

/* check connection */
if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}