<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT books.*, 
               publications.name AS publication_name, 
               branches.name AS branch_name 
        FROM books 
        LEFT JOIN publications ON books.publication_id = publications.publication_id 
        LEFT JOIN branches ON books.branch_id = branches.branch_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Books</title>
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
    <h2>All Books</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Publication</th>
            <th>Branch</th>
            <th>Quantity</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['book_id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['author'] ?></td>
            <td><?= $row['isbn'] ?></td>
            <td><?= $row['publication_name'] ?></td>
            <td><?= $row['branch_name'] ?></td>
            <td><?= $row['quantity'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br><center><a href="admin_dashboard.php">Back to Dashboard</a></center>
</body>
</html>
