// Open modal function
function openModal() {
    document.getElementById('addProductModal').style.display = 'flex';
    document.getElementById('productForm').reset();  // Reset the form
    document.getElementById('imagePreview').style.display = 'none'; // Hide image preview on modal open
    document.getElementById('responseMessage').textContent = ''; // Clear previous response message
}

// Close modal function
function closeModal() {
    document.getElementById('addProductModal').style.display = 'none';
    document.getElementById('responseMessage').textContent = ''; // Clear response message on close
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast'; // Reset
    }, 3000);
}


// Form submission with fetch API
document.getElementById('productForm').addEventListener('submit', function (e) {
    e.preventDefault();
    console.log("Form submitted!");

    const formData = new FormData(this);
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    fetch('/admin/inventory', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            showToast(data.message, data.status);

            if (data.status === 'success') {
                setTimeout(() => {
                    closeModal();
                }, 1000);
            }
        })
        .catch(error => {
            showToast('Error: ' + error.message, 'error');
        });
});


function editModal() {
    document.getElementById('editProductModal').style.display = 'flex';
    document.getElementById('editProductForm').reset();  // Reset the form
    document.getElementById('imagePreview').style.display = 'none'; // Hide image preview on modal open
    document.getElementById('responseMessage').textContent = ''; // Clear previous response message
}
document.addEventListener('DOMContentLoaded', function () {
    // Attach click event to all edit buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const prodId = this.getAttribute('data-id');
            loadProductIntoModal(prodId);
        });
    });
});

function loadProductIntoModal(prod_id) {
    fetch(`/admin/inventory/show?id=${prod_id}`)
        .then(response => response.json())
        .then(response => {
            if (!response.status) {
                alert(response.message || 'Failed to load product.');
                return;
            }

            const data = response.data;

            // Fill form fields
            document.getElementById('prod_id').value = data.prod_id;
            document.getElementById('prod_name').value = data.productName;
            document.getElementById('prod_desc').value = data.productDesc;
            document.getElementById('prod_quan').value = data.quantity;
            document.getElementById('prod_price').value = data.price;

            // Show current image
            const img = document.getElementById('currentProductImage');
            if (data.prod_img) {
                img.src = '/uploads/' + data.prod_img;
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }

            // Open modal (replace this with your actual modal trigger)
            editModal();
        })
        .catch(err => {
            console.error(err);
            alert('Error loading product data.');
        });
}