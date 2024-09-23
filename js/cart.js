document.addEventListener('DOMContentLoaded', () => {
    
    const prod = window.productData ? window.productData.name : '';

    const cartButton = document.getElementById('cart-button');
    const cartButtonMobile = document.getElementById('cart-button-mobile');
    const closeCartButton = document.getElementById('close-cart');
    const sideCart = document.getElementById('side-cart');
    const checkoutModal = document.getElementById('checkout-modal');
    const closeModalButton = document.getElementById('close-modal');
    const checkoutForm = document.getElementById('checkout-form');

    window.addEventListener('popstate', () => {
        renderCart(); 
    });

    cartButton.addEventListener('click', () => {
        sideCart.classList.add('open');
        renderCart();
    });

    cartButtonMobile.addEventListener('click', () => {
        sideCart.classList.add('open');
        renderCart();
    });

    closeCartButton.addEventListener('click', () => {
        sideCart.classList.remove('open');
    });

    closeModalButton.addEventListener('click', () => {
        checkoutModal.style.display = 'none';
        document.body.classList.remove('modal-open');
    });

    window.addEventListener('click', (event) => {
        if (event.target == checkoutModal) {
            checkoutModal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }
    });

    checkoutForm.addEventListener('submit', (event) => {
        event.preventDefault();
        submitCart();
    });

    renderCart();
    updateProductQuantityInCart(prod);
});

cart = JSON.parse(localStorage.getItem('cart')) || {};

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

function addToCart(productName, quantity) {
    quantity = parseInt(quantity, 10);
    if (cart[productName]) {
        cart[productName] += quantity;
    } else {
        cart[productName] = quantity;
    }
    saveCart();
    renderCart();
    updateProductQuantityInCart(productName);
    showToast('Товар добавлен в корзину!')
}

function removeFromCart(productName) {
    delete cart[productName];
    saveCart();
    renderCart();
    updateProductQuantityInCart(productName);
}

function updateProductQuantityInCart(productName) {
    const cartQuantityElement = document.getElementById('cart-quantity');
    const productQuantity = cart[productName] || 0;
    if(cartQuantityElement) {
        cartQuantityElement.textContent = productQuantity;
    }
}

function increaseQuantity(productName) {
    cart[productName] += 1; 
    saveCart();
    renderCart();
    updateProductQuantityInCart(productName);
}

function decreaseQuantity(productName) {
    if (cart[productName] > 1) {
        cart[productName] -= 1;
    } else {
        delete cart[productName]; 
    }
    saveCart();
    renderCart();
    updateProductQuantityInCart(productName);
}

function renderCart() {
    const cartContainer = document.getElementById('cart');
    const cartCountElement = document.getElementById('cart-count');
    const cartCountMobileElement = document.getElementById('cart-count-mobile');
    cartContainer.innerHTML = ''; 

    if (Object.keys(cart).length === 0) {
        cartContainer.innerHTML = '<p>Нет товаров</p>';
        cartCountElement.textContent = '0';
        cartCountMobileElement.textContent = '0';
        return;
    }

    let totalItems = 0;

    for (const product in cart) {
        const cartItem = document.createElement('div');
        cartItem.className = 'cart-item';
        cartItem.innerHTML = `
            <span>${product}<br>Кол-во: 
                <button class="cart-count" onclick="decreaseQuantity('${product}')">-</button>
                ${cart[product]}
                <button class="cart-count" onclick="increaseQuantity('${product}')">+</button>
            </span>
            <button  onclick="removeFromCart('${product}')">Удалить</button>
        `;
        cartContainer.appendChild(cartItem);

        totalItems += cart[product]
    }

    cartCountElement.textContent = totalItems;
    cartCountMobileElement.textContent = totalItems;
    textContent = '0';
}

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function openCheckoutModal() {
    const checkoutModal = document.getElementById('checkout-modal');
    checkoutModal.style.display = 'block';
    document.body.classList.add('modal-open');
}

function submitCart() {
    const form = document.getElementById('checkout-form');
    const formData = new FormData(form);
    const customerData = {
        name: formData.get('name'),
        org: formData.get('org'),
        email: formData.get('email'),
        address: formData.get('address'),
        comment: formData.get('comment'),
        cart: cart
    };

    fetch('submit_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(customerData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Ошибка: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Success:', data);
        localStorage.removeItem('cart'); 
        cart = {}; 
        renderCart();
        const checkoutModal = document.getElementById('checkout-modal');
        checkoutModal.style.display = 'none';
        alert('Ваш заказ успешно оформлен!');
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке вашего заказа. Пожалуйста, попробуйте еще раз.');
    });
}

