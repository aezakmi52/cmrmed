<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$servername = "localhost";
$username = "SQLuser";
$password = "esorun93";
$dbname = "cmrmed";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка подключения к базе данных']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string(trim($_POST['contact-name']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));


    if (empty($name) || empty($phone)) {
        echo json_encode(['status' => 'error', 'message' => 'Пожалуйста, заполните все поля.']);
        exit;
    }


    $stmt = $conn->prepare("INSERT INTO feedback (name, phone) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $phone);

    if ($stmt->execute()) {

        $mail = new PHPMailer(true);
        try {

            $mail->isSMTP();
            $mail->Host       = 'mail.cmrmed.ru';
            $mail->SMTPAuth   = false;
            $mail->Port       = 465;

            $mail->setFrom('sale@cmrmed.ru', 'site');  
            $mail->addAddress('dnogikhin@mail.ru');  

            $mail->Subject = 'Новая заявка на обратную связь';
            $mail->Body    = "Имя: $name\nТелефон: $phone";
           
            $mail->send();

            
            echo json_encode(['status' => 'success', 'message' => 'Спасибо за ваше сообщение! Мы свяжемся с вами.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "Не удалось отправить письмо: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при сохранении данных в базу.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Неверный метод запроса.']);
}

$conn->close();

?>