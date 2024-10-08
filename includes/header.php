<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="favicon-32x32.png" type="image/png">
    <title>Центр Медицинских Решений</title>
</head>
<body>
<header>
    <div class="menu">
        <input type="checkbox" id="burger-checkbox" class="burger-checkbox">
        <label for="burger-checkbox" class="burger"></label>
        <ul class="menu-list">
            <li><a href="?page=home" class="menu-item">Главная</a><li>
            <li><a href="?page=store" class="menu-item">Каталог</a><li>
            <li><a href="?page=micro" class="menu-item">Микроорганизмы</a><li>
            <li><a href="?page=contact" class="menu-item">Контакты</a><li>
            <button id="cart-button-mobile">Корзина (<span id="cart-count-mobile">0</span>)</button>
        </ul>
    </div> 
    <div id="side-cart" class="side-cart">
        <h2>Корзина</h2>
        <div id="cart" class="cart"></div>
        <button onclick="openCheckoutModal()">Оформить</button>
        <button id="close-cart" class="close-cart">Закрыть</button>
    </div>  
    <div id="toast" class="toast">Товар добавлен в корзину!</div> 
    <div class="container">
        <div class="header-inner">
            <div class="header-inner-top">
                <img src="../img/logo3.png" alt="logo" class="logo">
                <div class="header-contact">
                    <div class="header-contact-telephone">
                        <img src="../img/phone-icon.png" alt="telephone">
                        <a href="">8 499 68-58-988</a>
                    </div>
                    <div class="header-contact-telephone">
                        <img src="../img/phone-icon.png" alt="telephone">
                        <a href="">8 991 174-57-00</a>
                    </div>
                    <form action="#feedback"><button action="#feedback">Обратный звонок</button></form>
                </div>
            </div>
            <div class="header-inner-bot">
                <nav>
                    <ul>
                        <a href="?page=home">Главная</a>    
                        <a href="?page=store">Каталог</a>
                        <a href="?page=micro">Микроорганизмы</a> 
                        <a href="?page=contact">Контакты</a>
                        <button id="cart-button">Корзина (<span id="cart-count">0</span>)</button>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div id="checkout-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Укажите свои данные</h2>
            <form id="checkout-form">
                <label for="name">Имя</label>
                <input type="text" id="name" name="name" required>
                <label for="org">Организация</label>
                <input type="text" id="org" name="org" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="address">Телефон</label>
                <input type="text" id="address" name="address" required>
                <label for="comment">Комментарии</label>
                <textarea id="comment" name="comment" rows="4" cols="50"></textarea>
                <button type="submit">Оформить заказ</button>
            </form>
        </div>
    </div>
</header>
<script src="js/cart.js"></script>