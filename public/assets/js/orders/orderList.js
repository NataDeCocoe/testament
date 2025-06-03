document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".order-status").forEach(select => {
        updateDropdownColor(select);

        select.addEventListener("change", function () {
            const orderId = this.dataset.id;
            const newStatus = this.value;

            updateDropdownColor(this);
            updateStatus(orderId, 'order_status', newStatus);
        });
    });


    document.querySelectorAll(".payment-status").forEach(select => {
        updateDropdownColor(select);

        select.addEventListener("change", function () {
            const orderId = this.dataset.id;
            const newStatus = this.value;

            updateDropdownColor(this);
            updateStatus(orderId, 'payment_status', newStatus);
        });
    });

    function updateStatus(orderId, statusType, value) {
        fetch('/orders/orders-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                order_id: orderId,
                field: statusType,
                value: value
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast("Status updated successfully.");
                    setInterval(() => updateStatus() , 1000);
                } else {
                    showToastError("Failed to update.");
                }
            });
    }

    function updateDropdownColor(dropdown) {
        const status = dropdown.value;
        const allClasses = [
            'status-approved', 'status-processing', 'status-shipped',
            'status-completed', 'status-canceled',
            'payment-unpaid', 'payment-paid', 'payment-failed'
        ];
        dropdown.classList.remove(...allClasses);


        if (dropdown.classList.contains("order-status")) {
            if (status) dropdown.classList.add('status-' + status);
        } else if (dropdown.classList.contains("payment-status")) {
            switch (status.toLowerCase()) {
                case 'unpaid':
                    dropdown.classList.add('payment-unpaid');
                    break;
                case 'paid':
                    dropdown.classList.add('payment-paid');
                    break;
                case 'failed':
                    dropdown.classList.add('payment-failed');
                    break;
            }
        }
    }
});

// OREDER DETAILS MODAL
document.querySelectorAll('.orders-row').forEach(row => {
    row.addEventListener('click', async function (e) {

        if (e.target.tagName === 'SELECT' || e.target.closest('select')) return;

        const orderId = this.dataset.id;

        try {
            const res = await fetch(`/pending-orders/details/${orderId}`);
            const data = await res.json();

            const order = data.order;
            const products = data.products;

            let productHTML = `
        <h3 style="margin-top: 20px;">Ordered Products</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
          ${products.map(p => `
            <div style="
              border: 1px solid #ccc;
              padding: 12px;
              border-radius: 8px;
              background: #fdfdfd;
              display: flex;
              flex-direction: column;
              gap: 6px;
              width: 95%;
            ">
              <p style="margin: 0;"><strong>${p.product_name}</strong></p>
              <p style="margin: 0;">Quantity: ${p.quantity}</p>
              <p style="margin: 0;">Price: ₱${parseFloat(p.prod_price).toFixed(2)}</p>
              <p style="margin: 0;"><strong>Total:</strong> ₱${parseFloat(p.total_price).toFixed(2)}</p>
            </div>
          `).join('')}
        </div>`;

            const html = `
        <p><strong>Name:</strong> ${order.ord_fname} ${order.ord_lname}</p>
        <p><strong>Contact Number:</strong> ${order.contact_number}</p>
        <p><strong>Delivery Address:</strong> ${order.delivery_address}</p>
        <p><strong>Building Address:</strong> ${order.building_address}</p>
        <p><strong>Zip Code:</strong> ${order.zip_code}</p>
        <p><strong>Courier:</strong> ${order.courier}</p>
        <p><strong>Payment Method:</strong> ${order.payment_method}</p>
        <p><strong>Subtotal:</strong> ₱${parseFloat(order.subtotal).toFixed(2)}</p>
        <p><strong>Shipping Fee:</strong> ₱${parseFloat(order.shipping_fee).toFixed(2)}</p>
        <p><strong>Total Payment:</strong> ₱${parseFloat(order.total_amount).toFixed(2)}</p>
        <p><strong>Order Date:</strong> ${new Date(order.ordered_at).toLocaleString()}</p>
        <hr>
        ${productHTML}
      `;

            document.getElementById('OrderedDetailsContent').innerHTML = html;
            document.getElementById('OrderedDetailsModal').style.display = 'flex';
        } catch (error) {
            showToastError('Failed to load order details. Please try again later.')
            console.error('Error loading order details:', error);
        }
    });
});


document.querySelector('#OrderedDetailsModal .close').addEventListener('click', () => {
    document.getElementById('OrderedDetailsModal').style.display = 'none';
});
document.getElementById('OrderedDetailsModal').addEventListener('click', function (e) {
    if (e.target === this) {
        this.style.display = 'none';
    }
});

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}

function showToastError(message, type = 'error') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}