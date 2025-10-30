<?php
include_once __DIR__ . '/../inc/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check for existing email
    $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkUser) > 0) {
        $error = "Email already exists!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        if ($insert) {
            $_SESSION['user'] = [
                'id' => mysqli_insert_id($conn),
                'username' => $username,
                'email' => $email
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - GadgetHut</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="auth-container">
    <h2>Create an Account</h2>
    <?php if (isset($error)): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
      <p>Already have an account? <a href="user_login.php">Login here</a></p>
    </form>
  </div>
</body>
</html>
