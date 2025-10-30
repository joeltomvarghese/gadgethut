<?php
session_start();
include_once __DIR__ . '/../inc/db.php';

// Fetch all products
$result = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GadgetHut - Home</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #141e30, #243b55);
      flex-direction: column;
      align-items: stretch;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      padding: 1rem 2rem;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    header h1 {
      font-size: 1.8rem;
      letter-spacing: 1px;
      color: #00c6ff;
    }

    nav a {
      margin: 0 1rem;
      color: #fff;
      text-decoration: none;
      transition: color 0.2s ease;
      font-weight: 500;
    }

    nav a:hover {
      color: #00c6ff;
    }

    .product-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      padding: 2rem;
    }

    .product-card {
      background: rgba(255,255,255,0.1);
      border-radius: 1rem;
      padding: 1.5rem;
      text-align: center;
      color: #fff;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    }

    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 0.8rem;
      margin-bottom: 1rem;
    }

    .product-card h3 {
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
    }

    .product-card p {
      font-size: 0.9rem;
      color: #dcdcdc;
      margin-bottom: 1rem;
    }

    .price {
      font-size: 1.1rem;
      color: #00c6ff;
      font-weight: 600;
      margin-bottom: 0.8rem;
    }

    .buy-btn {
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      color: #fff;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 0.5rem;
      cursor: pointer;
      font-weight: 500;
      transition: 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .buy-btn:hover {
      background: linear-gradient(135deg, #0072ff, #00c6ff);
    }

    footer {
      text-align: center;
      padding: 1rem;
      background: rgba(255,255,255,0.05);
      color: #aaa;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      border-top: 1px solid rgba(255,255,255,0.1);
    }
  </style>
</head>
<body>
  <header>
    <h1>GadgetHut</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="search.php">Search</a>
      <a href="productcart.php">Cart</a>
      <?php if (isset($_SESSION['user'])): ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="user_login.php">Login</a>
      <?php endif; ?>
    </nav>
  </header>

  <section class="product-container">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="product-card">
        <img src="../images/<?= htmlspecialchars($row['image'] ?: 'default.jpg') ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <p class="price">₹<?= number_format($row['price'], 2) ?></p>
        <a href="productcart.php?add=<?= $row['id'] ?>" class="buy-btn">Add to Cart</a>
      </div>
    <?php endwhile; ?>
  </section>

  <footer>
    &copy; <?= date('Y') ?> GadgetHut Store — All Rights Reserved.
  </footer>
</body>
</html>
