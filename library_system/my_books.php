<?php
session_start();
include('db_connection.php');

// Check if the student is logged in
if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student'];

// Use prepared statement to avoid SQL injection
$sql = "SELECT ib.*, b.title AS book_title
        FROM issued_books ib
        JOIN books b ON ib.book_id = b.book_id
        WHERE ib.student_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if query returned results
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Issued Books</title>
</head>
<body>
    <h2>My Books</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
    <table border="1">
        <tr>
            <th>Book Title</th>
            <th>Issue Date</th>
            <th>Return Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <!-- Use 'book_title' since that’s the alias you assigned -->
            <td><?= htmlspecialchars($row['book_title']); ?></td>
            <td><?= htmlspecialchars($row['issue_date']); ?></td>
            <td><?= $row['return_date'] ?? "Not Returned"; ?></td>
            <td><?= ucfirst(htmlspecialchars($row['status'])); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No books issued.</p>
    <?php endif; ?>
    <br><a href="student_dashboard.php">Back to Dashboard</a>
</body>
</html>
