document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.orders-row').forEach(row => {
        row.addEventListener('click', function (e) {

            if (e.target.closest('.edit-btn') || e.target.closest('.delete-btn')) return;

            const orderId = this.dataset.id;
            fetch(`/pending-orders/details/${orderId}`)
                .then(res => res.json())
                .then(data => {
                    const order = data.order;
                    const products = data.products;

                    let productHTML = `
                      <h3 style="margin-top: 20px;">Ordered Products</h3>
                      <div style="display: flex; flex-direction: column; gap: 12px;">
                        ${products.map(p => `
                          <div style="
                            border: 1px solid #ccc;
                            padding: 12px;
                            border-radius: 1rem;
                            background: #fdfdfd;
                            display: flex;
                            flex-direction: column;
                            gap: 6px;
                            width: 95%;
                          ">
                            <p style="margin: 0;"><strong>${p.product_name}</strong></p>
                            <p style="margin: 0;">Quantity: ${p.quantity}</p>
                            <p style="margin: 0;">Price per unit: ₱${parseFloat(p.prod_price).toFixed(2)}</p>
                            <p style="margin: 0;"><strong>Total:</strong> ₱${parseFloat(p.total_price).toFixed(2)}</p>
                          </div>
                        `).join('')}
                      </div>
                    `;

                    let html = `
                        <p><strong>Order ID:</strong> ${order.order_id}</p>
                        <p><strong>Name:</strong> ${order.ord_fname} ${order.ord_lname}</p>
                          <p><strong>Contact Number:</strong> ${order.contact_number}</p>
                          <p><strong>Delivery Address:</strong> ${order.delivery_address}</p>
                          <p><strong>Building Address:</strong> ${order.building_address}</p>
                          <p><strong>ZIP Code:</strong> ${order.zip_code}</p>
                          <p><strong>Courier:</strong> ${order.courier}</p>
                          <p><strong>Payment Method:</strong> ${order.payment_method}</p>
                          <p><strong>Subtotal:</strong> ₱${parseFloat(order.subtotal).toFixed(2)}</p>
                          <p><strong>Shipping Fee:</strong> ₱${parseFloat(order.shipping_fee).toFixed(2)}</p>
                          <p><strong>Total Amount:</strong> ₱${parseFloat(order.total_amount).toFixed(2)}</p>
                          <p><strong>Order Date:</strong> ${new Date(order.ordered_at).toLocaleString()}</p>
                          <hr>
                          ${productHTML}
                    `;

                    document.getElementById('PendingOrderDetailsContent').innerHTML = html;
                    document.getElementById('PendingOrderDetailsModal').style.display = 'flex';
                })
                .catch(err => {
                    showToastError('Failed to load order details. Please try again later.')
                    console.error(err);
                });
        });
    });


    document.querySelector('#PendingOrderDetailsModal .close').addEventListener('click', function () {
        document.getElementById('PendingOrderDetailsModal').style.display = 'none';
    });

    document.getElementById('PendingOrderDetailsModal').addEventListener('click', function (e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });
});


function updatePendingBadge() {
    fetch('/pending-orders/badge/count')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const navItem = document.querySelector('.nav-item');
            const badge = document.querySelector('.pending-badge');

            if (data.success) {

                if (data.count > 0) {
                    navItem.classList.add('has-pending');

                } else {
                    navItem.classList.remove('has-pending');

                }
            }
        })
        .catch(error => {
            console.error('Error checking pending orders:', error);
            // Optional: Show error state to user
            document.querySelector('.pending-badge').style.backgroundColor = '#999';
        });
}


document.addEventListener('DOMContentLoaded', function() {
    updatePendingBadge();


    setInterval(updatePendingBadge, 1000);
});