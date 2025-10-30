<?php
// Start session on every page
session_start();

// Include the database connection
include_once 'db_connect.php';

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Calculate total items in cart for the nav icon
$cart_item_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_item_count += $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The title will be set on each page individually -->
    <link rel="stylesheet" href="style.css">
    <!-- Simple Cart Icon (using text) -->
    <style>
        .cart-icon {
            position: relative;
            display: inline-block;
            margin-left: 20px;
            font-size: 1.5rem;
            color: #555;
            text-decoration: none;
        }
        .cart-count {
            position: absolute;
            top: -10px;
            right: -12px;
            background-color: #e63946;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <a href="index.php" class="logo">GadgetHut</a>
            <div class="nav-links">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <span class="welcome-msg">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                    <a href="register.php" class="btn btn-secondary">Register</a>
                <?php endif; ?>
                
                <a href="cart.php" class="cart-icon" title="View Cart">
                    🛒
                    <?php if ($cart_item_count > 0): ?>
                        <span class="cart-count"><?php echo $cart_item_count; ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main content starts here, and will be closed in footer.php -->
    <main class="container">
