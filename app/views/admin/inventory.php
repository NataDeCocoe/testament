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
    <script type="text/javascript" src="assets/js/admin.js" defer></script>
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
                <input name="prod_img" type="file" id="productImage" accept="image/*" onchange="previewImage(event)" required>
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
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>

    </div>

</div>



</body>
</html>
