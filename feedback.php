<?php

session_start();

$servername = "localhost";
$username = "SQLuser";
$password = "esorun93";
$dbname = "cmrmed";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $sql = "INSERT INTO feedback (name, phone) VALUES ('$name', '$phone')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Спасибо за ваше сообщение!";
    } else {
        $_SESSION['message'] = "Ошибка: " . $sql . "<br>" . $conn->error;
    }
} else {
    $_SESSION['message'] = "Неверный метод запроса.";
}


$conn->close();

header('Location: index.php');
exit;
?>