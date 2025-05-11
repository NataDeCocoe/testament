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
        <button class="ordersMain-btns adminAddProdBTN">Add Product</button>
    </div>

    <div id="product_list">
        <?php include __DIR__ . '/../layouts/productlist.php'; ?>
    </div>
</main>
</body>
</html>
