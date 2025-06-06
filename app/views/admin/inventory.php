<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TESTAMENT</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="assets/js/sidebar.js" defer></script>
    <script type="text/javascript" src="assets/js/orders/pendingOrdersBadge.js" defer></script>
    <script type="text/javascript" src="assets/js/admin/crudProducts.js" defer></script>
    <link rel="icon" href="/public/assets/images/Testament_Logo.png" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script>
        try {
            if (localStorage.getItem("sidebar-collapsed") === "true") {
                document.write('<body class="sb-collapse">');
            } else {
                document.write('<body>');
            }
        } catch (e) {
            document.write('<body>');
        }
    </script>
</head>
<body>

<?php include __DIR__ . '/../layouts/adminsideNav.php'; ?>

<main class="ordersMain">
    <div class="headerLabel">
        <h2>Product List</h2>
    </div>

    <div id="product_list">
        <?php include __DIR__ . '/../layouts/productlist.php'; ?>
    </div>
</main>

<button onclick="openModal()" class="ordersMain-btns adminAddProdBTN">Add Product</button>
<div id="toast" class="toast"></div>
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <h2>Add New Product</h2>
        <form id="productForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input name="prod_img" type="file" id="productImage" accept="image/*" required>
            </div>

            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="productName">Product Name</label>
                    <input name="prod_name" type="text" id="productName" required>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="category">Category</label>
                    <select class="selCate" id="category" name="category_id" required>
                        <option value="" disabled selected>Select Category</option>
                        <!-- Options will be dynamically inserted here -->
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="productDescription">Product Description</label>
                <textarea name="prod_desc" id="productDescription" required></textarea>
            </div>

            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="quantity">Quantity</label>
                    <input name="prod_quan" type="number" id="quantity" min="0" required>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="price">Price</label>
                    <input name="prod_price" type="number" id="price" min="0" step="0.01" required>
                </div>
            </div>

            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="weight">Weight (kg)</label>
                    <input name="weight" type="number" id="weight" step="0.01" min="0" required>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="length">Length (cm)</label>
                    <input name="length_cm" type="number" id="length" step="0.1" min="0" required>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="width">Width (cm)</label>
                    <input name="width_cm" type="number" id="width" step="0.1" min="0" required>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="height">Height (cm)</label>
                    <input name="height_cm" type="number" id="height" step="0.1" min="0" required>
                </div>
            </div>

            <div class="modal-footer" id="addBtn">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</div>


<div id="editProductModal" class="modal">
    <div class="modal-content">
        <h2>Edit Product</h2>
        <form id="editProductForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="prod_id" id="prod_id">
            <div class="form-group">
<!--                <label for="productImage">Product Image</label>-->
                <input name="prod_img" type="hidden" id="productImage" accept="image/*" onchange="previewImage(event)" required>
            </div>

            <div class="form-group">
                <label for="productName">Product Name</label>
                <input name="prod_name" type="text" id="productName" required>
            </div>

            <div class="form-group">
                <label for="productDescription">Product Description</label>
                <textarea name="prod_desc" id="productDescription" required></textarea>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input name="prod_quan" type="number" id="quantity" min="0" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input name="prod_price" type="number" id="price" min="0" step="0.01" required>
            </div>
            <div class="modal-footer" id="addBtn">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Saved Changes</button>
            </div>
        </form>

    </div>
</div>



<div id="deleteConfirmModal" class="modal">
    <div class="modal-content">

        <p id="deleteProductDetails"></p>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
    </div>
</div>
</body>
</html>
