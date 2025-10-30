<?php
/*
 * ---------------------------------------------------
 * DB Connect - Database Connection File
 * ---------------------------------------------------
 * This file connects to the MySQL database.
 *
 * XAMPP (Local) Settings:
 * $servername = "localhost";
 * $username = "root";
 * $password = ""; // Default is empty
 * $dbname = "gadgethut";
 *
 * AWS EC2 (Production) Settings:
 * $servername = "localhost";
 * $username = "gadgethut_user"; // The user you created on AWS
 * $password = "YOUR_STRONG_PASSWORD"; // The password you set on AWS
 * $dbname = "gadgethut";
 *
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgethut";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
