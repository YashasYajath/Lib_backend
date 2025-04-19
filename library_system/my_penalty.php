<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student'];

$sql = "SELECT ib.*, b.title 
        FROM issued_books ib
        JOIN books b ON ib.book_id = b.book_id
        WHERE ib.student_id = $student_id AND ib.status = 'returned'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Penalty</title>
</head>
<body>
    <h2>Penalty Status</h2>
    <table border="1">
        <tr>
            <th>Book Title</th>
            <th>Issue Date</th>
            <th>Return Date</th>
            <th>Days Late</th>
            <th>Penalty (₹)</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php
            $issue_date = new DateTime($row['issue_date']);
            $return_date = new DateTime($row['return_date']);
            $interval = $issue_date->diff($return_date);
            $days = $interval->days;
            $days_late = $days > 7 ? $days - 7 : 0;
            $penalty = $days_late * 5;
        ?>
        <tr>
            <td><?= $row['title']; ?></td>
            <td><?= $row['issue_date']; ?></td>
            <td><?= $row['return_date']; ?></td>
            <td><?= $days_late; ?></td>
            <td>₹<?= $penalty; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br><a href="student_dashboard.php">Back to Dashboard</a>
</body>
</html>
