<?php
require_once 'inc/db.php';
require_once 'inc/header.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) { echo "<p>Product not found</p>"; require_once 'inc/footer.php'; exit; }
?>
<div class="product-detail">
  <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="">
  <div>
    <h2><?php echo htmlspecialchars($p['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($p['description'])); ?></p>
    <p>₹<?php echo number_format($p['price'],2); ?></p>
    <form method="post" action="cart.php">
      <input type="hidden" name="add_id" value="<?php echo $p['id']; ?>">
      <input type="number" name="qty" value="1" min="1" max="<?php echo $p['qty']; ?>">
      <button type="submit">Add to cart</button>
    </form>
  </div>
</div>
<?php require_once 'inc/footer.php'; ?>
