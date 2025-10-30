<?php
session_start();
include("../inc/db.php");

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  $row = mysqli_fetch_assoc($res);

  if ($row && password_verify($password, $row['password'])) {
    $_SESSION['user'] = $row['name'];
    header("Location: index.php");
  } else {
    echo "<p style='color:red;'>Invalid credentials!</p>";
  }
}
?>

<form method="post" style="text-align:center;">
  <h2>Login</h2>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button name="login">Login</button>
</form>
