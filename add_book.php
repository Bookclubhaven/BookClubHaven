<?php
session_start();

// Database connection settings
$host = 'localhost';
$db = 'bookclub';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the admin is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: admin_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrower_name'], $_POST['course'], $_POST['year'], $_POST['book_title'])) {
    $borrowerName = $_POST['borrower_name'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $bookTitle = $_POST['book_title'];
    $dateBorrowed = date('Y-m-d H:i:s');

    // Insert the borrowed book into the database
    $stmt = $conn->prepare("INSERT INTO borrowed_books (BorrowerName, Course, Year, BookTitle, DateBorrowed) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $borrowerName, $course, $year, $bookTitle, $dateBorrowed);
    
    if ($stmt->execute()) {
        header('Location: admin_dashboard.php');
    } else {
        echo "Failed to add borrowed book. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>
