<?php

include 'config.php';

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$cart = json_decode(file_get_contents('php://input'), true);

$name = $cart['name'];
$org = $cart['org'];
$email = $cart['email'];
$address = $cart['address'];
$comment = $cart['comment'];
$cart_items = $cart['cart'];

if ($cart_items === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO orders (name, organization, email, address, comment) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $org, $email, $address, $comment);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

foreach ($cart_items as $product_name => $quantity) {
    $stmt = $conn->prepare("INSERT INTO cart_items (order_id, product_name, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $order_id, $product_name, $quantity);
    $stmt->execute();
    $stmt->close();
}


$message = "Получен новый заказ:\n\n";
$message .= "Имя клиента: $name\n";
$message .= "Организация: $org\n";
$message .= "Email: $email\n";
$message .= "Адрес: $address\n";
$message .= "Комментарий: $comment\n";
$message .= "\nТовары в заказе:\n";

foreach ($cart_items as $product_name => $quantity) {
    $message .= "Товар: $product_name, Количество: $quantity\n";
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail.cmrmed.ru'; 
    $mail->SMTPAuth = false;
    $mail->Port = 465;

    $mail->setFrom('sale@cmrmed.ru', 'site'); 

    $mail->addAddress('dnogikhin@mail.ru');

    $mail->Subject = 'Получен новый заказ';

    $mail->Body = $message;

    $mail->send();

    $conn->close();

    echo json_encode([
        'status' => 'success',
        'message' => 'Заказ получен и сохранен, письмо отправлено',
        'cart' => $cart_items
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка отправки email: ' . $mail->ErrorInfo
    ]);
}
?>
