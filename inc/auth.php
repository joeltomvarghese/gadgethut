<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../public/user_login.php");
    exit;
}
?>
