<?php
// test.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Form submitted!<br>";
    print_r($_POST);
}
