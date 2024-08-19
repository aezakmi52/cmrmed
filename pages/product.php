<body>
    <div class="container">
        <div class="product">
            
        <?php
            if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM product  INNER JOIN category on product.category_id = category.category_id 
                                           INNER JOIN fabric on product.fabric_id = fabric.fabric_id 
                                           INNER JOIN direct_has_product on product.id = direct_has_product.product_id
                                           INNER JOIN direct on direct_has_product.direct_id = direct.direct_id
                                           WHERE id=$id";
            $result = $conn->query($sql);
            
            if ($result === false) {
                echo "Error: " . $conn->error;
            } else { 
                if ($result->num_rows > 0) {
                    $item = $result->fetch_assoc();
                    ?>
                    <div class="product-wrapper">
                        <img src="img-product/<?php echo htmlspecialchars($item['photo']);?>" alt="<?php echo htmlspecialchars($item['name']);?>">
                        <div class="product-desc">
                            <h1><?php echo htmlspecialchars($item['name']);?></h1>
                            <p>Артикул: <?php echo htmlspecialchars($item['art']);?></p>
                            <p>Категория: <?php echo htmlspecialchars($item['category_name']);?></p>
                            <ul>
                                <li><b>Фасовка:</b> <?php echo htmlspecialchars($item['fas']);?></li>
                                <li><b>Микроорганизмы:</b> <?php echo htmlspecialchars($item['micro']);?></li>
                                <li><b>Направлениe:</b> <?php 
                                                                $sql1 = "SELECT GROUP_CONCAT(direct_name) as directs FROM  product  INNER JOIN category on product.category_id = category.category_id 
                                                                                                                        INNER JOIN fabric on product.fabric_id = fabric.fabric_id 
                                                                                                                        INNER JOIN direct_has_product on product.id = direct_has_product.product_id
                                                                                                                        INNER JOIN direct on direct_has_product.direct_id = direct.direct_id
                                                                                                                        WHERE id=$id";
                                                                $result1 = $conn->query($sql1);
                                                                $item1 = $result1->fetch_assoc();
                                                                echo htmlspecialchars($item1['directs']);?>
                                </li>
                                <li><b>Производитель:</b> <?php echo htmlspecialchars($item['fabric_name']);?></li>
                                <li><b>Регистрационное удостоверение:</b> <?php echo htmlspecialchars($item['docs']);?></li>
                            </ul>
                            <button onclick="addToCart('<?php echo htmlspecialchars($item['name']); ?>', 1)">Добавить в корзину</button>
                        </div>
                    </div>
                    <div class="description">
                        <h1>Описание</h1>
                        <p><?php echo htmlspecialchars($item['desc']);?></p>
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
