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
    $result = $conn->query("SELECT * FROM product inner join fabric on product.fabric_id = fabric.fabric_id
                                                  inner join category on product.category_id = category.category_id
                                                  inner join (select group_concat(direct_name) as direct, product_id FROM  product 
                                                  INNER JOIN direct_has_product on product.id = direct_has_product.product_id
                                                  INNER JOIN direct on direct_has_product.direct_id = direct.direct_id
                                                  group by product_id) as directions on  product.id = directions.product_id
                            WHERE name LIKE '%$search%' or `desc` LIKE '%$search%' or fabric_name LIKE '%$search%' or direct LIKE '%$search%'");
} else {
    $result = $conn->query("SELECT * FROM product inner join fabric on product.fabric_id = fabric.fabric_id
                                                  inner join category on product.category_id = category.category_id
                                                  inner join (select group_concat(direct_name) as direct, product_id FROM  product 
                                                  INNER JOIN direct_has_product on product.id = direct_has_product.product_id
                                                  INNER JOIN direct on direct_has_product.direct_id = direct.direct_id
                                                  group by product_id) as directions on  product.id = directions.product_id");
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Управление товарами</title>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
</head>
<body>
    <h1>Управление товарами</h1>
    <a href="admin.php" class="back-button">Вернутся на главную</a>
    <form method="GET" action="products.php">
        <input type="text" name="search" placeholder="Поиск..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Поиск</button>
    </form>
    <a href="add-product.php">Добавить товар &plus;</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Микроорганизмы</th>
                <th>Категория</th>
                <th>Направления</th>
                <th>Производитель</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['desc']) ?></td>
                    <td><?= htmlspecialchars($row['micro']) ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td><?= htmlspecialchars($row['direct']) ?></td>
                    <td><?= htmlspecialchars($row['fabric_name']) ?></td>
                    <td><img src="../img-product/<?= htmlspecialchars($row['photo']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" width="100"></td>
                    <td>
                        <a href="edit-product.php?id=<?= $row['id'] ?>">Изменить</a>
                        <a href="delete-product.php?id=<?= $row['id'] ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>