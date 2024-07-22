<body>
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Поиск">
        <button class="search-btn" id="search-btn">Найти</button>
    </div>
    <div class="title">ИФА</div>
    <div class="store-page">
        <div class="wrapper">  
            <div class="filter-container">
                <button class="filter-btn" id="filter-btn">Фильтр</button>
                <div class="filter-dropdown" id="filter-dropdown">
                    <div class="filter-section">
                        <label for="category">Вид товара</label>
                        <select id="category">
                            <option value="all">Все</option>
                            <option value="ifa">ИФА</option>
                            <option value="pcr">ПЦР</option>
                            <option value="express">Экспресс-тесты</option>
                            <option value="oboryd">Оборудование</option>
                            <option value="sredi">Питательные среды</option>
                        </select>
                    </div>
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
            <script src="js/filter.js"></script> 
            <div class="store-wrapper">
                <div class="store">
                    <a href="" class="store-card" data-category="ifa" data-manufacturer="condalab" data-direction="med">
                        <h1>Агар маннит — солевой (Mannitol Salt Agar (MSA) (Chapman Medium USP) (Eur. Pharm.))</h1>
                        <img src="img/test.jpg" alt="store">
                        <p>Артикул: 1062.05</p>
                        <p>Производитель: Condalab (Испания)</p>
                    </a>
                    <a href="" class="store-card" data-category="pcr" data-manufacturer="P-I-T" data-direction="med">
                        <h1>Агар маннит — солевой (Mannitol Salt Agar (MSA) (Chapman Medium USP) (Eur. Pharm.))</h1>
                        <img src="img/uslugi-1.png" alt="store">
                        <p>Артикул: 1062.05</p>
                        <p>Производитель: Condalab (Испания)</p>
                    </a>
                    <a href="" class="store-card" data-category="ifa" data-manufacturer="condalab" data-direction="med">
                        <h1>Агар маннит — солевой (Mannitol Salt Agar (MSA) (Chapman Medium USP) (Eur. Pharm.))</h1>
                        <img src="img/test.jpg" alt="store">
                        <p>Артикул: 1062.05</p>
                        <p>Производитель: Condalab (Испания)</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="js/search.js"></script>
</body>
</html>