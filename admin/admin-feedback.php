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


$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Заявки обратной связи</title>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
</head>
<body>
    <h1>Заявки обратной связи</h1>
    <a href="admin.php" class="back-button">Вернуться в панель администратора</a>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                    <th>Дата создания</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Нет заявок.</p>
    <?php endif; ?>
</body>
</html>