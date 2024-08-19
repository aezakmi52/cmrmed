<?php

include 'config.php';

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$cart = json_decode(file_get_contents('php://input'), true);

$name = $cart['name'];
$org = $cart['org'];
$email = $cart['email'];
$address = $cart['address'];
$cart = $cart['cart'];

if ($cart === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}


$stmt = $conn->prepare("INSERT INTO orders (name, organization, email, address) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $org, $email, $address);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();



foreach ($cart as $product => $quantity) {
    $stmt = $conn->prepare("INSERT INTO cart_items (order_id, product_name, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $order_id, $product, $quantity);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

//$admin_email = "dnogikhin@mail.ru";
//$subject = "Получен еовый заказ";
//$message = "A new order has been placed:\n\n" . print_r($cart, true);
//$headers = "From: no-reply@example.com";

//mail($admin_email, $subject, $message, $headers);


$response = [
    'status' => 'success',
    'message' => 'Cart received and saved',
    'cart' => $cart
];

echo json_encode($response);

?>