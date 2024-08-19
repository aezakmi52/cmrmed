<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
</head>
<body>
    <h1>Вход</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="username">Имя пользователя</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Вход</button>
    </form>
</body>
</html>