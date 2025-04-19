<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch returned books and calculate penalty if returned late
$sql = "SELECT ib.*, s.name AS student_name, b.title AS book_title 
        FROM issued_books ib
        JOIN students s ON ib.student_id = s.student_id
        JOIN books b ON ib.book_id = b.book_id
        WHERE ib.status = 'returned'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Penalty Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: auto;
        }
        th, td {
            border: 1px solid gray;
            padding: 8px;
            text-align: left;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Penalty Report</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Book</th>
            <th>Student</th>
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
            $penalty = $days_late * 5; // ₹5 per day late
        ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['book_title']; ?></td>
            <td><?= $row['student_name']; ?></td>
            <td><?= $row['issue_date']; ?></td>
            <td><?= $row['return_date']; ?></td>
            <td><?= $days_late; ?></td>
            <td>₹<?= $penalty; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br><center><a href="admin_dashboard.php">Back to Dashboard</a></center>
</body>
</html>
