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
    <link rel="icon" href="/assets/images/Testament_Logo.png" sizes="any">
    <link rel="stylesheet" href="assets/css/myCart.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="text/javascript" src="/assets/js/homepage.js" defer></script>
    <script type="text/javascript" src="/assets/js/sidebar.js" defer></script>
    <script type="text/javascript" src="/assets/js/dashboardProducts.js" defer></script>
    <script type="text/javascript" src="/assets/js/cartPageDisplay.js" defer></script>
</head>
<body>



<main>
    <div class="container">
        <h1>My Shopping Cart</h1>

        <div id="cartItemsContainer"></div>

<!--        <div class="divider"></div>-->

        <div class="summary">
            <div class="summary-row">
                <span>Subtotal (<span id="itemCount">0</span> items):</span>
                <span id="subtotal">₱0.00</span>
            </div>
            <div class="summary-row summary-total">
                <span>Total:</span>
                <span id="total">₱0.00</span>
            </div>
        </div>

        <button id="pCheckout" class="checkout-btn" onclick="window.location.href='/checkout'">Proceed to Checkout</button>

        <div style="text-align: center;">
            <a href="/home" class="back-link">Back to shop</a>
        </div>
    </div>
</main>
<footer class="responsive-footer">
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
    <div id="toast" class="toast"></div>
</footer>
</body>
</html>