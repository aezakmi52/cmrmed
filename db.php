<?php
$servername = "localhost";
$username = "SQLuser"; // замените на ваше имя пользователя
$password = "esorun93"; // замените на ваш пароль
$dbname = "cmrmed";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>