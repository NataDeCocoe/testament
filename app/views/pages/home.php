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
    <link rel="stylesheet" href="assets/css/footer.css">

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

<?php include __DIR__ . '/../layouts/sidenav.php'; ?>

<main class="main">

    <div class="carousel" id="caro">
        <div  class="link">
            <a href="/categories">Explore Now</a>
        </div>
    </div>

    <h1>New Arrivals</h1>
    <?php include __DIR__ . '/../layouts/productCard.php'; ?>


    <div class="invBlock"></div>


    <h1 id="mostPopular">Most Popular</h1>
        <?php include __DIR__ . '/../layouts/allProductCard.php'; ?>

    <div class="container">
        <div class="hero">
            <h1>Season Sale</h1>
            <p>Buy one get one free</p>
            <a class="pLink" href="/categories">View Categories</a>
        </div>
        <div class="collections">
            <div class="card"><img src="assets/images/newBook.jpg" alt="Kid's Collection"/>
                <p>Kid's Collection</p>
            </div>
            <div class="card"><img src="https://images.unsplash.com/photo-1606112219348-204d7d8b94ee" alt="Adult's Collection"/>
                <p>Adult's Collection</p>
            </div>
            <div class="card"><img src="https://images.unsplash.com/photo-1512820790803-83ca734da794" alt="Reading's Collection"/>
                <p>Reading's Collection</p>
            </div>
        </div>
    </div>

</main>
<footer class="responsive-footer">
    <?php include __DIR__ . '/../layouts/footer.php'; ?>

</footer>
</body>
</html>