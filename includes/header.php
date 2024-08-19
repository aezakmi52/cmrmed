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
            <li><a href="?page=store&type=ИФА" class="menu-item">ИФА</a><li>
            <li><a href="?page=store&type=ПЦР" class="menu-item">ПЦР</a><li>
            <li><a href="?page=store&type=Экспресс тесты" class="menu-item">Экспресс тесты</a><li>
            <li><a href="?page=store&type=Пит. среды" class="menu-item">Питательные среды</a><li>
            <li><a href="?page=store&type=Оборудование" class="menu-item">Оборудование</a><li>
        </ul>
    </div>
    <button class="cart-button" id="cart-button">Корзина</button>
    <div id="side-cart" class="side-cart">
        <h2>Корзина</h2>
        <div id="cart" class="cart"></div>
        <button onclick="openCheckoutModal()">Оформить</button>
        <button id="close-cart" class="close-cart">Закрыть</button>
    </div>   
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
                        <a href="?page=store&type=ИФА">ИФА</a>
                        <a href="?page=store&type=ПЦР">ПЦР</a>
                        <a href="?page=store&type=Экспресс тесты">Экспресс тесты</a>
                        <a href="?page=store&type=Пит. среды">Питательные среды</a>
                        <a href="?page=store&type=Оборудование">Оборудование</a>
                        <a href="?page=store&type">Контакты</a>
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
                <label for="address">Адрес</label>
                <input type="text" id="address" name="address" required>
                <button type="submit">Оформить заказ</button>
            </form>
        </div>
    </div>
</div>
</header>
<script src="js/cart.js"></script>