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
    <link rel="icon" href="/public/assets/images/Testament_Logo.png" sizes="any">
    <link rel="stylesheet" href="assets/css/homePages.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="/assets/js/homepage.js" defer></script>
    <script type="text/javascript" src="/assets/js/sidebar.js" defer></script>
    <script type="text/javascript" src="/assets/js/dashboardProducts.js" defer></script>
    <script type="text/javascript" src="/assets/js/cart.js" defer></script>
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



<main>
<h1>CHECKOUT</h1>
</main>
<footer>
    <div class="menuButton">
        <button class="bDisplay"><span class="material-symbols-rounded">menu</span></button>
    </div>
    <div id="toast" class="toast"></div>
</footer>
</body>
</html>