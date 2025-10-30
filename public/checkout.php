<?php
session_start();
include("../inc/header.php");

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    echo "<h2 style='text-align:center;'>Checkout Successful!</h2>";
    echo "<p style='text-align:center;'>Thank you for your purchase!</p>";
    $_SESSION['cart'] = [];
} else {
    echo "<p style='text-align:center;'>No items to checkout!</p>";
}

include("../inc/footer.php");
?>
