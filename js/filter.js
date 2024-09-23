
document.addEventListener('DOMContentLoaded', () => {
    const filterBtn = document.getElementById('filter-btn');
    const filterDropdown = document.getElementById('filter-dropdown');

    filterBtn.addEventListener('click', () => {
        filterDropdown.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
        if (!filterBtn.contains(event.target) && !filterDropdown.contains(event.target)) {
            filterDropdown.classList.remove('show');
        }
    });

    const applyFiltersBtn = document.getElementById('apply-filters-btn');
    const resetFiltersButton = document.getElementById('reset-filters-btn');

    const manufacturerSelect = document.getElementById('manufacturer');
    const microSelect = document.getElementById('micro');
    const categorySelect = document.getElementById('category');
    const productCards = document.querySelectorAll('.store-card');

    function restoreFilters() {
        const savedFilters = JSON.parse(localStorage.getItem('filters')) || {
            manufacturer: 'all',
            micro: 'all',
            category: 'all'
        };

        manufacturerSelect.value = savedFilters.manufacturer;
        microSelect.value = savedFilters.micro;
        categorySelect.value = savedFilters.category;

        applyFilters(savedFilters);
    }

    function saveFilters(filters) {
        localStorage.setItem('filters', JSON.stringify(filters));
    }

    applyFiltersBtn.addEventListener('click', () => {
        const filters = {
            manufacturer: manufacturerSelect.value,
            micro: microSelect.value,
            category: categorySelect.value
        };

        applyFilters(filters);
        saveFilters(filters);
        filterDropdown.classList.remove('show');
    });

    function applyFilters(filters) {
        const items = document.querySelectorAll('.store-card');
        let visibleItemsCount = 0;
    
        items.forEach(item => {
            const itemManufacturer = item.getAttribute('data-manufacturer');
            const itemMicro = item.getAttribute('data-micro');
            const itemCategory = item.getAttribute('data-category');
    
            let isVisible = true;
    
            if (filters.manufacturer !== 'all' && filters.manufacturer !== itemManufacturer) {
                isVisible = false;
            }
    
            if (filters.micro !== 'all' && filters.micro !== itemMicro) {
                isVisible = false;
            }
    
            if (filters.category !== 'all' && filters.category !== itemCategory) {
                isVisible = false;
            }
    
            item.style.display = isVisible ? 'block' : 'none';
    
            if (isVisible) {
                visibleItemsCount++;
            }
        });
    
        const noProductsMessage = document.getElementById('no-products-message');
    
        if (visibleItemsCount === 0) {
            noProductsMessage.style.display = 'block'; 
        } else {
            noProductsMessage.style.display = 'none';
        }
    }

    resetFiltersButton.addEventListener('click', function() {
        manufacturerSelect.value = 'all';
        microSelect.value = 'all';
        categorySelect.value = 'all';

        const filters = {
            manufacturer: 'all',
            micro: 'all',
            category: 'all'
        };

        applyFilters(filters);
        localStorage.removeItem('filters');
    });


    const microItems = document.querySelectorAll('.micro-item');
    microItems.forEach(item => {
        item.addEventListener('click', () => {
            const selectedMicro = item.getAttribute('data-micro');

            microSelect.value = selectedMicro;
            const filters = {
                manufacturer: manufacturerSelect.value,
                micro: selectedMicro,
                category: categorySelect.value
            };

            applyFilters(filters);
            saveFilters(filters); 
        });
    });

    restoreFilters();
});