<?php
include("../inc/db.php");
include("../inc/header.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);
?>

<div style="text-align:center;">
  <h2><?php echo $product['name']; ?></h2>
  <p><?php echo $product['description']; ?></p>
  <p>Price: ₹<?php echo $product['price']; ?></p>
  <form method="post" action="cartproduct.php">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <button type="submit" name="add_to_cart">Add to Cart</button>
  </form>
</div>

<?php include("../inc/footer.php"); ?>
