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

function updateOrderSummary() {
    fetch('/checkout/getItems')
        .then(res => res.json())
        .then(data => {
            if (data.status && Array.isArray(data.items)) {
                const orderSummary = document.querySelector('.order-summary');
                let subtotal = 0;
                let summaryHTML = `<h2 style="margin-top: 0;">ORDER SUMMARY</h2>`;

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

                const feeInput = document.getElementById('shippingFeeInput');
                let shippingFee = 0;
                if (feeInput && feeInput.value && !isNaN(parseFloat(feeInput.value))) {
                    shippingFee = parseFloat(feeInput.value);
                }

                const grandTotal = subtotal + shippingFee;

                summaryHTML += `
                    <div class="summary-item">
                      <span>Merchandise Subtotal</span>
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
            } else {
                console.warn('Cart is empty or invalid response.');
            }
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
}

// Trigger once when page loads
updateOrderSummary();

// Trigger again after selecting shipping address
document.getElementById('addressSelect')?.addEventListener('change', () => {
    const checkShippingSet = setInterval(() => {
        const feeInput = document.getElementById('shippingFeeInput');
        if (feeInput && feeInput.value && !isNaN(parseFloat(feeInput.value))) {
            clearInterval(checkShippingSet);
            updateOrderSummary(); // Now we know shipping fee is set
        }
    }, 200); // Check every 200ms

    // Optional: Stop trying after 5 seconds
    setTimeout(() => clearInterval(checkShippingSet), 5000);
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
                alert("Your cart is empty.");
                return;
            }

            // Calculate subtotal
            let subtotal = 0;
            cartData.items.forEach(item => {
                subtotal += item.prod_price * item.quantity;
            });

            // Get dynamic shipping fee (from hidden input)
            const shippingFeeInput = document.getElementById('shippingFeeInput');
            const shippingFee = parseFloat(shippingFeeInput?.value || 0);

            const grandTotal = subtotal + shippingFee;

            // Prepare items
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

            // Get form inputs
            const firstNameInput = document.getElementById('firstname');
            const lastNameInput = document.getElementById('lastname');
            const phoneInput = document.getElementById('phone');
            const buildingInput = document.getElementById('building');
            const zipInput = document.getElementById('zip');
            const selectedRegionCode = document.getElementById('region').value;
            const selectedProvinceCode = document.getElementById('province').value;
            const selectedMunicipalityId = document.getElementById('muncity').value;
            const selectedBarangayCode = document.getElementById('barangay').value;

            if (
                !selectedRegionCode ||
                !selectedProvinceCode ||
                !selectedMunicipalityId ||
                !selectedBarangayCode
            ) {
                alert("Please select all delivery address fields properly.");
                return;
            }

            // Get courier
            const courierInput = document.querySelector('#deliveryOptions input[name="delivery"]:checked');
            const selectedCourier = courierInput ? courierInput.value : null;

            // Get payment method
            const paymentOptions = document.querySelectorAll('.payment-option');
            let selectedPaymentMethod = null;
            paymentOptions.forEach(option => {
                if (option.classList.contains('selected')) {
                    const text = option.textContent.toLowerCase();
                    if (text.includes('cash')) selectedPaymentMethod = 'Cash on Delivery';
                    else if (text.includes('paypal')) selectedPaymentMethod = 'paypal';
                }
            });

            // Validate text fields
            if (
                !firstNameInput.value.trim() ||
                !lastNameInput.value.trim() ||
                !phoneInput.value.trim() ||
                !buildingInput.value.trim() ||
                !zipInput.value.trim()
            ) {
                alert("Please fill all required fields.");
                return;
            }

            // Validate phone number format
            const phone = phoneInput.value.trim();
            if (!/^09\d{9}$/.test(phone)) {
                alert("Phone number must start with 09 and be exactly 11 digits.");
                return;
            }

            if (!selectedCourier) {
                alert("Please select a delivery option.");
                return;
            }
            if (!selectedPaymentMethod) {
                alert("Please select a payment method.");
                return;
            }

            const data = {
                firstName: firstNameInput.value.trim(),
                lastName: lastNameInput.value.trim(),
                phone: phone,
                building: buildingInput.value.trim(),
                zip: zipInput.value.trim(),
                region_code: selectedRegionCode,
                province_code: selectedProvinceCode,
                muncity_id: selectedMunicipalityId,
                barangay_code: selectedBarangayCode,
                courier: selectedCourier,
                payment_method: selectedPaymentMethod,
                subtotal: subtotal,
                total: grandTotal,
                items: items,
                shipping_fee: shippingFee
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
                    const text = await res.text();

                    if (!contentType || !contentType.includes('application/json')) {
                        console.error("Response is not JSON, here's the raw response:", text);
                        throw new Error(`Expected JSON but received non-JSON response.`);
                    }

                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error("Failed to parse JSON:", e, "Response text:", text);
                        throw e;
                    }
                })
                .then(response => {
                    if (response.status === 'success') {
                        fetch('/cart/clear', {
                            method: 'POST'
                        })
                            .then(res => res.json())
                            .then(clearRes => {
                                if (clearRes.status === 'success') {
                                    alert("Order placed and cart cleared!");
                                    window.location.href = "/success";
                                } else {
                                    alert("Order placed, but failed to clear cart.");
                                }
                            });
                    } else {
                        alert("Order failed: " + response.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Error placing order. See console for details.");
                });

        })
        .catch(err => {
            console.error("Failed to fetch cart items:", err);
            alert("Could not get cart items. Please try again.");
        });
});








