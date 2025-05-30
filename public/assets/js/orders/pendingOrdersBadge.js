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

            document.querySelector('.pending-badge').style.backgroundColor = '#999';
        });
}


document.addEventListener('DOMContentLoaded', function() {
    updatePendingBadge();


    setInterval(updatePendingBadge, 10000);
});
