<body>
    <div class="container">
        <?php
        $microSql = "SELECT count(micro) as count, micro FROM product
                     group by micro";
        $microResult = $conn->query($microSql);

        if ($microResult === false) {
            echo "Error: " . $conn->error;
        } else {
            if ($microResult->num_rows > 0) {
                while ($micro = $microResult->fetch_assoc()) {
                    echo '<div class="accordion">';
                    echo '<div class="accordion-header">' . htmlspecialchars($micro['micro']) . ' (' . htmlspecialchars($micro['count']) . ')</div>';
                    echo '<div class="accordion-content">';
                    
                    $microEscaped = $conn->real_escape_string($micro['micro']);

                    $productsSql = "SELECT id, name, photo, art, fabric_name, fabric_filter, category_filter, micro FROM product 
                                    INNER JOIN category ON product.category_id = category.category_id 
                                    INNER JOIN fabric ON product.fabric_id = fabric.fabric_id 
                                    where product.micro = '$microEscaped'
                                    GROUP BY id";
                    $productsResult = $conn->query($productsSql);

                    if ($productsResult->num_rows > 0) {
                        echo '<div class="store">';
                        while ($row = $productsResult->fetch_assoc()) {
                            echo '<a href="?page=product&id=' . $row['id'] . '" class="store-card" data-manufacturer="' . htmlspecialchars($row['fabric_filter']) . '" data-micro="' . htmlspecialchars($row['micro']) . '" data-category="' . htmlspecialchars($row['category_filter']) . '">';
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
                    echo '</div>'; 
                }
            } else {
                echo '<p class="not-found">Категории не найдены</p>';
            }
        }
        ?>
    </div>
    <script src="js/accordion.js"></script>
</body>