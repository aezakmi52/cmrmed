<?php

$host = 'localhost';
$dbname = 'cmrmed';
$username = 'SQLuser';
$password = 'esorun93';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>