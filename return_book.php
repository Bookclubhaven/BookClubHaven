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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_title'], $_POST['borrower_name'])) {
    $bookTitle = $_POST['book_title'];
    $borrowerName = $_POST['borrower_name'];
    $dateReturned = date('Y-m-d H:i:s');

    // Update the date returned for the specific book and borrower
    $stmt = $conn->prepare("UPDATE `borrowedbooks` SET DateReturned = ? WHERE BookTitle = ? AND BorrowerName = ? AND DateReturned IS NULL");
    $stmt->bind_param("sss", $dateReturned, $bookTitle, $borrowerName);
    
    if ($stmt->execute()) {
        header('Location: admin_dashboard.php');
    } else {
        echo "Failed to mark book as returned. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>
