<?php
// (Session is already started in header.php)
// We need to include header.php, but *after* the redirect logic
//
// So we start the session manually here for the logic, then include header.php
session_start();

// If user is already logged in, redirect to home
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: index.php");
    exit;
}

include 'db_connect.php'; // We still need this for the query

$login_error = '';
$registration_success = '';
$redirect_to = $_GET['redirect'] ?? 'index.php'; // Get redirect URL, default to index.php

// Check if coming from successful registration
if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
    $registration_success = 'Registration successful! Please log in.';
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $redirect_to = $_POST['redirect_to'] ?? 'index.php'; // Get redirect URL from hidden field

    if (empty($email) || empty($password)) {
        $login_error = "Please enter both email and password.";
    } else {
        $sql = "SELECT id, username, email, password_hash FROM users WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $db_email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, session already started
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $db_email;
                            
                            // Redirect user to the page they were on, or home
                            header("location: " . $redirect_to);
                            exit;
                        } else {
                            $login_error = "Invalid email or password.";
                        }
                    }
                } else {
                    $login_error = "Invalid email or password.";
                }
            } else {
                $login_error = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}

// Now include the header
// We pass $registration_success and $login_error to it
$page_title = 'Login - GadgetHut';
include 'header.php';
?>

<!-- Set the page title -->
<script>document.title = 'Login - GadgetHut';</script>

<div class="auth-form">
    <h2>Login</h2>
    
    <?php if(!empty($login_error)): ?>
        <div class="alert alert-danger"><?php echo $login_error; ?></div>
    <?php endif; ?>

    <?php if(!empty($registration_success)): ?>
        <div class="alert alert-success"><?php echo $registration_success; ?></div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <!-- Hidden field to pass the redirect URL -->
        <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($redirect_to); ?>">
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>    
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </form>
</div>

<?php
include 'footer.php';
?>

