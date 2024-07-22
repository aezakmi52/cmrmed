
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
    applyFiltersBtn.addEventListener('click', () => {
        const category = document.getElementById('category').value;
        const manufacturer = document.getElementById('manufacturer').value;
        const direction = document.getElementById('direction').value;

        applyFilters({ category, manufacturer, direction });

        filterDropdown.classList.remove('show');
    });

    function applyFilters(filters) {
        const items = document.querySelectorAll('.store-card');

        items.forEach(item => {
            const itemCategory = item.getAttribute('data-category');
            const itemManufacturer = item.getAttribute('data-manufacturer');
            const itemDirection = item.getAttribute('data-direction');

            let isVisible = true;

            if (filters.category !== 'all' && filters.category !== itemCategory) {
                isVisible = false;
            }

            if (filters.manufacturer !== 'all' && filters.manufacturer !== itemManufacturer) {
                isVisible = false;
            }

            if (filters.direction !== 'all' && filters.direction !== itemDirection) {
                isVisible = false;
            }
            
            if (isVisible) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
});