//ADD TO CART
function addToCart(prodId) {
    const modal = document.getElementById('quickViewModal');
    const quantityInput = modal.querySelector('.quantity-wrap input');
    const quantity = parseInt(quantityInput.value) || 1;

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: prodId,
            quantity: quantity
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                showToast(data.message, data.status);
                modal.classList.remove('show')
                updateCartBadge(data.cartCount);
            } else {
                alert('Error adding product to cart.');
            }
        })
        .catch(err => {
            console.error('Cart error:', err);
        });
}

function updateCartBadge(count) {
    const badge = document.getElementById("cartBadge");
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = "inline-block";
    } else {
        badge.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", () => {
    fetch("/cart/count")
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                updateCartBadge(data.count);
            }
        });
});

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}

document.getElementById("sCart").addEventListener("click", () => {
    const dropdown = document.getElementById("cartDropdown");
    dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";

    fetch("/cart/view")
        .then(res => res.json())
        .then(data => {
            const cartItemsContainer = document.getElementById("cartItems");
            const cartSubtotal = document.getElementById("cartSubtotal");
            const subTotalLabel = document.getElementById("subTotalLabel");
            cartItemsContainer.innerHTML = "";

            if (data.status && data.items.length > 0) {
                let subtotal = 0;
                data.items.forEach(item => {
                    subtotal += item.quantity * item.price;
                    cartItemsContainer.innerHTML += `
                        <div class="cart-item">
                            <img src="/${item.image}" alt="${item.name}" class="innerIMG">
                            <div>
                                <div>${item.name}</div>
                                <div>${item.quantity} × ₱${item.price.toFixed(2)}</div>
                            </div>
                            <span style="cursor:pointer;" onclick="removeFromCart(${item.id})">×</span>
                        </div>
                    `;
                });


                cartSubtotal.textContent = `₱${subtotal.toFixed(2)}`;
            } else {
                cartItemsContainer.innerHTML = "<p style='text-align: center'>Your cart is empty.</p>";
                cartSubtotal.style.display = "none";
                subTotalLabel.style.display = "none";
                // document.getElementById('checkOutBTN').disabled = 'true';

            }
        });
});


function removeFromCart(cartId) {
    fetch(`/cart/remove/${cartId}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ _method: 'DELETE' })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                const itemToRemove = document.querySelector(`.cart-item[data-cart-id="${cartId}"]`);
                if (itemToRemove) {
                    itemToRemove.remove();
                }

                updateCartDropdown();
            } else {
                alert('Failed to remove item.');
            }
        })
        .catch(err => {
            console.error('Cart error:', err);
        });
}



function updateCartDropdown() {
    fetch('/cart/items')
        .then(res => res.json())
        .then(data => {
            const dropdown = document.getElementById('cartDropdown');
            const cartItemsWrapper = document.getElementById('cartItems');
            const subtotalElem = document.getElementById('cartSubtotal');
            const cartBadge = document.getElementById('cartBadge');

            cartItemsWrapper.innerHTML = '';

            if (data.status && data.items.length > 0) {
                let subtotal = 0;

                data.items.forEach(item => {
                    subtotal += item.prod_price * item.quantity;

                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('cart-item');
                    itemDiv.innerHTML = `
                        <img src="/${item.prod_img}" alt="${item.prod_name}" class="cart-thumb">
                        <div class="cart-details">
                            <p>${item.prod_name}</p>
                            <p>${item.quantity} × ₱${item.prod_price.toFixed(2)}</p>
                        </div>
                        <button class="remove-btn" onclick="removeFromCart(${item.id})">×</button>
                    `;

                    cartItemsWrapper.appendChild(itemDiv);
                });

                subtotalElem.textContent = `₱${subtotal.toFixed(2)}`;
                cartBadge.textContent = data.items.length;
                cartBadge.style.display = 'inline-block';
                dropdown.style.display = 'block';

            } else {
                cartItemsWrapper.innerHTML = `<p>Your cart is empty.</p>`;
                subtotalElem.textContent = `₱0.00`;
                cartBadge.style.display = 'none';
                dropdown.style.display = 'none';
            }
        })
        .catch(err => {
            console.error('Cart update error:', err);
        });
}



