<?php
include_once __DIR__ . '/../inc/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - GadgetHut</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="auth-container">
    <h2>Login to GadgetHut</h2>
    <?php if (isset($error)): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
  </div>
</body>
</html>
