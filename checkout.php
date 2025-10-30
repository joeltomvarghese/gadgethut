<?php
include 'header.php'; // Includes session_start()

// Security: Redirect to login if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php?redirect=checkout");
    exit;
}

// Security: Redirect to cart if cart is empty
if (empty($_SESSION['cart'])) {
    header("location: cart.php");
    exit;
}

$cart = $_SESSION['cart'];
$total_price = 0;
foreach ($cart as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// --- SIMULATE ORDER PLACEMENT ---
// This is where you would normally process payment (e.g., Stripe, PayPal)
// For this project, we will just show a success message and clear the cart.
$order_placed = isset($_GET['success']);

if ($order_placed) {
    // Clear the cart
    $_SESSION['cart'] = array();
}

?>

<!-- Set the page title -->
<script>document.title = 'Checkout - GadgetHut';</script>

<h1>Checkout</h1>

<?php if ($order_placed): ?>
    <!-- --- Order Success Message --- -->
    <div class="checkout-success">
        <h2>Thank You For Your Order!</h2>
        <p>Your order (Ref: #<?php echo rand(10000, 99999); ?>) has been placed successfully.</p>
        <p>A confirmation email has been sent to <?php echo htmlspecialchars($_SESSION['email']); ?>.</p>
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
    </div>

<?php else: ?>
    <!-- --- Checkout Form & Summary --- -->
    <p class="subtitle">Please confirm your order details.</p>
    
    <div class="checkout-layout">
        <div class="checkout-form">
            <h3>Shipping Information</h3>
            <p><strong>User:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            
            <form>
                <div class="form-group">
                    <label for="address">Shipping Address</label>
                    <input type="text" id="address" name="address" placeholder="123 Main Street" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="Anytown" required>
                </div>
                <div class="form-group">
                    <label for="zip">Zip Code</label>
                    <input type="text" id="zip" name="zip" placeholder="12345" required>
                </div>
            </form>
            
            <h3>Payment Information</h3>
            <p>This is a demo. No payment will be processed.</p>
            <form>
                 <div class="form-group">
                    <label for="card">Card Number</label>
                    <input type="text" id="card" name="card" placeholder="**** **** **** 1234">
                </div>
            </form>
        </div>

        <div class="cart-summary">
            <h3>Your Order</h3>
            <?php foreach ($cart as $id => $item): ?>
                <div class="summary-row">
                    <span><?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>)</span>
                    <span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                </div>
            <?php endforeach; ?>
            <hr>
            <div class="summary-row total">
                <span>Total to Pay</span>
                <span>$<?php echo number_format($total_price, 2); ?></span>
            </div>
            
            <!-- This link simulates the "purchase" -->
            <a href="checkout.php?success=true" class="btn btn-primary btn-large btn-full">Place Order</a>
        </div>
    </div>
<?php endif; ?>

<?php
include 'footer.php';
?>
