<?php
include 'header.php'; // Includes session_start() and db_connect.php

// Check if product ID is set
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h1>Product not found</h1>";
    echo "<p>Sorry, the product you are looking for does not exist.</p>";
    include 'footer.php';
    exit;
}

$product_id = $_GET['id'];

// Fetch the specific product from database
$stmt = $conn->prepare("SELECT id, name, description, price, image_url FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $product = $result->fetch_assoc();
} else {
    echo "<h1>Product not found</h1>";
    echo "<p>Sorry, the product you are looking for does not exist.</p>";
    include 'footer.php';
    exit;
}
$stmt->close();
$conn->close();
?>

<!-- Set the page title -->
<script>document.title = '<?php echo htmlspecialchars($product["name"]); ?> - GadgetHut';</script>

<div class="product-detail-layout">
    <div class="product-detail-image">
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    
    <div class="product-detail-info">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <span class="product-detail-price">$<?php echo number_format($product['price'], 2); ?></span>
        
        <div class="product-description">
            <h3>Product Details</h3>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); // nl2br converts newlines to <br> tags ?></p>
            <p><strong>Condition:</strong> Refurbished (Grade A)</p>
            <p><strong>Warranty:</strong> 1-Year GadgetHut Warranty</p>
        </div>

        <!-- Add to Cart Form -->
        <form action="cart-logic.php" method="post" class="cart-form-detailed">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
            <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
            
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
            </div>
            
            <button type="submit" name="action" value="add" class="btn btn-primary btn-large">Add to Cart</button>
        </form>
    </div>
</div>

<?php
include 'footer.php';
?>
