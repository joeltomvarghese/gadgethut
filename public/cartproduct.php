<?php
require_once 'inc/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_id'])) {
  $id = (int)$_POST['add_id'];
  $qty = max(1,(int)$_POST['qty']);
  if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
  if (!isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id] = 0;
  $_SESSION['cart'][$id] += $qty;
  header('Location: cart.php'); exit;
}
if (isset($_GET['remove'])) {
  $rid = (int)$_GET['remove'];
  unset($_SESSION['cart'][$rid]);
  header('Location: cart.php'); exit;
}
require_once 'inc/header.php';
$cart = $_SESSION['cart'] ?? [];
if (!$cart) echo "<p>Your cart is empty</p>";
else {
  $ids = implode(',', array_keys($cart));
  $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
  $products = $stmt->fetchAll(PDO::FETCH_UNIQUE);
  $total = 0;
  echo '<table class="cart">';
  echo '<tr><th>Product</th><th>Qty</th><th>Price</th><th></th></tr>';
  foreach($cart as $pid=>$q) {
    $p = $products[$pid];
    $line = $p['price'] * $q; $total += $line;
    echo "<tr><td>".htmlspecialchars($p['title'])."</td><td>$q</td><td>₹".number_format($line,2)."</td><td><a href='cart.php?remove=$pid'>Remove</a></td></tr>";
  }
  echo "<tr><td colspan='2'></td><td><strong>₹".number_format($total,2)."</strong></td><td><a href='checkout.php'>Checkout</a></td></tr>";
  echo '</table>';
}
require_once 'inc/footer.php';
