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
                    alert("Status updated successfully.");
                } else {
                    alert("Failed to update.");
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
