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
    <link rel="icon" href="/resources/images/Testament_Logo.png" sizes="any">
    <link rel="stylesheet" href="assets/css/homePages.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="/resources/js/homePage.js" defer></script>
    <script type="text/javascript" src="/assets/js/sidebar.js" defer></script>

</head>
<body>

<?php include __DIR__ . '/../layouts/sidenav.php'; ?>

<main class="main">
    <h1 class="headLabels">Saved</h1>
    <div class="prodSavedBackCon">
        <div class="innerProdCon">
            <div class="savedBookItems">
                <button class="material-symbols-rounded bDisplay alignBTN">bookmark</button>
            </div>
            <span>The Eve</span>
        </div>
        <div class="innerProdCon">
            <div class="savedBookItems">
                <button class="material-symbols-rounded bDisplay">bookmark</button>
            </div>
            <span>The World of War II</span>
        </div>



    </div>

    <?php
    $productImage = '/resources/images/newBook2.jpg';
    $targetClass = 'savedBookItems';
    ?>


    <script type="module">
        import ImageInserter from '/resources/js/prodImage.js';

        const imageInserter = new ImageInserter("<?= $productImage ?>", "<?= $targetClass ?>");
        imageInserter.insert();
    </script>

</main>
<footer>
    <div class="menuButton">
        <button class="bDisplay"><span class="material-symbols-rounded">menu</span></button>
    </div>
</footer>
</body>
</html>