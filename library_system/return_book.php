<?php
session_start();
include('db_connection.php');

// Check if student is logged in
if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student'];

// Fetch the books issued to the student
$sql = "SELECT ib.issued_id, b.book_id, b.title, ib.issue_date 
        FROM issued_books ib
        JOIN books b ON ib.book_id = b.book_id
        WHERE ib.student_id = '$student_id' AND ib.status = 'issued'";


$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    // Print the error message from MySQL
    die('Error executing query: ' . mysqli_error($conn));
}

// Check if any books are issued
if (mysqli_num_rows($result) > 0) {
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $message = "You have no books to return.";
}

// Handle the return book action
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issued_id = $_POST['issued_id']; // The issued book's record ID

    // Update the status of the book to 'returned'
    $update_sql = "UPDATE issued_books SET status = 'returned' WHERE issued_id = '$issued_id' AND student_id = '$student_id'";
    
    if (mysqli_query($conn, $update_sql)) {
        $message = "Book returned successfully.";
    } else {
        $message = "Error returning book: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Book</title>
</head>
<body>
    <h2>Return Book</h2>

    <?php
    if (isset($message)) {
        echo "<p style='color: green;'>$message</p>";
    }
    ?>

    <?php if (isset($books) && count($books) > 0): ?>
        <form method="post">
            <label>Select Book to Return:</label>
            <select name="issued_id" required>
                <?php
                foreach ($books as $book) {
                    echo "<option value='" . $book['issued_id'] . "'>" . $book['book_title'] . " (Issued on: " . $book['issue_date'] . ")</option>";
                }
                ?>
            </select>
            <br><br>
            <button type="submit">Return Book</button>
        </form>
    <?php else: ?>
        <p>You have no books to return.</p>
    <?php endif; ?>

    <br><br>
    <a href="student_dashboard.php">Go to Dashboard</a>
</body>
</html>
