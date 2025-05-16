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