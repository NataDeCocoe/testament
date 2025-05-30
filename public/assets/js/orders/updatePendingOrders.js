document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            const orderId = this.dataset.id;
            updateOrderStatus(orderId, 'approved');
        });
    });

    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            const orderId = this.dataset.id;
            updateOrderStatus(orderId, 'rejected');
        });
    });

    function updateOrderStatus(orderId, status) {
        fetch('/orders/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ order_id: orderId, status: status })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.status}`);
                }
                // Try to parse JSON directly, fallback if fails
                return response.json().catch(() => response.text());
            })
            .then(data => {
                if (typeof data === 'string') {

                    console.error("Non-JSON response:", data);
                    showToast("Unexpected server response. Please try again.");
                    return;
                }

                if (data.success) {
                    showToast(`Order ${status} successfully!`);
                    setTimeout(() => location.reload(), 2000);
                } else {

                    showToastError(data.message || "Failed to approve order. Please check stock and try again.");
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                showToast("Request failed. Please check your connection and try again.");
            });
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