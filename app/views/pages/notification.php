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
    <script type="text/javascript" src="/assets/js/notification/getUnreadNotification.js" defer></script>
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
    <h1 class="headLabels">Notifications</h1>
    <?php include __DIR__ . '/../layouts/notificationCard.php'; ?>
</main>

<footer class="responsive-footer">
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
    <div id="toast" class="toast"></div>
</footer>
</body>
</html>