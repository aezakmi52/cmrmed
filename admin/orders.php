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

$search = '';
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $orders = $conn->query("SELECT * FROM orders WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR organization LIKE '%$search%' OR `address` LIKE '%$search%' order by id desc");
} else {
    $orders = $conn->query("SELECT * FROM orders order by id desc");
}

$items = $conn->query("SELECT * FROM cart_items");
$products = $conn->query("SELECT * FROM product");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Заявки</title>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
</head>
<body>
    <h1>Заявки</h1>
    <a href="admin.php" class="back-button">Вернутся на главную</a>
    <form method="GET" action="orders.php">
        <input type="text" name="search" placeholder="Поиск..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Поиск</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID Заявки</th>
                <th>Имя заказчика</th>
                <th>Организация заказчика</th>
                <th>Email заказчика</th>
                <th>Адрес заказчика</th>
                <th>Дата и время заказа</th>
                
                <th>Название товара / кол-во / артикул</th>
            </tr>
        </thead>
        <tbody>
            <?php while($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['name']) ?></td>
                    <td><?= htmlspecialchars($order['organization']) ?></td>
                    <td><?= htmlspecialchars($order['email']) ?></td>
                    <td><?= htmlspecialchars($order['address']) ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <ul>
                            <?php
                            foreach ($items as $item) {
                                foreach ($products as $product) {
                                    if ($item['order_id'] == $order['id'] && $product['name'] == $item['product_name']) {
                                        echo '<li>' . htmlspecialchars($item['product_name']) . ' <br><b>Кол-во: </b>' . $item['quantity'] . ' | <b>Артикул:</b> ' . $product['art'] . '</li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>