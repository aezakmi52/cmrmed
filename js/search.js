const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        searchItems(query);
    })

function searchItems(query) {
    const items = document.querySelectorAll('.store-card');

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