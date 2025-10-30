<?php
// This file handles all cart modifications (add, update, remove)
session_start();

// Ensure the cart exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if an action is set
if (isset($_POST['action']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];
    $product_id = $_POST['product_id'] ?? 0;
    
    // --- ADD TO CART ---
    if ($action == 'add' && $product_id > 0) {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if ($quantity <= 0) $quantity = 1;
        
        // Check if product is already in cart
        if (isset($_SESSION['cart'][$product_id])) {
            // Update quantity
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            // Add new item
            $_SESSION['cart'][$product_id] = array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity
            );
        }
        
        // Redirect back to the product page or cart
        header("Location: cart.php");
        exit;
    }
    
    // --- UPDATE QUANTITY ---
    if ($action == 'update' && $product_id > 0) {
        $quantity = (int)($_POST['quantity'] ?? 0);
        
        if ($quantity > 0) {
            // Update quantity
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        } else {
            // If quantity is 0 or less, remove the item
            unset($_SESSION['cart'][$product_id]);
        }
        
        // Redirect back to the cart
        header("Location: cart.php");
        exit;
    }
    
    // --- REMOVE FROM CART ---
    if ($action == 'remove' && $product_id > 0) {
        // Remove the item
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        
        // Redirect back to the cart
        header("Location: cart.php");
        exit;
    }
    
    // --- EMPTY CART ---
    if ($action == 'empty') {
        $_SESSION['cart'] = array();
        
        // Redirect back to the cart
        header("Location: cart.php");
        exit;
    }
}

// If no action was recognized, redirect to home
header("Location: index.php");
exit;
?>
