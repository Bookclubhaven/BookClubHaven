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

// Check if the id is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM `borrowedbooks` WHERE `id` = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Record deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting record: " . $conn->error;
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "No record selected.";
}

$conn->close();
header('Location: admin_dashboard.php');
exit;
?>
