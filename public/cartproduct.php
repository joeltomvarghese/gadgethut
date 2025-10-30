<?php
session_start();
include("../inc/db.php");
include("../inc/header.php");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $_SESSION['cart'][] = $product_id;
    echo "<p style='color:green; text-align:center;'>Product added to cart!</p>";
}

if (count($_SESSION['cart']) > 0) {
    $ids = implode(",", $_SESSION['cart']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");

    echo "<h2 style='text-align:center;'>Your Cart</h2>";
    echo "<div style='display:flex;flex-wrap:wrap;gap:20px;justify-content:center;'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "
        <div style='border:1px solid #ccc; padding:10px; width:200px; text-align:center;'>
            <h3>{$row['name']}</h3>
            <p>₹{$row['price']}</p>
        </div>";
    }
    echo "</div>";
    echo "<div style='text-align:center; margin-top:20px;'><a href='checkout.php'>Proceed to Checkout</a></div>";
} else {
    echo "<p style='text-align:center;'>Your cart is empty!</p>";
}

include("../inc/footer.php");
?>
