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

// Fetch the recently added books from the database
$sql = "SELECT * FROM books ORDER BY date_added DESC LIMIT 10"; // Change the limit as needed
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recently Added Books</title>
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

        .logout-link, .back-button {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-left: 10px; /* Space between buttons */
        }

        .logout-link {
            background-color: #d9534f;
        }

        .logout-link:hover {
            background-color: #c9302c;
        }

        .back-button {
            background-color: #5bc0de;
            border: none;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #31b0d5; /* Darker blue on hover */
        }

        .book-list {
            margin: 20px auto;
            text-align: left; /* Align text to the left */
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
        }

        .book {
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Center items vertically */
            margin: 10px 0; /* Add margin for spacing */
        }

        .book img {
            max-width: 100px; /* Limit image size */
            margin-right: 20px; /* Space between image and text */
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h2>Recently Added Books</h2>
        <div>
            <button class="back-button" onclick="window.location.href='admin_dashboard.php'">Back to Admin Dashboard</button>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </header>

    <div class="book-list">
        <?php
        if (isset($result) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book'>";
                echo "<img src='" . htmlspecialchars($row['cover_image']) . "' alt='Cover Image'>"; // Display cover image
                echo "<div class='book-info'>"; // Container for book info
                echo "<strong>Category:</strong> " . htmlspecialchars($row['category']) . "<br>";
                echo "<strong>Title:</strong> " . htmlspecialchars($row['book_title']);
                echo "</div>"; // Close book-info
                echo "</div>"; // Close book
            }
        } else {
            echo "<p>No recently added books found.</p>";
        }
        $conn->close();
        ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Our BookClub. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
