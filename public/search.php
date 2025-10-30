<?php
include("../inc/db.php");
include("../inc/header.php");
?>

<form method="get" style="text-align:center;">
  <input type="text" name="q" placeholder="Search products">
  <button type="submit">Search</button>
</form>

<?php
if (isset($_GET['q'])) {
  $q = $_GET['q'];
  $result = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$q%'");

  echo "<div style='display:flex;flex-wrap:wrap;gap:20px;justify-content:center;'>";
  while($row = mysqli_fetch_assoc($result)) {
    echo "
      <div style='border:1px solid #ccc; padding:10px; width:200px; text-align:center;'>
        <h3>{$row['name']}</h3>
        <p>₹{$row['price']}</p>
      </div>
    ";
  }
  echo "</div>";
}

include("../inc/footer.php");
?>
