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
        <div class="profilePicCon">
            <img id="profilePic" src="/assets/images/newBook.jpg" alt="Profile Picture">
        </div>
        <div>
            <h1>Juan Dela Cruz</h1>
            <p id="conNum">0908-818-4444</p>
            <p id="emailAd">email@gmail.com</p>
            <p id="address"><small>Prk. 1, Apokon Tagum City, Davao del Norte</small></p>
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
    <div class="menuButton">
        <button class="bDisplay"><span class="material-symbols-rounded">menu</span></button>
    </div>
</footer>
</body>
</html>