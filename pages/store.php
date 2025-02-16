<body>
    <?php
                $itemsPerPage = 15;

                $currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage'] : 1;
                if ($currentPage < 1) {
                    $currentPage = 1;
                }
            
                $offset = ($currentPage - 1) * $itemsPerPage;
            
                $countSql = "SELECT COUNT(*) as total FROM product 
                             INNER JOIN category ON product.category_id = category.category_id 
                             INNER JOIN fabric ON product.fabric_id = fabric.fabric_id
                             WHERE 1=1";
            
                $sql = "SELECT id, name, photo, art, fabric_name, fabric_filter, category_filter, micro 
                        FROM product 
                        INNER JOIN category ON product.category_id = category.category_id 
                        INNER JOIN fabric ON product.fabric_id = fabric.fabric_id 
                        WHERE 1=1";
            
                if (isset($_GET['manufacturer']) && $_GET['manufacturer'] != 'all') {
                    $sql .= " AND fabric_filter = '" . $conn->real_escape_string($_GET['manufacturer']) . "'";
                    $countSql .= " AND fabric_filter = '" . $conn->real_escape_string($_GET['manufacturer']) . "'";
                }
            
                if (isset($_GET['micro']) && $_GET['micro'] != 'all') {
                    $sql .= " AND micro = '" . $conn->real_escape_string($_GET['micro']) . "'";
                    $countSql .= " AND micro = '" . $conn->real_escape_string($_GET['micro']) . "'";
                }
            
                if (isset($_GET['category']) && $_GET['category'] != 'all') {
                    $sql .= " AND category_filter = '" . $conn->real_escape_string($_GET['category']) . "'";
                    $countSql .= " AND category_filter = '" . $conn->real_escape_string($_GET['category']) . "'";
                }

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql .= " AND (name LIKE '%$search%' OR art LIKE '%$search%')";
                    $countSql .= " AND (name LIKE '%$search%' OR art LIKE '%$search%')";
                }
            
                $countResult = $conn->query($countSql);
                $totalItems = $countResult->fetch_assoc()['total'];
            
                $totalPages = ceil($totalItems / $itemsPerPage);
            
                $sql .= " ORDER BY priority DESC, name ASC LIMIT $itemsPerPage OFFSET $offset";
            
                $result = $conn->query($sql);
                ?>
            
                <a href="#forSearch" class="up-button">Наверх</a>
                <div class="top-filter">   
                    <div id="forSearch">
                    <div class="filter-section-top">
                        <label for="manufacturer">Производитель</label>
                        <select id="manufacturer" name="manufacturer" onchange="applyFilters()">
                            <option value="all">Все</option>
                            <?php
                            $microFilter = isset($_GET['micro']) && $_GET['micro'] != 'all' ? " AND EXISTS (SELECT 1 FROM product WHERE product.fabric_id = fabric.fabric_id AND product.micro = '" . $conn->real_escape_string($_GET['micro']) . "')" : '';
                            $categoryFilter = isset($_GET['category']) && $_GET['category'] != 'all' ? " AND EXISTS (SELECT 1 FROM product WHERE product.fabric_id = fabric.fabric_id AND product.category_id = '" . $conn->real_escape_string($_GET['category']) . "')" : '';

                            $fabricSql = "SELECT * FROM fabric WHERE 1=1 AND fabric_filter != 'all' $microFilter $categoryFilter";
                            $fabricResult = $conn->query($fabricSql);

                            if ($fabricResult->num_rows > 0) {
                                while ($row = $fabricResult->fetch_assoc()) {
                                    $selected = (isset($_GET['manufacturer']) && $_GET['manufacturer'] == $row['fabric_filter']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($row['fabric_filter']) . '" ' . $selected . '>' . htmlspecialchars($row['fabric_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="category">Категория</label>
                        <select id="category" name="category" onchange="applyFilters()">
                            <option value="all">Все</option>
                            <?php
                            $microFilter = isset($_GET['micro']) && $_GET['micro'] != 'all' ? " AND EXISTS (SELECT 1 FROM product WHERE product.category_id = category.category_id AND product.micro = '" . $conn->real_escape_string($_GET['micro']) . "')" : '';
                            $manufacturerFilter = isset($_GET['manufacturer']) && $_GET['manufacturer'] != 'all' ? " AND EXISTS (SELECT 1 FROM product WHERE product.category_id = category.category_id AND product.fabric_id = '" . $conn->real_escape_string($_GET['manufacturer']) . "')" : '';

                            $categorySql = "SELECT * FROM category WHERE 1=1 AND category_filter != 'all' $microFilter $manufacturerFilter";
                            $categoryResult = $conn->query($categorySql);

                            if ($categoryResult->num_rows > 0) {
                                while ($row = $categoryResult->fetch_assoc()) {
                                    $selected = (isset($_GET['category']) && $_GET['category'] == $row['category_filter']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($row['category_filter']) . '" ' . $selected . '>' . htmlspecialchars($row['category_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                        <div class="search-container" id="search">
                            <input type="text" id="search-input" placeholder="Поиск" onkeydown="checkEnter(event)" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                            <button class="clearButton" id="searchButton" onclick="applySearch()">Найти</button>
                        </div>
                    </div>
                    
                </div> 
                <div class="store-page">
                    <div class="wrapper">
                        <div class="filter-container">
                            <button class="filter-btn" id="filter-btn">Фильтр</button>
                            <div class="filter-dropdown" id="filter-dropdown">
                            <div class="micro-filter">
                                <h1>Микроорганизмы</h1>
                                <div class="micro-overflow">    
                                    <ul id="micro-list">
                                        <?php
                                        $categoryFilter = isset($_GET['category']) && $_GET['category'] != 'all' ? " AND category_id = '" . $conn->real_escape_string($_GET['category']) . "'" : '';
                                        $manufacturerFilter = isset($_GET['manufacturer']) && $_GET['manufacturer'] != 'all' ? " AND fabric_id = '" . $conn->real_escape_string($_GET['manufacturer']) . "'" : '';

                                        $sqlMicro = "SELECT DISTINCT micro FROM product WHERE micro != '-' $categoryFilter $manufacturerFilter ORDER BY micro ASC";
                                        $resultMicro = $conn->query($sqlMicro);

                                        if ($resultMicro->num_rows > 0) {
                                            while ($rowMicro = $resultMicro->fetch_assoc()) {
                                                $microValue = htmlspecialchars($rowMicro['micro']);
                                                $isActive = isset($_GET['micro']) && $_GET['micro'] === $microValue ? 'active' : '';
                                                echo '<li class="micro-item ' . $isActive . '" data-micro="' . $microValue . '">' . $microValue . '</li>';
                                            }
                                        } else {
                                            echo "<li>Нет данных</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <button class="reset-filters-btn" id="reset-filters-btn" onclick="resetFilters()">Сбросить фильтры</button>
                        </div>
                    </div>
            
                        <div class="store-wrapper">
                            <div class="store">
                                <div id="no-products-message" class="not-found" style="display: none;">Нет товаров, удовлетворяющих условиям</div>
                                <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<a href="?page=product&id=' . $row['id'] . '" class="store-card" data-manufacturer="' . htmlspecialchars($row['fabric_filter']) . '" data-micro="' . htmlspecialchars($row['micro']) . '" data-category="' . htmlspecialchars($row['category_filter']) . '">';
                                        echo '<h1>' . htmlspecialchars($row['name']) . '</h1>';
                                        echo '<img src="img-product/' . htmlspecialchars($row['photo']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                                        echo '<p>Артикул: ' . htmlspecialchars($row['art']) . '</p>';
                                        echo '<p>Производитель: ' . htmlspecialchars($row['fabric_name']) . '</p>';
                                        echo '</a>';
                                    }
                                } else {
                                    echo '<p class="not-found">Не найдено товаров, удовлетворяющих критериям</p>';
                                }
                                ?>
                            </div>
                            <div class="pagination">
    <?php if ($totalPages > 1): ?>
        <div>
            <?php if ($currentPage > 1): ?>
                <a href="?page=store&currentPage=<?php echo $currentPage - 1; ?>&manufacturer=<?php echo $_GET['manufacturer'] ?? 'all'; ?>&micro=<?php echo $_GET['micro'] ?? 'all'; ?>&category=<?php echo $_GET['category'] ?? 'all'; ?>&search=<?php echo $_GET['search'] ?? ''; ?>" class="pagination-link">&lt; Предыдущая</a>
            <?php endif; ?>

            <?php if ($currentPage > 3): ?>
                <a href="?page=store&currentPage=1&manufacturer=<?php echo $_GET['manufacturer'] ?? 'all'; ?>&micro=<?php echo $_GET['micro'] ?? 'all'; ?>&category=<?php echo $_GET['category'] ?? 'all'; ?>&search=<?php echo $_GET['search'] ?? ''; ?>" class="pagination-link">1</a>
                <?php if ($currentPage > 4): ?>
                    <span class="pagination-ellipsis">…</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                <?php if ($i == $currentPage): ?>
                    <span class="pagination-link active"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=store&currentPage=<?php echo $i; ?>&manufacturer=<?php echo $_GET['manufacturer'] ?? 'all'; ?>&micro=<?php echo $_GET['micro'] ?? 'all'; ?>&category=<?php echo $_GET['category'] ?? 'all'; ?>&search=<?php echo $_GET['search'] ?? ''; ?>" class="pagination-link"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages - 2): ?>
                <?php if ($currentPage < $totalPages - 3): ?>
                    <span class="pagination-ellipsis">…</span>
                <?php endif; ?>
                <a href="?page=store&currentPage=<?php echo $totalPages; ?>&manufacturer=<?php echo $_GET['manufacturer'] ?? 'all'; ?>&micro=<?php echo $_GET['micro'] ?? 'all'; ?>&category=<?php echo $_GET['category'] ?? 'all'; ?>&search=<?php echo $_GET['search'] ?? ''; ?>" class="pagination-link"><?php echo $totalPages; ?></a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=store&currentPage=<?php echo $currentPage + 1; ?>&manufacturer=<?php echo $_GET['manufacturer'] ?? 'all'; ?>&micro=<?php echo $_GET['micro'] ?? 'all'; ?>&category=<?php echo $_GET['category'] ?? 'all'; ?>&search=<?php echo $_GET['search'] ?? ''; ?>" class="pagination-link">Следующая &gt;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
                        </div>
                    </div>
            

                </div>
            
                <script src="js/search.js"></script>
                
            
                <script>
                function applyFilters() {
                    const manufacturer = document.getElementById('manufacturer').value;
                    const category = document.getElementById('category').value;

                    const activeMicro = document.querySelector('.micro-item.active');
                    const micro = activeMicro ? activeMicro.getAttribute('data-micro') : 'all';

                    window.location.href = `?page=store&manufacturer=${manufacturer}&micro=${micro}&category=${category}`;
                }

                function checkEnter(event) {
                    if (event.key === "Enter") {
                        applySearch();
                    }
                }

                function resetFilters() {
                    window.location.href = `?page=store&manufacturer=all&micro=all&category=all`;
                }

                document.querySelectorAll('.micro-item').forEach(item => {
                    item.addEventListener('click', function () {
                        document.querySelectorAll('.micro-item').forEach(el => el.classList.remove('active'));
                        this.classList.add('active');
                        applyFilters();
                    });
                });
                </script>
            </body>
</html>