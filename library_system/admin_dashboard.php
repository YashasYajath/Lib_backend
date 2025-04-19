<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>

    <a href="add_book.php">Add Book</a><br>
    <a href="view_books.php">View Books</a><br>
    <a href="issue_book.php">Issue Book</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
