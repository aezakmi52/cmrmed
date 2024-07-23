<body>
    <div class="container">
        <div class="product">
            
        <?php
            if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM baza WHERE id=$id";
            $result = $conn->query($sql);
            
            if ($result === false) {
                echo "Error: " . $conn->error;
            } else { 
                if ($result->num_rows > 0) {
                    $item = $result->fetch_assoc();
                    ?>
                    <div class="product-wrapper">
                        <img src="img/<?php echo htmlspecialchars($item['photo']);?>" alt="<?php echo htmlspecialchars($item['name']);?>">
                        <div class="product-desc">
                            <h1><?php echo htmlspecialchars($item['name']);?></h1>
                            <p>Артикул: <?php echo htmlspecialchars($item['art']);?></p>
                            <p>Категория: <?php echo htmlspecialchars($item['kat']);?></p>
                            <ul>
                                <li><b>Фасовка:</b> <?php echo htmlspecialchars($item['fas']);?></li>
                                <li><b>Микроорганизмы:</b> <?php echo htmlspecialchars($item['micro']);?></li>
                                <li><b>Направлениe:</b> <?php echo htmlspecialchars($item['direct']);?></li>
                                <li><b>Производитель:</b> <?php echo htmlspecialchars($item['fabric']);?></li>
                                <li><b>Регистрационное удостоверение:</b> <?php echo htmlspecialchars($item['cert']);?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="description">
                        <h1>Описание</h1>
                        <p><?php echo htmlspecialchars($item['descript']);?></p>
                    </div>
                    <?php
                } else {
                    echo '<p>Item not found</p>';
                }
            }
        } else {
            echo '<p>No item ID specified</p>';
        }
        ?>
        </div>
        <div class="feedback">
            <h1>Обратная связь</h1>
            <p>Наш сотрудник ответит вам в ближайшее время</p>
            <form action="#" method="post">
                <div>
                    <input type="text" placeholder="Имя">
                    <input type="tel" placeholder="Телефон" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                </div>
                <button type="submit">Заказать звонок</button>
            </form>
        </div>
    </div>
</body>
</html>
