document.addEventListener('DOMContentLoaded', function () {
    fetch('/checkout/getItems')
        .then(res => res.json())
        .then(data => {
            if (data.status && Array.isArray(data.items)) {
                const container = document.querySelector('.order-review-container');
                const header = document.querySelector('.order-review-header');

                data.items.forEach(item => {

                    const html = `
            <div class="product">
              <div class="product-image">
                <img src="${item.prod_img}" alt="${item.prod_name}">
              </div>
              
              <div class="product-details">
                <div class="product-title">${item.prod_name}</div>
                <div class="product-detail"><p>Price: <span>${item.prod_price}</span></p></div>
                <div class="product-detail"><p>Quantity: <span>${item.quantity}</span></p></div>
              </div>
            </div>
          `;
                    if (container) container.insertAdjacentHTML('beforeend', html);
                });

                if (header) {

                    header.innerHTML = `<h1><i class="fas fa-shopping-cart"></i> ORDER REVIEW (${data.items.length} ITEM${data.items.length > 1 ? 'S' : ''})</h1>`;
                }
            }
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
});

//SUMMARY
document.addEventListener('DOMContentLoaded', function () {
    fetch('/checkout/getItems')
        .then(res => res.json())
        .then(data => {
            if (data.status && Array.isArray(data.items)) {
                const orderSummary = document.querySelector('.order-summary');
                let subtotal = 0;
                let summaryHTML = `
          <h2 style="margin-top: 0;">ORDER SUMMARY</h2>
        `;

                data.items.forEach(item => {
                    const itemTotal = item.prod_price * item.quantity;
                    subtotal += itemTotal;

                    summaryHTML += `
            <div class="summary-item">
              <span>${item.quantity} x ${item.prod_name}</span>
              <span>₱${itemTotal.toFixed(2)}</span>
            </div>
          `;
                });

                let perItem = 10;

                let basedShipping = 50;
                const shippingFee = (perItem * data.items.length) + (basedShipping * data.items.length);
                const grandTotal = subtotal + shippingFee;

                summaryHTML += `
          <div class="summary-item">
            <span>Mechandise Subtotal</span>
            <span>₱${subtotal.toFixed(2)}</span>
          </div>
          <div class="summary-item">
            <span>Shipping Subtotal</span>
            <span class="free">₱${shippingFee.toFixed(2)}</span>
          </div>
          <div class="summary-total">
            <span>Total Payment</span>
            <span>₱${grandTotal.toFixed(2)}</span>
          </div>
        `;

                orderSummary.innerHTML = summaryHTML;
            }
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
});

//METHOD OF PAYMENT
document.addEventListener("DOMContentLoaded", function () {
    const paymentContainer = document.querySelector(".payment-options");
    const paymentInput = document.getElementById("payment_method");

    // Fetch payment options from server
    fetch("/payment-options")
        .then(response => response.json())
        .then(options => {
            paymentContainer.innerHTML = ""; // Clear existing content

            options.forEach(option => {
                const div = document.createElement("div");
                div.classList.add("payment-option");
                // if (option.default) div.classList.add("selected");

                div.innerHTML = `
                    <input type="radio" name="payment" id="${option.id}" value="${option.label}" ${option.default ? "checked" : ""} hidden>
                    <label for="${option.id}">${option.label}</label>
                     
                `;

                paymentContainer.appendChild(div);
            });

            // Attach click listeners again after DOM update
            const paymentOptions = document.querySelectorAll(".payment-option");

            paymentOptions.forEach(option => {
                option.addEventListener("click", function () {
                    paymentOptions.forEach(opt => opt.classList.remove("selected"));
                    this.classList.add("selected");
                    const methodText = this.textContent.trim();
                    paymentInput.value = methodText;
                });
            });
        })
        .catch(err => {
            console.error("Failed to load payment options", err);
            paymentContainer.innerHTML = "<p>Error loading payment methods.</p>";
        });
});


//COURIER


document.addEventListener("DOMContentLoaded", function () {
    const deliveryContainer = document.querySelector(".delivery-options");

    fetch("/delivery-options")
        .then(response => response.json())
        .then(options => {
            let html = `<h2>Select delivery</h2>`;

            options.forEach(option => {
                html += `
                <div class="delivery-option ${option.default ? 'selected' : ''}">
                    <input type="radio" name="delivery" id="${option.id}" value="${option.id}" ${option.default ? 'checked' : ''}>
                    <label for="${option.id}">
                        <img src="assets/images/jnt.png" alt="${option.label} logo" class="delivery-logo">
                        <span class="delivery-name"> ${option.label}</span>
                         <span class="delivery-time">(3-5 business days)</span>
                    </label>
                </div>`;
            });

            deliveryContainer.innerHTML = html;
        })
        .catch(err => {
            console.error("Failed to load delivery options", err);
            deliveryContainer.innerHTML = "<p>Error loading delivery options.</p>";
        });
});




document.getElementById("placeOrderBtn").addEventListener("click", () => {
    fetch('/checkout/getItems')
        .then(res => res.json())
        .then(cartData => {
            if (!cartData.items || cartData.items.length === 0) {
                showToastError("Your cart is empty.");
                return;
            }

            let subtotal = 0;
            const perItem = 10;
            const basedShipping = 50;

            cartData.items.forEach(item => {
                subtotal += item.prod_price * item.quantity;
            });

            const shippingFee = (perItem * cartData.items.length) + (basedShipping * cartData.items.length);
            const grandTotal = subtotal + shippingFee;

            const items = cartData.items.map(item => {
                if (!item.prod_id && !item.product_id) {
                    console.error("Item missing product ID:", item);
                    throw new Error("Some items are invalid - missing product ID");
                }

                return {
                    product_id: item.prod_id || item.product_id,
                    quantity: item.quantity,
                    price: item.prod_price || item.price
                };
            });

            const phone = document.getElementById("phone").value.trim();
            if (!/^09\d{9}$/.test(phone)) {
                showToastError("Phone number must start with 09 and be exactly 11 digits.");
                return;
            }

            const zip = document.getElementById("zip").value.trim();
            if (!/^\d+$/.test(zip)) {
                showToastError("Zip code must contain only numbers.");
                return;
            }

            const paymentMethod = document.getElementById("payment_method").value.trim();
            const selectedPaymentRadio = document.querySelector('input[name="payment"]:checked');

            if (!selectedPaymentRadio || !paymentMethod) {
                showToastError("Please select a payment method before placing your order.", 'error');
                return;
            }

            const data = {
                firstName: document.getElementById("firstname").value,
                lastName: document.getElementById("lastname").value,
                phone: phone,
                address: document.getElementById("address").value,
                building: document.getElementById("building").value,
                zip: zip,
                courier: document.querySelector('input[name="delivery"]:checked').value,
                payment_method: paymentMethod,
                shipping_fee: shippingFee,
                subtotal: subtotal,
                total: grandTotal,
                items: items,
            };

            console.log("Sending order data:", data);

            fetch('/orders/place', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
                .then(async res => {
                    const contentType = res.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await res.text();
                        throw new Error(`Expected JSON, got: ${text.substring(0, 100)}`);
                    }
                    return res.json();
                })
                .then(response => {
                    if (response.status === 'success') {
                        fetch('/cart/clear', {
                            method: 'POST'
                        })
                            .then(res => res.json())
                            .then(clearRes => {
                                if (clearRes.status === 'success') {
                                    window.location.href = "/success";
                                } else {
                                    showToastError("Order placed, but failed to clear cart.");
                                }
                            });
                    } else {
                        showToastError("Order failed: " + response.message);
                    }
                })
                .catch(err => {
                    fetch('/orders/place', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    })
                        .then(res => res.text())
                        .then(text => {
                            console.log("Raw server response:", text);
                            showToastError("Error placing order. See console for details.");
                        })
                        .catch(console.error);
                });
        });
});




function showToastError(message, type = 'error') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}

