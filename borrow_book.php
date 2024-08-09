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

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit;
}

// Handle borrow book request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookId = $_POST['book_id'];
    $bookTitle = $_POST['book_title'];
    $borrowerName = $_POST['borrower_name'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $bookCode = $_POST['book_code']; // Retrieve BookCode from the form
    $dateBorrowed = date("Y-m-d H:i:s"); // Current date and time for borrowed date
    $dateReturned = null; // Initially null for returned date

    // Insert the borrow request into the database
    $stmt = $conn->prepare("INSERT INTO borrowedbooks (BorrowerName, Course, Year, BookTitle, BookCode, DateBorrowed, DateReturned) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $borrowerName, $course, $year, $bookTitle, $bookCode, $dateBorrowed, $dateReturned);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Book borrowed successfully!";
    } else {
        $_SESSION['message'] = "Failed to borrow book. Please try again.";
    }

    $stmt->close();
    $conn->close();
    
    // Redirect back to the books page
    header('Location: books.php');
    exit;
}
