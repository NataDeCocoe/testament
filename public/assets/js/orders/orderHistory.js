console.log("Order history script loaded");
document.addEventListener("DOMContentLoaded", function () {
    fetch('/profile/orders/data')
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch orders.");
            }
            return response.json();
        })
        .then(data => {
            console.log("Received data:", data);
            const container = document.getElementById('orderHistoryContainer');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = "<p>No orders found.</p>";
                return;
            }

            data.forEach(order => {

                let statusClass = '';
                switch(order.order_status.toLowerCase()) {
                    case 'pending':
                    case 'processing':
                        statusClass = 'status-orange';
                        break;
                    case 'shipped':
                    case 'shipping':
                        statusClass = 'status-yellow';
                        break;
                    case 'completed':
                        statusClass = 'status-green';
                        break;
                    case 'canceled':
                    case 'rejected':
                        statusClass = 'status-red';
                        break;
                    default:
                        statusClass = 'status-default';
                }

                const html = `
                <div class="profileItemHistory">
                    <img class="img" src="/${order.prod_img.replace(/\\/g, '/')}" width="50" height="60" alt="">
                    <div class="notifContent">
                        <h4 class="notifHeader">${order.prod_name}</h4>
                        <p class="historyText">Total Item: <span>${order.quantity}pcs</span></p>
                        <p class="historyText">Price: <span>₱${parseFloat(order.price).toFixed(2)}</span></p>
                    </div>
                    <div class="notifTimestamp">
                        <p class="historyStatus ${statusClass}"><small>${order.order_status.charAt(0).toUpperCase() + order.order_status.slice(1)}</small></p>
                    </div>
                </div>`;
                container.insertAdjacentHTML('beforeend', html);
            });
        })
        .catch(error => {
            console.error("Error fetching orders:", error);
            document.getElementById('orderHistoryContainer').innerHTML = `<p>Error: ${error.message}</p>`;
        });
});