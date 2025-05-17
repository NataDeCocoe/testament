//PRODUCTS COUNT
function loadProductCount() {
    fetch('/admin/inventory/count')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                document.getElementById('productCounts').textContent = data.count;
            } else {
                console.error('Failed to fetch count:', data.message);
            }
        })
        .catch(err => console.error('Fetch error:', err));
}


window.addEventListener('DOMContentLoaded', loadProductCount);


//USERS COUNT
document.addEventListener("DOMContentLoaded", function () {
    fetch("/admin/users/count")
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                document.getElementById("rUsersCounts").textContent = data.count;
            } else {
                console.error("Error fetching user count:", data.message);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
});
