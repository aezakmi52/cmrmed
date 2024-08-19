<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "SQLuser";
$password = "esorun93";
$dbname = "cmrmed";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "DELETE FROM product WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header('Location: products.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>