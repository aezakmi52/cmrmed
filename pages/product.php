<body>
    <a href="?page=store" class="back-button-product">Назад</a>
    <div class="container">
        <div class="product">
            
        <?php
            if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM product  INNER JOIN category on product.category_id = category.category_id 
                                           INNER JOIN fabric on product.fabric_id = fabric.fabric_id 
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
                                <li><b>Производитель:</b> <?php echo htmlspecialchars($item['fabric_name']);?></li>
                                <li><b>Страна:</b> <?php echo htmlspecialchars($item['country']);?></li>
                                <li><b>Регистрационное удостоверение:</b> <?php echo htmlspecialchars($item['docs']);?></li>
                            </ul>
                            <div class="counter">
                                <label for="quantity">Количество:</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="100">
                            </div>
                            <button onclick="addToCart('<?php echo htmlspecialchars($item['name']); ?>', document.getElementById('quantity').value)">Добавить в корзину</button>
                        </div>
                    </div>
                    <div class="description">
                        <div class="tab-buttons">
                            <button class="tab-btn active" data-tab="description">Описание</button>
                            <button class="tab-btn" data-tab="technical">Техническое назначение</button>
                            <button class="tab-btn" data-tab="functional">Функциональное назначение</button>
                            <button class="tab-btn" data-tab="docs">Документы</button>
                        </div>
                        <div class="tab-content">
                            <div id="description" class="tab-item active">
                                 <p><?php echo htmlspecialchars($item['desc']);?></p>
                            </div>
                            <div id="technical" class="tab-item">
                                <p><?php echo nl2br(htmlspecialchars($item['technical']));?></p>
                            </div>
                            <div id="functional" class="tab-item">
                                <p><?php echo htmlspecialchars($item['function']);?></p>
                            </div>
                            <div id="docs" class="tab-item">
                                <?php if (!empty($item['manual'])): ?>
                                    <a href="pdf/<?php echo htmlspecialchars($item['manual']); ?>" target="_blank">Инструкция &gt;</a>
                                <?php else: ?>
                                    <p><b>Инструкция:</b> Нет документации</p>
                                <?php endif; ?>
                                <?php if (!empty($item['certificate'])): ?>
                                    <a href="pdf/<?php echo htmlspecialchars($item['certificate']); ?>" target="_blank">Регистрационное удостоверение &gt;</a>
                                <?php else: ?>
                                    <p><b>Регистрационное удостоверение:</b> Нет документации</p>
                                <?php endif; ?>
                            </div>
                        </div>
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
<script src="js/descriptionsChanged.js"></script>
</body>
</html>
