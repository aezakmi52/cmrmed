<body>
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Поиск">
        <button class="search-btn" id="search-btn">Найти</button>
    </div>

    <?php
            if (isset($_GET['type'])) {
            $type = $_GET['type'];
            $sql = "SELECT * FROM baza WHERE type='$type'";
            $result = $conn->query($sql);

            if ($result === false) {
                echo "Error: " . $conn->error;
            } else { 
                if ($result->num_rows > 0) {
                    $item = $result->fetch_assoc();
    ?>
    <div class="title"><?php echo htmlspecialchars($item['type']);?></div>
    <div class="store-page">
        <div class="wrapper">  
            <div class="filter-container">
                <button class="filter-btn" id="filter-btn">Фильтр</button>
                <div class="filter-dropdown" id="filter-dropdown">
                    <div class="filter-section">
                        <label for="manufacturer">Производитель</label>
                        <select id="manufacturer">
                            <option value="all">Все</option>
                            <option value="condalab">Condalab(Испания)</option>
                            <option value="membrane-solutions">Membrane Solutions (КНР)</option>
                            <option value="erba-mannheim">Erba Mannheim (Чехия)</option>
                            <option value="liofilchem">Liofilchem (Италия)</option>
                            <option value="bioanalyse">Bioanalyse (Турция)</option>
                            <option value="microbiologics">Microbiologics (США)</option>
                            <option value="biolife">Biolife (Италия)</option>
                            <option value="P-I-T">P.I.T. (Россия)</option>
                            <option value="bioMedia">BioMedia (Россия)</option>
                            <option value="VEDALAB">VEDALAB (Франция)</option>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="direction">Направление</label>
                        <select id="direction">
                            <option value="all">Все</option>
                            <option value="med">Медицина</option>
                            <option value="san">Санитарные исследования</option>
                            <option value="prom">Промышленность</option>
                            <option value="vet">Ветеринария</option>
                            <option value="science">Наука</option>
                        </select>
                    </div>
                    <button class="apply-filters-btn" id="apply-filters-btn">Применить</button>
                </div>
            </div> 
            <div class="store-wrapper">
                <div class="store">
                    
                <?php
                    
                    $sql = "SELECT * FROM baza where type = '$type'";
                    $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<a href="?page=product&id=' . $row['id'] . '" class="store-card" data-manufacturer="condalab" data-direction="med">';
                                echo '<h1>' . htmlspecialchars($row['name']) . '</h1>';
                                echo '<img src="img/' . htmlspecialchars($row['photo']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                                echo '<p>Артикул:' . htmlspecialchars($row['art']) . '</p>';
                                echo '<p>Производитель:' . htmlspecialchars($row['fabric']) . '</p>';
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
        } else {
            echo '<p>No category specified</p>';
        }
        ?>
    <script src="js/search.js"></script>
    <script src="js/filter.js"></script>
</body>
</html>