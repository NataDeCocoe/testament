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
            body: JSON.stringify({
                order_id: orderId,
                status: status
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast("Order status updated to " + status);
                    setTimeout(() => {
                        location.reload();
                    } , 4000)
                } else {
                    alert("Failed to update status.");
                }
            });
    }
});

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 10000);
}