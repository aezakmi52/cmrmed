const searchInput = document.getElementById('search-input');
const searchButton = document.getElementById('searchButton');

searchButton.addEventListener('click', () => {
    const query = searchInput.value.toLowerCase();
    searchItems(query);
});

searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    
    if (query === '') {
        showAllItems();
    }
});

function searchItems(query) {
    const items = document.querySelectorAll('.store-card');

    if (query !== '') {
        items.forEach(item => {
            const itemName = item.querySelector('h1').textContent.toLowerCase();
            const itemCategory = item.querySelector('p').textContent.toLowerCase();

            if (itemName.includes(query) || itemCategory.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
}

function showAllItems() {
    const items = document.querySelectorAll('.store-card');
    
    items.forEach(item => {
        item.style.display = 'block';
    });
}