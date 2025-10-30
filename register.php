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

$register_error = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (rest of your registration PHP logic is fine) ...
    
    // Validate username
    $username = trim($_POST['username']);
    if (empty($username)) {
        $register_error = "Please enter a username.";
    }

    // Validate email
    $email = trim($_POST['email']);
    if (empty($email)) {
        $register_error = "Please enter an email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = "Please enter a valid email.";
    }

    // Validate password
    $password = trim($_POST['password']);
    if (empty($password)) {
        $register_error = "Please enter a password.";
    } elseif (strlen($password) < 6) {
        $register_error = "Password must have at least 6 characters.";
    }

    // Check for duplicate email
    if (empty($register_error)) {
        $sql_check = "SELECT id FROM users WHERE email = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();
            
            if ($stmt_check->num_rows > 0) {
                $register_error = "This email is already registered.";
            }
            $stmt_check->close();
        }
    }

    // If no errors, insert into database
    if (empty($register_error)) {
        $sql_insert = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql_insert)) {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt->bind_param("sss", $username, $email, $password_hash);
            
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: login.php?registration=success");
                exit;
            } else {
                $register_error = "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}

// Now include the header
include 'header.php';
?>

<!-- Set the page title -->
<script>document.title = 'Register - GadgetHut';</script>

<div class="auth-form">
    <h2>Create an Account</h2>
    
    <?php if(!empty($register_error)): ?>
        <div class="alert alert-danger"><?php echo $register_error; ?></div>
    <?php endif; ?>

    <form action="register.php" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>    
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" minlength="6" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Register">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>

<?php
include 'footer.php';
?>

