<?php
session_start();
include("../inc/db.php");

if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($check) > 0) {
    echo "Email already registered!";
  } else {
    mysqli_query($conn, "INSERT INTO users (name,email,password) VALUES('$name','$email','$password')");
    echo "Registered successfully! <a href='user_login.php'>Login</a>";
  }
}
?>

<form method="post">
  <h2>Register</h2>
  <input type="text" name="name" placeholder="Name" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button name="register">Register</button>
</form>
