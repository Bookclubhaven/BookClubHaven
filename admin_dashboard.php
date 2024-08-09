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

// Fetch the borrowed books from the database
$sql = "SELECT `id`, `BorrowerName`, `Course`, `Year`, `BookTitle`, `BookCode`, `DateBorrowed`, `DateReturned` FROM `borrowedbooks`"; 
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        header {
            background-color: #214e5e;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logout-link {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            background-color: #d9534f;
            transition: background-color 0.3s;
        }

        .logout-link:hover {
            background-color: #c9302c;
        }

        .table-container {
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-button, .return-button {
            padding: 6px 12px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 5px;
        }

        .delete-button {
            background-color: #d9534f;
        }

        .delete-button:hover {
            background-color: #c9302c;
        }

        .return-button {
            background-color: #5bc0de;
        }

        .return-button:hover {
            background-color: #31b0d5;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 27%;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h2 style="margin: 0;">Admin Dashboard</h2>
        <a href="logout.php" class="logout-link">Logout</a>
    </header>

    <div class="table-container">
        <h3>Borrowed Books</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Borrower Name</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Book Title</th>
                    <th>Book Code</th>
                    <th>Date Borrowed</th>
                    <th>Date Returned</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php
    if (isset($result) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['BorrowerName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Course']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Year']) . "</td>";
            echo "<td>" . htmlspecialchars($row['BookTitle']) . "</td>";
            echo "<td>" . htmlspecialchars($row['BookCode']) . "</td>";
            echo "<td>" . htmlspecialchars($row['DateBorrowed']) . "</td>";
            echo "<td>" . htmlspecialchars($row['DateReturned']) . "</td>";
            echo "<td>
    <form method='post' action='delete_borrowed_book.php' style='display:inline;'>
        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
        <button type='submit' class='delete-button'>Delete</button>
    </form>
    <form method='post' action='return_book.php' style='display:inline;'>
        <input type='hidden' name='book_title' value='" . htmlspecialchars($row['BookTitle']) . "'>
        <input type='hidden' name='borrower_name' value='" . htmlspecialchars($row['BorrowerName']) . "'>
        <button type='submit' class='return-button'>Return</button>
    </form>
</td>
";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No records found.</td></tr>";
    }

    // Close the database connection
    $conn->close();
    ?>
            </tbody>
        </table>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Our BookClub. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
