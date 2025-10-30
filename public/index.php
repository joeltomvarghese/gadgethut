<?php
session_start();
include("../inc/db.php");
include("../inc/header.php");
?>

<h2 style="text-align:center;">Welcome to GadgetHut!</h2>
<p style="text-align:center;">Shop certified refurbished mobiles, laptops & accessories.</p>

<?php
$result = mysqli_query($conn, "SELECT * FROM products LIMIT 6");
echo "<div style='display:flex;flex-wrap:wrap;gap:20px;justify-content:center;'>";
while($row = mysqli_fetch_assoc($result)) {
  echo "
    <div style='border:1px solid #ccc; padding:10px; width:200px; text-align:center;'>
      <h3>{$row['name']}</h3>
      <p>₹{$row['price']}</p>
      <a href='product.php?id={$row['id']}'>View</a>
    </div>
  ";
}
echo "</div>";

include("../inc/footer.php");
?>
