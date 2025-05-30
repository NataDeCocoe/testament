function loadCartPageItems() {
    fetch('/cart/items')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('cartItemsContainer');
            container.innerHTML = '';

            const subtotalElem = document.getElementById('subtotal');
            const itemCountElem = document.getElementById('itemCount');
            const totalElem = document.getElementById('total');

            if (!data.status || data.items.length === 0) {
                container.innerHTML = '<p style="text-align: center">Your cart is empty.</p>';
                subtotalElem.textContent = '₱0.00';
                itemCountElem.textContent = '0';
                totalElem.textContent = '₱0.00';
                document.getElementById('pCheckout').disabled = 'true';
                return;
            }

            let subtotal = 0;
            let totalItems = 0;

            data.items.forEach(item => {
                subtotal += item.prod_price * item.quantity;
                totalItems += item.quantity;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'cart-item';
                itemDiv.innerHTML = `
                    <div class="item-image">
                        <img src="/${item.prod_img}" alt="${item.prod_name}" class="innerIMG" loading="lazy">
                    </div>
                    <div class="item-details">
                        <div class="item-name">${item.prod_name}</div>
                        <div class="item-variant">${item.prod_desc || ''}</div>
                    </div>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <span class="qty-value">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                    <div class="item-price">₱${(item.prod_price * item.quantity).toFixed(2)}</div>
                    <button class="remove-btn" onclick="removeFromCart(${item.id})">×</button>
                `;

                container.appendChild(itemDiv);
            });

            subtotalElem.textContent = `₱${subtotal.toFixed(2)}`;
            itemCountElem.textContent = totalItems;
            totalElem.textContent = `₱${(subtotal).toFixed(2)}`; // assuming ₱50 shipping
        })
        .catch(err => console.error('Error loading cart:', err));
}

function updateQuantity(cartId, newQty) {
    if (newQty < 1) return;

    fetch(`/cart/update/${cartId}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ quantity: newQty })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status) loadCartPageItems();
            else alert('Failed to update quantity.');
        });
}

function removeFromCart(cartId) {
    fetch(`/cart/remove/${cartId}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ _method: 'DELETE' })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status) loadCartPageItems();
            else alert('Failed to remove item.');
        });
}

window.addEventListener('DOMContentLoaded', loadCartPageItems);