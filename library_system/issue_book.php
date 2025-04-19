<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $student_id = $_POST['student_id'];
    $issue_date = date('Y-m-d');

    $sql = "INSERT INTO issued_books (book_id, student_id, issue_date, status)
        VALUES ('$book_id', '$student_id', '$issue_date', 'issued')";

    if (mysqli_query($conn, $sql)) {
        echo "Book issued successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Get available books and students
$books = mysqli_query($conn, "SELECT * FROM books");
$students = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
</head>
<body>
    <h2>Issue Book to Student</h2>
    <form method="POST" action="issue_book.php">
        <label>Select Book:</label><br>
        <select name="book_id" required>
            <option value="">-- Select Book --</option>
            <?php while ($row = mysqli_fetch_assoc($books)): ?>
                <option value="<?= $row['book_id']; ?>"><?= $row['title']; ?> (ID: <?= $row['book_id']; ?>)</option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Select Student:</label><br>
        <select name="student_id" required>
            <option value="">-- Select Student --</option>
            <?php while ($row = mysqli_fetch_assoc($students)): ?>
                <option value="<?= $row['student_id']; ?>"><?= $row['name']; ?> (ID: <?= $row['student_id']; ?>)</option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Issue Book">
    </form>

    <br><a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
