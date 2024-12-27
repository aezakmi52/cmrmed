function applySearch() {
    const searchInput = document.getElementById('search-input').value.trim();
    const manufacturer = document.getElementById('manufacturer').value;
    const category = document.getElementById('category').value;

    const activeMicro = document.querySelector('.micro-item.active');
    const micro = activeMicro ? activeMicro.getAttribute('data-micro') : 'all';

    window.location.href = `?page=store&search=${encodeURIComponent(searchInput)}&manufacturer=${manufacturer}&micro=${micro}&category=${category}`;
}