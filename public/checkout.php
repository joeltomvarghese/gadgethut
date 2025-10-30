<?php
session_start();
include_once __DIR__ . '/../inc/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: productcart.php");
    exit;
}

$user = $_SESSION['user'];

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $user_id = $user['id'];

    $insertOrder = mysqli_query($conn, "INSERT INTO orders (user_id, name, address, phone, total) VALUES ('$user_id', '$name', '$address', '$phone', '$total')");
    
    if ($insertOrder) {
        $orderId = mysqli_insert_id($conn);
        foreach ($_SESSION['cart'] as $item) {
            $pid = $item['id'];
            $qty = $item['quantity'];
            $price = $item['price'];
            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$orderId', '$pid', '$qty', '$price')");
        }

        // Clear the cart after checkout
        unset($_SESSION['cart']);
        header("Location: order_success.php");
        exit;
    } else {
        $error = "Failed to place order. Try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - GadgetHut</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
      color: #fff;
    }

    .checkout-container {
      max-width: 600px;
      margin: 3rem auto;
      background: rgba(255,255,255,0.1);
      border-radius: 1rem;
      padding: 2rem;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #00c6ff;
    }

    form input, form textarea {
      width: 100%;
      padding: 0.8rem;
      margin-bottom: 1rem;
      border-radius: 0.5rem;
      border: none;
      background: rgba(255,255,255,0.2);
      color: #fff;
    }

    form textarea {
      resize: none;
      height: 100px;
    }

    .order-summary {
      background: rgba(0,0,0,0.3);
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 1.5rem;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 0.8rem;
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      color: #fff;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 600;
      transition: 0.3s ease;
    }

    .btn:hover {
      background: linear-gradient(135deg, #0072ff, #00c6ff);
    }

    .error {
      text-align: center;
      color: #ff7675;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="checkout-container">
    <h2>Checkout</h2>

    <?php if (isset($error)): ?><p class="error"><?= $error ?></p><?php endif; ?>

    <div class="order-summary">
      <h3>Order Summary</h3>
      <ul>
        <?php foreach ($_SESSION['cart'] as $item): ?>
          <li><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?> — ₹<?= number_format($item['price'] * $item['quantity'], 2) ?></li>
        <?php endforeach; ?>
      </ul>
      <p><strong>Total:</strong> ₹<?= number_format($total, 2) ?></p>
    </div>

    <form method="POST">
      <input type="text" name="name" placeholder="Full Name" required>
      <textarea name="address" placeholder="Delivery Address" required></textarea>
      <input type="text" name="phone" placeholder="Phone Number" required>
      <button type="submit" class="btn">Place Order</button>
    </form>
  </div>
</body>
</html>
