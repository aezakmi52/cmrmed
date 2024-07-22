<?php

phpinfo();

$host = "localhost";
$username = "SQLuser";
$password = "esorun93";
$dbname = "cmrmed";

try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

?>