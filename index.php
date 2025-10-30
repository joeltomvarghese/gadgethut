<?php
// (Session is already started in header.php)
include 'header.php'; // Includes session_start() and db_connect.php

// Fetch products from database
$sql = "SELECT id, name, description, price, image_url FROM products";
$result = $conn->query($sql);
?>

<!-- Set the page title -->
<script>document.title = 'GadgetHut - Refurbished Gadgets';</script>

<h1>Our Products</h1>
<p class="subtitle">Quality refurbished gadgets you can trust.</p>

<div class="product-grid">
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            // Link the whole image and title to the product page
            echo '<a href="product.php?id=' . $row["id"] . '" class="product-link">';
            echo '<img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["name"]) . '">';
            echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
            echo '</a>';
            echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
            echo '<span class="price">$' . number_format($row["price"], 2) . '</span>';
            
            // --- Add to Cart Form ---
            echo '<form action="cart-logic.php" method="post">';
            echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
            echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($row["name"]) . '">';
            echo '<input type="hidden" name="product_price" value="' . $row["price"] . '">';
            echo '<input type="hidden" name="quantity" value="1">'; // Default to 1
            echo '<button type="submit" name="action" value="add" class="btn btn-primary">Add to Cart</button>';
            echo '</form>';
            
            echo '</div>';
        }
    } else {
        echo "<p>No products found.</p>";
    }
    $conn->close();
    ?>
</div>

<?php
include 'footer.php';
?>

