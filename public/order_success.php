<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Optional: you can add a thank-you message with order details later
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Success - GadgetHut</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="success-container">
    <h1>🎉 Order Placed Successfully!</h1>
    <p>Thank you for shopping with GadgetHut. Your order is confirmed and will be processed soon.</p>
    <a href="index.php" class="btn">Continue Shopping</a>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
