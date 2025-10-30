<header>
  <h1>GadgetHut</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="product.php">Products</a>
    <a href="cartproduct.php">Cart</a>
    <a href="search.php">Search</a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="user_login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>
<hr>
