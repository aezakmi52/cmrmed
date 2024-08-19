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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $art = $conn->real_escape_string($_POST['art']);
    $description = $conn->real_escape_string($_POST['desc']);
    $fas = $conn->real_escape_string($_POST['fas']);
    $micro = $conn->real_escape_string($_POST['micro']);
    $category_id = $conn->real_escape_string($_POST['category']);
    $fabric_id = $conn->real_escape_string($_POST['fabric']);
    $photo = $conn->real_escape_string($_POST['photo']);
    $directs = isset($_POST['directs']) ? $_POST['directs'] : [];

    $sql = "INSERT INTO product (name, art,  `desc`, fas, micro, category_id, fabric_id, photo) VALUES ('$name', '$art', '$description', '$fas', '$micro', '$category_id', '$fabric_id', '$photo')";
    if ($conn->query($sql) === TRUE) {
        $product_id = $conn->insert_id;

        foreach ($directs as $direct_id) {
            $direct_id = $conn->real_escape_string($direct_id);
            $conn->query("INSERT INTO direct_has_product (product_id, direct_id) VALUES ('$product_id', '$direct_id')");
        }

        header('Location: products.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $categoriesResult = $conn->query("SELECT * FROM category");
    $fabricResult = $conn->query("SELECT * FROM fabric");
    $directResult = $conn->query("SELECT * FROM direct");
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Добавление товара</title>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
</head>
<body>
    <h1>Добавление товара</h1>
    <a href="products.php" class="back-button">Вернуться обратно</a>
    <form method="POST" action="add-product.php">
        <label for="name">Название</label>
        <input type="text" id="name" name="name" required>
        <label for="name">Артикул</label>
        <input type="text" id="art" name="art" required>
        <label for="desc">Описание</label>
        <textarea id="desc" name="desc"></textarea>
        <label for="fas">Фасовка</label>
        <input type="text" id="fas" name="fas" required>
        <label for="micro">Микроорганизмы</label>
        <input type="text" id="micro" name="micro" required>
        <label for="category">Категория</label>
        <select id="category" name="category">
            <?php while ($category = $categoriesResult->fetch_assoc()): ?>
                <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
            <?php endwhile; ?>
        </select>
        <label>Направления</label>
        <?php while ($direct = $directResult->fetch_assoc()): ?>
            <div class="directs">
                <label for="direct<?= $direct['direct_id'] ?>"><?= htmlspecialchars($direct['direct_name']) ?></label>
                <input type="checkbox" id="direct<?= $direct['direct_id'] ?>" name="directs[]" value="<?= $direct['direct_id'] ?>">
            </div>
        <?php endwhile; ?>
        <label for="fabric">Производитель</label>
        <select id="fabric" name="fabric">
            <?php while ($fabric = $fabricResult->fetch_assoc()): ?>
                <option value="<?= $fabric['fabric_id'] ?>"><?= htmlspecialchars($fabric['fabric_name']) ?></option>
            <?php endwhile; ?>
        </select>
        <label for="photo">Название фото (фото должно находиться в папке img-product)</label>
        <input type="text" id="photo" name="photo">
        <button type="submit">Добавить товар</button>
    </form>
</body>
</html>