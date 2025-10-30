<?php
session_start();
include_once __DIR__ . '/../inc/db.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // If already in cart, increase quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }
    header("Location: productcart.php");
    exit;
}

// Remove item
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$remove_id]);
    header("Location: productcart.php");
    exit;
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['quantity'] as $id => $qty) {
        $_SESSION['cart'][$id]['quantity'] = max(1, intval($qty));
    }
    header("Location: productcart.php");
    exit;
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart - GadgetHut</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      color: #fff;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    header h1 {
      font-size: 1.8rem;
      color: #00c6ff;
    }

    table {
      width: 90%;
      margin: 2rem auto;
      border-collapse: collapse;
      background: rgba(255,255,255,0.1);
      border-radius: 1rem;
      overflow: hidden;
    }

    th, td {
      padding: 1rem;
      text-align: center;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    img {
      width: 80px;
      border-radius: 0.5rem;
    }

    input[type="number"] {
      width: 60px;
      padding: 0.3rem;
      text-align: center;
      border-radius: 0.4rem;
      border: none;
    }

    .remove-btn, .checkout-btn, .update-btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
      font-weight: 500;
      transition: 0.3s;
    }

    .remove-btn {
      background: #ff4b5c;
      color: #fff;
    }

    .remove-btn:hover {
      background: #ff1e38;
    }

    .update-btn {
      background: linear-gradient(135deg, #0072ff, #00c6ff);
      color: #fff;
    }

    .checkout-btn {
      background: linear-gradient(135deg, #00b09b, #96c93d);
      color: #fff;
      display: block;
      margin: 2rem auto;
      font-size: 1.1rem;
    }

    .total {
      text-align: right;
      font-size: 1.3rem;
      padding-right: 5%;
      margin-top: 1rem;
    }

  </style>
</head>
<body>
  <header>
    <h1>🛒 Your Cart</h1>
    <nav>
      <a href="index.php" style="color:#fff;">Home</a>
      <a href="logout.php" style="color:#fff;">Logout</a>
    </nav>
  </header>

  <?php if (!empty($_SESSION['cart'])): ?>
  <form method="POST">
    <table>
      <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
      </tr>
      <?php foreach ($_SESSION['cart'] as $item): ?>
      <tr>
        <td><img src="../images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td>₹<?= number_format($item['price'], 2) ?></td>
        <td><input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1"></td>
        <td>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        <td><a href="productcart.php?remove=<?= $item['id'] ?>" class="remove-btn">Remove</a></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <div class="total">
      <strong>Total: ₹<?= number_format($total, 2) ?></strong>
    </div>
    <div style="text-align:center;">
      <button type="submit" class="update-btn">Update Cart</button>
      <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
    </div>
  </form>
  <?php else: ?>
    <h2 style="text-align:center; margin-top: 3rem;">Your cart is empty!</h2>
  <?php endif; ?>
</body>
</html>
