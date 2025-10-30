<?php
session_start();
include_once __DIR__ . '/../inc/db.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (isset($_GET['add'])) {
    $id = (int) $_GET['add'];
    $check = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    if ($row = mysqli_fetch_assoc($check)) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'qty' => 1,
                'image' => $row['image']
            ];
        }
    }
    header("Location: productcart.php");
    exit;
}

// Remove item
if (isset($_GET['remove'])) {
    $id = (int) $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: productcart.php");
    exit;
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart - GadgetHut</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
  body { background: linear-gradient(135deg,#141e30,#243b55); color:#fff; }
  table { width:90%; margin:2rem auto; border-collapse:collapse; }
  th,td { padding:1rem; border-bottom:1px solid rgba(255,255,255,0.1); text-align:center; }
  img { width:70px; border-radius:8px; }
  .checkout { display:flex; justify-content:center; gap:1rem; margin:2rem; }
  .btn {
    background:linear-gradient(135deg,#00c6ff,#0072ff);
    border:none; padding:0.6rem 1.5rem; border-radius:8px; color:#fff;
    font-weight:500; cursor:pointer; transition:0.3s;
  }
  .btn:hover { background:linear-gradient(135deg,#0072ff,#00c6ff); }
</style>
</head>
<body>
<header style="text-align:center;padding:1rem;background:rgba(255,255,255,0.1);">
  <h1>🛒 Your Cart</h1>
</header>

<?php if (empty($_SESSION['cart'])): ?>
  <p style="text-align:center;margin-top:3rem;">Your cart is empty. <a href="index.php" style="color:#00c6ff;">Shop now</a></p>
<?php else: ?>
  <table>
    <tr>
      <th>Image</th>
      <th>Product</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
      <tr>
        <td><img src="../images/<?= htmlspecialchars($item['image']) ?>" alt=""></td>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td>₹<?= number_format($item['price'],2) ?></td>
        <td><?= $item['qty'] ?></td>
        <td>₹<?= number_format($item['price']*$item['qty'],2) ?></td>
        <td><a href="?remove=<?= $id ?>" class="btn">Remove</a></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <div class="checkout">
    <h2>Total: ₹<?= number_format($total,2) ?></h2>
    <a href="checkout.php" class="btn">Proceed to Checkout</a>
  </div>
<?php endif; ?>
</body>
</html>
