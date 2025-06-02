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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/resources/images/Testament_Logo.png" sizes="any">
    <link rel="stylesheet" href="assets/css/homePages.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="/resources/js/homePage.js" defer></script>
    <script type="text/javascript" src="/assets/js/sidebar.js" defer></script>
    <script type="text/javascript" src="/assets/js/categoriesProd.js" defer></script>
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
    <h1 class="headLabels">Categories</h1>

    <div class="cateCard">
        <div>
            <div class="cateMenu">
                <img src="/assets/images/allB.svg" width="50rem" height="60rem" alt="all">
            </div>
            <span>All</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/eBook.svg" width="50rem" height="60rem" alt="eBooks">
            </div>
            <span>eBooks</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/educationB.svg" width="50rem" height="60rem" alt="Educational">
            </div>
            <span>Educational</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/romanceB.svg" width="50rem" height="60rem" alt="Romance">
            </div>
            <span>Romance</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/cookB.svg" width="50rem" height="60rem" alt="Cooking Book">
            </div>
            <span>Cookbook</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/languageB.svg" width="50rem" height="60rem" alt="Language">
            </div>
            <span>Language</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/hororB.svg" width="50rem" height="60rem" alt="Horror">
            </div>
            <span>Horror</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/musicB.svg" width="50rem" height="60rem" alt="Music">
            </div>
            <span>Music</span>
        </div>

        <div>
            <div class="cateMenu">
                <img src="/assets/images/scienceB.svg" width="50rem" height="60rem" alt="Science">
            </div>
            <span>Science</span>
        </div>

    </div>
    <h1 id="allProd">All Products</h1>
    <?php include __DIR__ . '/../layouts/categoriesAllProd.php'; ?>

</main>
<footer class="responsive-footer">
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
    <div class="menuButton">
        <button class="bDisplay"><span class="material-symbols-rounded">menu</span></button>
    </div>
    <div id="toast" class="toast"></div>
</footer>
</body>
</html>