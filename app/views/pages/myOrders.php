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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/resources/images/Testament_Logo.png" sizes="any">
    <link rel="stylesheet" href="assets/css/homePages.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="/resources/js/homePage.js" defer></script>
    <script type="text/javascript" src="/assets/js/sidebar.js" defer></script>
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

<?php include __DIR__ . '/../layouts/sidenav.php'; ?>

<main class="main">
    <h1 class="headLabels">My Orders</h1>
    <div class="profileItemHistory">
        <img class="img" src="/assets/images/newBook2.jpg" width="90" height="100" alt="">
        <div class="notifContent">
            <h4 class="notifHeader">The Eve</h4>
            <p class="historyText">Total Item: <span>1pcs</span></p>
            <p class="historyText">Price: <span>₱120</span></p>
        </div>
        <div class="notifTimestamp">
            <p class="historyStatus"><small>Completed</small></p>
        </div>
    </div>


</main>
<footer class="responsive-footer">
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
    <div class="menuButton">
        <button class="bDisplay"><span class="material-symbols-rounded">menu</span></button>
    </div>
</footer>
</body>
</html>