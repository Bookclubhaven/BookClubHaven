<?php
// Start the session
session_start();

// Database connection
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "bookclub"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password
    $stmt = $conn->prepare("UPDATE register SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $hashedPassword, $username);
    
    if ($stmt->execute()) {
        $successMessage = "Your password has been successfully reset!";
    } else {
        $error = "Failed to reset password. Please try again.";
    }

    $stmt->close();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures the footer stays at the bottom */
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 200px auto; /* Center the form vertically */
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1; /* Allows the container to grow */
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"],
        .back-button {
            width: 100%;
            padding: 10px;
            background-color: #3ba03b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        .back-button:hover {
            background-color: #2a8a2a;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }

        footer {
            background: linear-gradient(to right, #214e5e, #3ba03b); /* Gradient background */
            color: white;
            text-align: center;
            padding: 20px 0; /* Increased padding */
            margin-top: auto; /* Pushes the footer to the bottom */
        }

        footer p {
            margin: 0;
        }

        footer a {
            color: white; /* Link color */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s; /* Transition for hover effect */
        }

        footer a:hover {
            color: #f4f4f4; /* Lighten on hover */
        }

        /* Styling for the Back to Login button */
        .back-button {
            position: absolute; /* Use absolute positioning */
            top: 20px; /* Distance from the top */
            left: 20px; /* Distance from the left */
            width: auto; /* Auto width for the button */
            padding: 10px 20px; /* Adjust padding */
            background-color: #3ba03b; /* Same color as the submit button */
            border: none; /* No border */
            color: white; /* White text */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
        }

        .back-button:hover {
            background-color: #2a8a2a; /* Darker green on hover */
        }
    </style>
</head>
<body>

    <button class="back-button" onclick="window.location.href='login.php'">Back to Login</button>

    <div class="container">
        <h2>Reset Password</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($successMessage)): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <p>Please enter your username and new password:</p>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Enter your username" required>
            <input type="password" name="new_password" placeholder="Enter your new password" required>
            <input type="submit" value="Reset Password">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Our BookClub. All rights reserved.</p>
        <p><a href="privacy_policy.php">Privacy Policy</a> | <a href="terms_of_service.php">Terms of Service</a></p>
    </footer>

</body>
</html>
