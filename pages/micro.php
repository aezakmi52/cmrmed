<body>
    <div class="sorting">
        <form id="sortForm" method="GET">
            <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page']); ?>">
            <label for="sort">Сортировать по:</label>
            <select name="sort" id="sort">
                <option value="count" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'count') echo 'selected'; ?>>Количество позиций</option>
                <option value="name" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'name') echo 'selected'; ?>>Алфавитный порядок</option>
            </select>
        </form>
    </div>
    <a href="#sortForm" class="up-button">Наверх</a>
    <div class="layout">
        <div class="sidebar">
            <?php

            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'count';

            if ($sort == 'name') {
                $microSql = "SELECT count(micro) as count, micro FROM product GROUP BY micro ORDER BY micro ASC";
            } else {
                $microSql = "SELECT count(micro) as count, micro FROM product GROUP BY micro ORDER BY count DESC";
            }

            $microResult = $conn->query($microSql);

            if ($microResult === false) {
                echo "Error: " . $conn->error;
            } else {
                if ($microResult->num_rows > 0) {
                    while ($micro = $microResult->fetch_assoc()) {
                        echo '<button class="tab-button-micro" data-target="' . htmlspecialchars($micro['micro']) . '" data-title="' . htmlspecialchars($micro['micro']) . '">';
                        echo htmlspecialchars($micro['micro']) . ' (' . htmlspecialchars($micro['count']) . ')';
                        echo '</button>';
                    }
                } else {
                    echo '<p class="not-found">Категории не найдены</p>';
                }
            }
            ?>
        </div>

        <div class="content">
            <h2 id="activeTabTitle">Выберите категорию</h2>

            <?php
            $microResult->data_seek(0); 
            while ($micro = $microResult->fetch_assoc()) {
                $microEscaped = $conn->real_escape_string($micro['micro']);
                
                echo '<div id="' . htmlspecialchars($micro['micro']) . '" class="tab-content-micro">';
                $productsSql = "SELECT id, name, photo, art, fabric_name, fabric_filter, category_filter, micro FROM product 
                                INNER JOIN category ON product.category_id = category.category_id 
                                INNER JOIN fabric ON product.fabric_id = fabric.fabric_id 
                                where product.micro = '$microEscaped'
                                GROUP BY id";
                $productsResult = $conn->query($productsSql);

                if ($productsResult->num_rows > 0) {
                    echo '<div class="store">';
                    while ($row = $productsResult->fetch_assoc()) {
                        echo '<a href="index.php?page=product&id=' . $row['id'] . '&sort=' . urlencode($sort) . '" class="store-card" data-manufacturer="' . htmlspecialchars($row['fabric_filter']) . '" data-micro="' . htmlspecialchars($row['micro']) . '" data-category="' . htmlspecialchars($row['category_filter']) . '">';
                        echo '<h1>' . htmlspecialchars($row['name']) . '</h1>';
                        echo '<img src="img-product/' . htmlspecialchars($row['photo']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                        echo '<p>Артикул: ' . htmlspecialchars($row['art']) . '</p>';
                        echo '<p>Производитель: ' . htmlspecialchars($row['fabric_name']) . '</p>';
                        echo '</a>';
                    }
                    echo '</div>';
                } else {
                    echo '<p class="not-found">Товары не найдены</p>';
                }
                
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <script src="js/accordion.js"></script>
</body>