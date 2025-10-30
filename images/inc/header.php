<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header style="background:#222; color:white; padding:15px; text-align:center;">
  <h1>GadgetHut</h1>
  <nav>
    <a href="index.php" style="color:white;margin:0 10px;">Home</a>
    <a href="product.php" style="color:white;margin:0 10px;">Products</a>
    <a href="cartproduct.php" style="color:white;margin:0 10px;">Cart</a>
    <a href="search.php" style="color:white;margin:0 10px;">Search</a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="logout.php" style="color:white;margin:0 10px;">Logout</a>
    <?php else: ?>
        <a href="user_login.php" style="color:white;margin:0 10px;">Login</a>
        <a href="register.php" style="color:white;margin:0 10px;">Register</a>
    <?php endif; ?>
  </nav>
</header>
<hr>
