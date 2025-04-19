<?php
session_start();
include('db_connection.php');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if username and password exist
    $query = "SELECT * FROM students WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Login successful, redirect to student dashboard
        $_SESSION['username'] = $username;
        header('Location: student_dashboard.php');
    } else {
        // Login failed, show an error message
        echo "<script>alert('Invalid username or password. Please try again.'); window.location='student_login.php';</script>";
    }
}
?>
