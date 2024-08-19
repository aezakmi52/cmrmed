document.addEventListener('DOMContentLoaded', () => {
    
    const cartButton = document.getElementById('cart-button');
    const closeCartButton = document.getElementById('close-cart');
    const sideCart = document.getElementById('side-cart');
    const checkoutModal = document.getElementById('checkout-modal');
    const closeModalButton = document.getElementById('close-modal');
    const checkoutForm = document.getElementById('checkout-form');

    cartButton.addEventListener('click', () => {
        sideCart.classList.add('open');
        renderCart();
    });

    closeCartButton.addEventListener('click', () => {
        sideCart.classList.remove('open');
    });

    closeModalButton.addEventListener('click', () => {
        checkoutModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == checkoutModal) {
            checkoutModal.style.display = 'none';
        }
    });

    checkoutForm.addEventListener('submit', (event) => {
        event.preventDefault();
        submitCart();
    });

    renderCart();
});

let cart = JSON.parse(localStorage.getItem('cart')) || {};


function addToCart(productName, quantity) {
    if (cart[productName]) {
        cart[productName] += quantity;
    } else {
        cart[productName] = quantity;
    }
    saveCart();
    renderCart();
}

function removeFromCart(productName) {
    delete cart[productName];
    saveCart();
    renderCart();
}

function renderCart() {
    const cartContainer = document.getElementById('cart');
    cartContainer.innerHTML = ''; 

    if (Object.keys(cart).length === 0) {
        cartContainer.innerHTML = '<p>Нет товаров</p>';
        return;
    }

    for (const product in cart) {
        const cartItem = document.createElement('div');
        cartItem.className = 'cart-item';
        cartItem.innerHTML = `
            <span>${product}<br>Кол-во: ${cart[product]}</span>
            <button onclick="removeFromCart('${product}')">Удалить</button>
        `;
        cartContainer.appendChild(cartItem);
    }
}

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function openCheckoutModal() {
    const checkoutModal = document.getElementById('checkout-modal');
    checkoutModal.style.display = 'block';
}

function submitCart() {
    const form = document.getElementById('checkout-form');
    const formData = new FormData(form);
    const customerData = {
        name: formData.get('name'),
        org: formData.get('org'),
        email: formData.get('email'),
        address: formData.get('address'),
        cart: cart
    };

    fetch('submit_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(customerData)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        localStorage.removeItem('cart'); 
        cart = {}; 
        renderCart();
        const checkoutModal = document.getElementById('checkout-modal');
        checkoutModal.style.display = 'none';
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


renderCart();