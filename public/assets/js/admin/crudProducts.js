let addProductModal;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get modal element
    addProductModal = document.getElementById('addProductModal');

    // Verify modal exists
    if (!addProductModal) {
        console.error('Modal element not found! Check your HTML for id="addProductModal"');
        return;
    }

    // Set up event listeners for all "Add Product" buttons
    document.querySelectorAll('[onclick="openModal()"]').forEach(button => {
        button.addEventListener('click', openModal);
    });
});

// Improved openModal function
async function openModal() {
    try {
        // Verify modal exists
        if (!addProductModal) {
            throw new Error('Modal not initialized');
        }

        // Show modal
        addProductModal.style.display = 'flex';

        // Reset form
        const form = document.getElementById('productForm');
        if (form) form.reset();

        // Hide image preview
        const imagePreview = document.getElementById('imagePreview');
        if (imagePreview) imagePreview.style.display = 'none';

        // Clear messages
        const responseMessage = document.getElementById('responseMessage');
        if (responseMessage) responseMessage.textContent = '';

        // Load categories
        await fetchCategories();
    } catch (error) {
        console.error('Error opening modal:', error);
        alert('Failed to open the product form. Please refresh the page.');
    }
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
    const formData = new FormData(form);
    console.log("Sending category_id:", formData.get("category_id"));  // should NOT be null!


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

async function fetchCategories() {
    const selectElement = document.getElementById('category');
    if (!selectElement) {
        console.error('Category dropdown not found');
        return;
    }

    try {
        // Show loading state
        selectElement.innerHTML = '<option value="" disabled selected>Loading categories...</option>';


        const response = await fetch('/get-categories');

        if (!response.ok) {
            throw new Error(`Server returned ${response.status} ${response.statusText}`);
        }

        const categories = await response.json();

        if (!Array.isArray(categories)) {
            throw new Error('Invalid categories data format');
        }

        populateCategoryDropdown(categories);
    } catch (error) {
        console.error('Failed to load categories:', error);
        selectElement.innerHTML = '<option value="" disabled selected>Error loading categories</option>';
    }
}

// Populate dropdown with categories
function populateCategoryDropdown(categories) {
    const selectElement = document.getElementById('category');
    if (!selectElement) return;

    // Clear existing options
    selectElement.innerHTML = '';

    // Add default option
    const defaultOption = new Option('Select Category', '', true, true);
    defaultOption.disabled = true;
    selectElement.add(defaultOption);

    // Add category options using correct key
    categories.forEach((category) => {
        const option = new Option(category.category_name, category.category_id); // ✅ key fix
        selectElement.add(option);
    });
}


