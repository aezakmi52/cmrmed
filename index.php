<?php

include 'config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'store':
        $content = 'pages/store.php';
        break;
    case 'product':
        $content = 'pages/product.php';
        break;
    case 'polit':
        $content = 'pages/polit.php';
        break;
    case 'micro':
        $content = 'pages/micro.php';
        break;
    case 'contact':
        $content = 'pages/contact.php';
        break;
    default:
        $content = 'pages/home.php';
}

include 'includes/header.php';
include $content;
include 'includes/footer.php';

$conn->close();

?>