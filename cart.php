<?php
include 'header.php'; // Includes session_start()

$cart = $_SESSION['cart'];
$total_price = 0;
?>

<!-- Set the page title -->
<script>document.title = 'Your Shopping Cart - GadgetHut';</script>

<h1>Your Shopping Cart</h1>

<?php if (empty($cart)): ?>
    <p class="subtitle">Your cart is empty. <a href="index.php">Continue shopping!</a></p>
<?php else: ?>
    <div class="cart-layout">
        <div class="cart-items">
            <?php foreach ($cart as $id => $item): 
                $item_total = $item['price'] * $item['quantity'];
                $total_price += $item_total;
            ?>
                <div class="cart-item">
                    <div class="cart-item-details">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <span class="cart-item-price">$<?php echo number_format($item['price'], 2); ?></span>
                        
                        <!-- Update Quantity Form -->
                        <form action="cart-logic.php" method="post" class="cart-update-form">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <input type="hidden" name="action" value="update">
                            <label for="quantity-<?php echo $id; ?>">Qty:</label>
                            <input type="number" id="quantity-<?php echo $id; ?>" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" max="10">
                            <button type="submit" class="btn-link">Update</button>
                        </form>
                    </div>
                    
                    <div class="cart-item-actions">
                        <span class="cart-item-total">$<?php echo number_format($item_total, 2); ?></span>
                        <!-- Remove Item Form -->
                        <form action="cart-logic.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <button type="submit" name="action" value="remove" class="btn-link btn-danger">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <h3>Order Summary</h3>
            <div class="summary-row">
                <span>Subtotal</span>
                <span>$<?php echo number_format($total_price, 2); ?></span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span>FREE</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>$<?php echo number_format($total_price, 2); ?></span>
            </div>
            
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="checkout.php" class="btn btn-primary btn-large btn-full">Proceed to Checkout</a>
            <?php else: ?>
                <p>Please <a href="login.php?redirect=cart">login</a> to proceed to checkout.</p>
            <?php endif; ?>
            
            <!-- Empty Cart Form -->
            <form action="cart-logic.php" method="post" style="text-align: center; margin-top: 20px;">
                <button type="submit" name="action" value="empty" class="btn-link btn-danger">Empty Cart</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php
include 'footer.php';
?>
