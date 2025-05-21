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
    <link rel="icon" href="assets/images/Testament_Logo.png" sizes="any">
    <link rel="stylesheet" href="assets/css/homePages.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="/assets/js/sidebar.js" defer></script>
    <script type="text/javascript" src="/assets/js/homepage.js" defer></script>
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
    <h1 class="headLabels">Personal Information</h1>
    <div class="profileItems">
        <span class="material-symbols-rounded editProf">edit</span>
        <div class="profilePicCon" onclick="">
            <img id="profilePic" src="/assets/images/newBook.jpg" alt="Profile Picture">
        </div>
        <div>
            <h1 id="firstname"><?= htmlspecialchars($user['firstname']) ?></h1>
            <h1 id="lastname"><?= htmlspecialchars($user['lastname']) ?></h1>
            <p id="conNum"><?= htmlspecialchars($user['phone_num']) ?></p>
            <p id="emailAd"><?= htmlspecialchars($user['email']) ?></p>
            <p id="address"><small><?= htmlspecialchars($user['home_address']) ?></small></p>
        </div>

    </div>
    <div class="orderH"><h1>Order History</h1></div>

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

    <div class="profileItemHistory">
        <img class="img" src="/assets/images/newBook.jpg" width="90" height="100" alt="">
        <div class="notifContent">
            <h4 class="notifHeader">Noah's Ark</h4>
            <p class="historyText">Total Item: <span>5pcs</span></p>
            <p class="historyText">Price: <span>₱90</span></p>
        </div>
        <div class="notifTimestamp">
            <p class="historyStatus"><small>Completed</small></p>
        </div>
    </div>

    <div class="profileItemHistory">
        <img class="img" src="/assets/images/newBook2.jpg" width="90" height="100" alt="">
        <div class="notifContent">
            <h4 class="notifHeader">Time Travel</h4>
            <p class="historyText">Total Item: <span>10pcs</span></p>
            <p class="historyText">Price: <span>₱100</span></p>
        </div>
        <div class="notifTimestamp">
            <p class="historyStatus"><small>Completed</small></p>
        </div>
    </div>

</main>
<footer>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
    <div class="menuButton">
        <button class="bDisplay"><span class="material-symbols-rounded">menu</span></button>
    </div>
</footer>
</body>
</html>