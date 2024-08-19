<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Панель администратора</title>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
</head>
<body>
    <h1>Панель администратора</h1>
    <nav>
        <ul>
            <li><a href="products.php">Управление товарами</a></li>
            <li><a href="orders.php">Заявки</a></li>
            <li><a href="admin-feedback.php">Заявки обратной связи</a></li>
            <li><a href="logout.php">Выход</a></li>
        </ul>
    </nav>
</body>
</html>