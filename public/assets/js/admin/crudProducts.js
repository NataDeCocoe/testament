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


//ADD PRODUCT FORM SUBMIT EVENT HANDLER
document.getElementById('productForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = this;
    const fileInput = form.querySelector('input[name="prod_img"]');


    if (fileInput.files.length === 0) {
        showToast('Please select an image file', 'error');
        return;
    }

    console.log('Uploading file:', fileInput.files[0].name, fileInput.files[0].size);

    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;

    try {
        submitButton.disabled = true;
        submitButton.innerHTML = 'Uploading...';

        const formData = new FormData(form);
        const response = await fetch('/admin/inventory', {
            method: 'POST',
            body: formData
        });

        if (response.status === 413) {
            throw new Error('File too large (max 5MB)');
        }

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Upload failed');
        }

        showToast(data.message, data.status);

        if (data.status === 'success') {
            setTimeout(() => location.reload(), 1500);
        }

    } catch (error) {
        console.error('Upload error:', error);
        showToast(error.message, 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
});

//GET THE PRODUCT ID FROM THE BUTTON AND FETCH THE PRODUCT DATA
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

//EDIT PRODUCT FORM SUBMIT EVENT HANDLER
document.getElementById('editProductForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('/admin/inventory/update', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {

            try {
                const data = JSON.parse(text);

                if (data.status) {
                    showToast(data.message, data.status);
                        setTimeout(() => {
                            location.reload();
                            closeEditModal();
                        }, 1000);
                } else {
                    showToast(data.message, data.status);
                }
            } catch (e) {
                console.error('Invalid JSON:', text);
                alert('Server returned invalid response. Check console.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Server error. Please try again later.');
        });
});

//DELETE PRODUCT
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const prodId = this.dataset.id;

            fetch(`/admin/inventory/show?id=${prodId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        const product = data.data;
                        document.getElementById('deleteProductDetails').innerHTML = `
                            Are you sure you want to delete <strong>${product.prod_name}</strong>?
                        `;
                        document.getElementById('confirmDeleteBtn').setAttribute('data-id', product.prod_id);
                        openDeleteModal();
                    } else {
                        alert("Product not found.");
                    }
                })
                .catch(() => alert("Error loading product data."));
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        const prodId = this.getAttribute('data-id');

        fetch('/admin/inventory/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `prod_id=${encodeURIComponent(prodId)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showToast(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000)
                } else {
                    showToast("Product currently in some orders. Please remove the product from orders before deleting it.", 'error');
                }
            })
            .catch(() => alert("Server error."));
    });
});

function openDeleteModal() {
    document.getElementById('deleteConfirmModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteConfirmModal').style.display = 'none';
}