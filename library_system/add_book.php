<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Insert book if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $publication_id = $_POST['publication_id'];
    $branch_id = $_POST['branch_id'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO books (title, author, isbn, publication_id, branch_id, quantity)
            VALUES ('$title', '$author', '$isbn', '$publication_id', '$branch_id', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        echo "Book added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch publications and branches for dropdowns
$publications = mysqli_query($conn, "SELECT * FROM publications");
$branches = mysqli_query($conn, "SELECT * FROM branches");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
</head>
<body>
    <h2>Add New Book</h2>
    <form method="POST" action="add_book.php">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Author:</label><br>
        <input type="text" name="author" required><br><br>

        <label>ISBN:</label><br>
        <input type="text" name="isbn" required><br><br>

        <label>Publication:</label><br>
        <select name="publication_id" required>
            <option value="">Select Publication</option>
            <?php while ($row = mysqli_fetch_assoc($publications)): ?>
                <option value="<?php echo $row['publication_id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Branch:</label><br>
        <select name="branch_id" required>
            <option value="">Select Branch</option>
            <?php while ($row = mysqli_fetch_assoc($branches)): ?>
                <option value="<?php echo $row['branch_id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" required><br><br>

        <input type="submit" value="Add Book">
    </form>

    <br><a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
