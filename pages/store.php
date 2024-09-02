<body>
    <?php
            $sql = "SELECT * FROM product";
            $result = $conn->query($sql);

            if ($result === false) {
                echo "Error: " . $conn->error;
            } else { 
                if ($result->num_rows > 0) {
                    $item = $result->fetch_assoc();
    ?>
    <div class="title">Каталог</div>
    <div class ="container">  
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Поиск">
            <button class="clearButton" id="clearButton">Очистить</button>
        </div>
    </div>
    <div class="store-page">
        <div class="wrapper">  
            <div class="filter-container">
                <button class="filter-btn" id="filter-btn">Фильтр</button>
                <div class="filter-dropdown" id="filter-dropdown">
                    <div class="filter-section">
                        <label for="manufacturer">Производитель</label>
                        <select id="manufacturer">
                        <?php
                        
                        $sql = "SELECT * FROM fabric";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['fabric_filter']) . '">' . htmlspecialchars($row['fabric_name']) . '</option>';
                            }
                        } else {
                            echo "No items found";
                        }

                    ?>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="direction">Направление</label>
                        <select id="direction">
                        <?php
                        
                        $sql = "SELECT * FROM direct";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['direct_filter']) . '">' . htmlspecialchars($row['direct_name']) . '</option>';
                            }
                        } else {
                            echo "No items found";
                        }

                    ?>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="category">Категория</label>
                        <select id="category">
                            <?php
                        
                                $sql = "SELECT * FROM category";
                                $result = $conn->query($sql);
                            
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row['category_filter']) . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                    }
                                } else {
                                    echo "No items found";
                                }

                            ?>
                        </select>
                    </div>
                    <button class="apply-filters-btn" id="apply-filters-btn">Применить</button>
                </div>
            </div> 
            <div class="store-wrapper">
                <div class="store">
                    
                <?php
                    
                    $sql = "SELECT id, name, photo, art, fabric_name, fabric_filter, category_filter, GROUP_CONCAT(direct_name) as directs, GROUP_CONCAT(direct_filter) as directs_filters FROM  product  INNER JOIN category on product.category_id = category.category_id 
                                                                                                                            INNER JOIN fabric on product.fabric_id = fabric.fabric_id 
                                                                                                                            INNER JOIN direct_has_product on product.id = direct_has_product.product_id
                                                                                                                            INNER JOIN direct on direct_has_product.direct_id = direct.direct_id
                                                                                                                            group by id";
                    $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<a href="?page=product&id=' . $row['id'] . '" class="store-card" data-manufacturer="' . htmlspecialchars($row['fabric_filter']) . '" data-direction="' . htmlspecialchars($row['directs_filters']) . '" data-category="' . htmlspecialchars($row['category_filter']) . '">';
                                echo '<h1>' . htmlspecialchars($row['name']) . '</h1>';
                                echo '<img src="img-product/' . htmlspecialchars($row['photo']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                                echo '<p>Артикул:' . htmlspecialchars($row['art']) . '</p>';
                                echo '<p>Производитель:' . htmlspecialchars($row['fabric_name']) . '</p>';
                            }
                        } else {
                            echo "No items found";
                        }

                        ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
                } else {
                    echo '<p>Item not found</p>';
                }
            }
        ?>
    <script src="js/search.js"></script>
    <script src="js/filter.js"></script>
</body>
</html>