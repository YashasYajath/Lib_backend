<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);  // Get the password input

    // Query to check if the student exists with the provided username and password
    $sql = "SELECT * FROM students WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        // Fetch student details from the database
        $student = mysqli_fetch_assoc($result);
        $_SESSION['student'] = $student['student_id'];  // Store the student ID in the session
        header("Location: student_dashboard.php");  // Redirect to the student dashboard
        exit();
    } else {
        $error = "Invalid username or password.";  // Error message for invalid login
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
</head>
<body>
    <h2>Student Login</h2>
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>  <!-- Added password field -->
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
        <a href="login.php">Admin Login</a>
    </form>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?> <!-- Display error if login fails -->
</body>
</html>
