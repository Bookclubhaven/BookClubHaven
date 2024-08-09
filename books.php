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

// Fetch the books from the database
$sql = "SELECT `id`, `BorrowerName`, `Course`, `Year`, `BookTitle`, `BookCode`, `DateBorrowed`, `DateReturned` FROM `borrowedbooks`"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
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

        .logo-container {
            text-align: center;
            margin-top: 20px;
        }

        .book-list {
            margin: 30px auto;
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 70%;
            margin-top: 20px;
        }

        .book {
            display: flex;
            align-items: center;
            margin: 20px 0;
            
        }

        .book-title {
            flex-grow: 1;
            text-align: left;
        }

        .borrow-button {
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .borrow-button:hover {
            background-color: #4cae4c;
        }
        .book-thumbnails {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }

        .book-thumbnails .thumbnail {
            width: 150px;
            height: 220px;
            object-fit: cover;
            border-radius: 5px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .book-thumbnails .thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }


        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 11.5%;
        }

        footer p {
            margin: 0;
        }

       /* Modal Styles */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0, 0, 0, 0.4); 
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Shadow effect */
}

.modal h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.modal form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.modal input[type="text"],
.modal select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    width: 100%;
}

.modal button[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.modal button[type="submit"]:hover {
    background-color: #0056b3;
}

.modal .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.modal .close:hover,
.modal .close:focus {
    color: black;
    text-decoration: none;
}



        /* Success Message Styles */
        .alert {
            margin: 20px 0;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border-radius: 5px;
            text-align: center;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .alert.show {
            opacity: 1;
        }

    </style>
</head>
<body>
    
    <header>
        <h2 style="margin: 0;">Borrow Books</h2>
        <a href="logout.php" class="logout-link">Logout</a>
    </header>
    <div class="logo-container">
        <img src="haven.png" alt="BookClub Logo" style="width: 90px; height: 80px;">
    </div>

    <div class="book-list">
    <div class="book-thumbnails">
        <img src="ht.jpg" alt="" class="thumbnail">
        <img src="htl.jpg" alt="" class="thumbnail">
        <img src="ed.jpg" alt="" class="thumbnail">
        <img src="bit.jpg" alt="" class="thumbnail">
        <img src="tour.jpg" alt="" class="thumbnail">
        <img src="re.jpg" alt="" class="thumbnail">
    </div>

    <div style="margin-top: 20px;">
        <button class="borrow-button" onclick="openModal('', '', '');">Borrow a Book</button>
    </div>
</div>


        <?php
        // Display success message
        if (isset($_SESSION['message'])) {
            echo "<div class='alert show'>" . htmlspecialchars($_SESSION['message']) . "</div>";
            unset($_SESSION['message']); 
        }

        // Fetch books from the database
       
        $conn->close();
        ?>
    </div>

    <!-- Modal for Borrowing -->
    <div id="borrowModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Borrow Book</h2>
            <form id="borrowForm" method="post" action="borrow_book.php">
                <input type="hidden" name="book_id" id="book_id">
                <input type="text" name="book_title" placeholder="Book Title" id="book_title">
                <input type="text" name="book_code" placeholder="Enter Code" id="book_code" required>
                <input type="text" name="borrower_name" placeholder="Borrower Name" required>
                <select name="course" required>
                    <option value="">Select Course</option>
                    <option value="BSIT">BSIT</option>
                    <option value="EDUC">EDUC</option>
                    <option value="HTM">HTM</option>
                </select>
                <select name="year" required>
                    <option value="">Select Year</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                </select>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Our BookClub. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function openModal(bookId, bookTitle, bookCode) {
            document.getElementById('book_id').value = bookId;
            document.getElementById('book_title').value = bookTitle;
            document.getElementById('book_code').value = bookCode;
            document.getElementById('borrowModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('borrowModal').style.display = "none";
        }

        // Close modal if user clicks outside of the modal content
        window.onclick = function(event) {
            const modal = document.getElementById('borrowModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
