<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TESTAMENT</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="assets/js/sidebar.js" defer></script>
    <link rel="icon" href="/public/assets/images/Testament_Logo.png" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

<main class="ordersMain">
    <div class="headerLabel">
        <h2>Orders List</h2>
    </div>


    <div class="orders-container">
        <div class="orders-header">
            <div class="col">No.</div>
            <div class="col">Customer</div>
            <div class="col">Product code</div>
            <div class="col">Date</div>
            <div class="col">Amount</div>
            <div class="col">Method of payment</div>
            <div class="col">Action</div>

        </div>

        <div class="orders-row">
            <div class="col">1</div>
            <div class="col">Nathaniel Bartolome</div>
            <div class="col">54823</div>
            <div class="col">April 19, 2025</div>
            <div class="col"><span>₱</span> 800</div>
            <div class="col">Gcash</div>
            <div class="col actions">
                <button class="edit-btn">
                    <i class="fa-solid fa-check"></i> Approved
                </button>
                <button class="delete-btn">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </div>
        </div>

        <div class="orders-row">
            <div class="col">2</div>
            <div class="col">Jan Michael Pasaylo</div>
            <div class="col">24012</div>
            <div class="col">April 2, 2025</div>
            <div class="col"><span>₱</span> 1540</div>
            <div class="col">Gcash</div>
            <div class="col actions">
                <button class="edit-btn">
                    <i class="fa-solid fa-check"></i> Approved
                </button>
                <button class="delete-btn">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </div>
        </div>

        <div class="orders-row">
            <div class="col">3</div>
            <div class="col">Andrea Jandog</div>
            <div class="col">64821</div>
            <div class="col">March 12, 2025</div>
            <div class="col"><span>₱</span> 1200</div>
            <div class="col">Gcash</div>
            <div class="col actions">
                <button class="edit-btn">
                    <i class="fa-solid fa-check"></i> Approved
                </button>
                <button class="delete-btn" >
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</main>
</body>
</html>