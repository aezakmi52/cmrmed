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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['desc']);
    $category_id = $conn->real_escape_string($_POST['category']);
    $fabric_id = $conn->real_escape_string($_POST['fabric']);
    $photo = $conn->real_escape_string($_POST['photo']);
    $directs = isset($_POST['directs']) ? $_POST['directs'] : [];

    $sql = "UPDATE product SET name='$name', `desc`='$description', category_id='$category_id', fabric_id='$fabric_id', photo='$photo' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {

        $conn->query("DELETE FROM direct_has_product WHERE product_id='$id'");
        foreach ($directs as $direct_id) {
            $direct_id = $conn->real_escape_string($direct_id);
            $conn->query("INSERT INTO direct_has_product (product_id, direct_id) VALUES ('$id', '$direct_id')");
        }

        header('Location: products.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $result = $conn->query("SELECT * FROM product WHERE id='$id'");
    $product = $result->fetch_assoc();
    $categoriesResult = $conn->query("SELECT * FROM category");
    $fabricResult = $conn->query("SELECT * FROM fabric");
    $directResult = $conn->query("SELECT * FROM direct");

    $directsResult = $conn->query("SELECT direct_id FROM direct_has_product WHERE product_id='$id'");
    $productDirects = [];
    while ($row = $directsResult->fetch_assoc()) {
        $productDirects[] = $row['direct_id'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Изменение товара</title>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
</head>
<body>
    <h1>Изменение товара</h1>
    <a href="products.php" class="back-button">Вернуться обратно</a>
    <form method="POST" action="edit-product.php?id=<?= $id ?>">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <label for="name">Название</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <label for="desc">Описание</label>
        <textarea id="desc" name="desc"><?= htmlspecialchars($product['desc']) ?></textarea>
        <label for="category">Категория</label>
        <select id="category" name="category">
            <?php while ($category = $categoriesResult->fetch_assoc()): ?>
                <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $product['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['category_name']) ?></option>
            <?php endwhile; ?>
        </select>
        <label>Направления</label>
        <?php while ($direct = $directResult->fetch_assoc()): ?>
            <div class="directs">
                <label for="direct<?= $direct['direct_id'] ?>"><?= htmlspecialchars($direct['direct_name']) ?></label>    
                <input type="checkbox" id="direct<?= $direct['direct_id'] ?>" name="directs[]" value="<?= $direct['direct_id'] ?>" <?= in_array($direct['direct_id'], $productDirects) ? 'checked' : '' ?>> 
            </div>
        <?php endwhile; ?>
        <label for="fabric">Производитель</label>
        <select id="fabric" name="fabric">
            <?php while ($fabric = $fabricResult->fetch_assoc()): ?>
                <option value="<?= $fabric['fabric_id'] ?>" <?= $fabric['fabric_id'] == $product['fabric_id'] ? 'selected' : '' ?>><?= htmlspecialchars($fabric['fabric_name']) ?></option>
            <?php endwhile; ?>
        </select>
        <label for="photo">Название фото (фото должно находиться в папке img-product)</label>
        <input type="text" id="photo" name="photo" value="<?= htmlspecialchars($product['photo']) ?>">
        <button type="submit">Изменить товар</button>
    </form>
</body>
</html>