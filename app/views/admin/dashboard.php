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
    <link rel="icon" href="assets/images/Testament_Logo.png" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="assets/js/sidebar.js" defer></script>
    <script type="text/javascript" src="assets/js/prodCounter.js" defer></script>
    <script type="text/javascript" src="assets/js/charts/weekly.js" defer></script>
    <script type="text/javascript" src="assets/js/charts/daily.js" defer></script>
    <script type="text/javascript" src="assets/js/orders/pendingOrdersBadge.js" defer></script>
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

<main class="dashboard">
    <div class="card totalItems" onclick="window.location.href='/inventory'">
        <p>Total Products</p>
        <p id="productCounts">Loading...</p>
    </div>
    <div class="card registerdUser" onclick="window.location.href='/users'">
        <p>Registered Users</p>
        <p id="rUsersCounts">Loading...</p>
    </div>
    <div class="card orders" onclick="window.location.href='/ordered-list'">
        <p>Total Orders</p>
        <p id="orderCounts">Loading...</p>
    </div>

    <!--WEEKLY SALES-->
    <div class="weeklyCard weeklyStats">
        <h2 class="weekly-line-title">Weekly Sales</h2>
        <canvas id="salesLineChart" height="100"></canvas>
    </div>

    <!--DAILY SALES-->
    <div class="daily-chart-card ">
        <div class="chart-titles">Daily Sales</div>
        <canvas id="salesDonutChart" height="100"></canvas>
    </div>

    </div>

</main>

</body>
</html>