function openModal() {
    document.getElementById('addProductModal').style.display = 'flex';
    document.getElementById('productForm').reset();
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('responseMessage').textContent = '';
}


function closeModal() {
    document.getElementById('addProductModal').style.display = 'none';
    document.getElementById('responseMessage').textContent = '';
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.className = `toast show ${type}`;
    toast.textContent = message;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}



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


document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
        const prod_id = button.getAttribute('data-id');
        const baseUrl = window.location.origin;

        fetch(`${baseUrl}/admin/inventory/show?id=${prod_id}`)
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const p = data.data;
                    document.getElementById('prod_id').value = p.prod_id;
                    document.getElementById('productName').value = p.prod_name;
                    document.getElementById('productDescription').value = p.prod_desc;
                    document.getElementById('quantity').value = p.prod_quan;
                    document.getElementById('price').value = p.prod_price;

                    document.getElementById('editProductModal').style.display = 'block';
                    console.log(p);
                } else {
                    alert(data.message);
                }
            })
            .catch(() => alert('Error loading product data.'));
    });
});

function closeEditModal() {
    document.getElementById('editProductModal').style.display = 'none';
    document.getElementById('responseMessage').textContent = '';
}