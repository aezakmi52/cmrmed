
/*navigation*/

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

    applyFiltersBtn.addEventListener('click', () => {
        const manufacturer = document.getElementById('manufacturer').value;
        const micro = document.getElementById('micro').value;
        const category = document.getElementById('category').value;

        applyFilters({ manufacturer, micro, category });

        filterDropdown.classList.remove('show');
    });

    function applyFilters(filters) {
        const items = document.querySelectorAll('.store-card');

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
        });
    }

    resetFiltersButton.addEventListener('click', function() {
        
        manufacturerSelect.value = 'all';
        microSelect.value = 'all';
        categorySelect.value = 'all';

        productCards.forEach(function (item) {
            item.style.display = 'block';
        });
    });
});