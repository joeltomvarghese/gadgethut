<?php
require_once 'inc/db.php';
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php'); exit;
}
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header('Location: cart.php'); exit; }
$ids = implode(',', array_keys($cart));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll(PDO::FETCH_UNIQUE);
$total = 0; foreach($cart as $id=>$q) $total += $products[$id]['price'] * $q;

$pdo->beginTransaction();
try {
  $stmt = $pdo->prepare("INSERT INTO orders (user_id,total) VALUES (?,?)");
  $stmt->execute([$_SESSION['user']['id'],$total]);
  $order_id = $pdo->lastInsertId();
  $stmti = $pdo->prepare("INSERT INTO order_items (order_id,product_id,qty,price) VALUES (?,?,?,?)");
  foreach($cart as $id=>$q) {
    $price = $products[$id]['price'];
    $stmti->execute([$order_id,$id,$q,$price]);
    // optionally reduce product qty here
  }
  $pdo->commit();
  unset($_SESSION['cart']);
  header("Location: index.php?ordered=1"); exit;
} catch (Exception $e) {
  $pdo->rollBack();
  die("Checkout failed: " . $e->getMessage());
}
