<?php
// db_connection.php

$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = "";     // Default is empty in XAMPP
$database = "library_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
