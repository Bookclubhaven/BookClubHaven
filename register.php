<?php
// Start the session
session_start();

// Initialize variables for error messages
$fullnameError = $usernameError = $passwordError = $confirmPasswordError = '';

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
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Simple validation
    if (empty($fullname)) {
        $fullnameError = "Full Name is required!";
    }

    if (empty($username)) {
        $usernameError = "Username is required!";
    }

    if (empty($password)) {
        $passwordError = "Password is required!";
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordError = "Passwords do not match!";
    }

    // If no errors, check if the username already exists
    if (empty($fullnameError) && empty($usernameError) && empty($passwordError) && empty($confirmPasswordError)) {
        // Prepare a SQL statement to check for existing username
        $stmt = $conn->prepare("SELECT * FROM register WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Username already exists
            $usernameError = "Username already exists!";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Prepare an SQL statement to insert new user
            $stmt = $conn->prepare("INSERT INTO register (fullname, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $username, $hashedPassword);

            // Execute the statement and check for success
            if ($stmt->execute()) {
                $successMessage = "Registration successful!"; // Set success message
                echo "<script>alert('$successMessage'); window.location.href='login.php';</script>";
                exit;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            padding: 10px 20px; /* Added padding for better spacing */
            display: flex;
            align-items: center; /* Center align items vertically */
            justify-content: space-between; /* Space between items */
        }

        .header-left {
            display: flex;
            align-items: center; /* Center align items vertically */
        }

        .logo {
            display: flex;
            align-items: center; /* Center align the logo and title vertically */
        }

        .logo img {
            height: 70px; /* Adjust the height as needed */
            margin-right: 10px; /* Space between logo and title */
        }

        .home-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center; /* Center align the icon vertically */
            padding: 10px; /* Padding around the icon */
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-right: 20px; /* Space between home icon and logo */
        }

        .home-link i {
            font-size: 20px; /* Size of the home icon */
        }

        .home-link:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Lighten background on hover */
        }

        .register-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 100px auto; /* Center the form vertically */
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

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #3ba03b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2a8a2a; /* Darker green on hover */
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <header id="home">
        <div class="container">
            <div class="header-left">
                <a href="index.php" class="home-link">
                    <i class="fas fa-home"></i> <!-- Home icon -->
                </a>
                <div class="logo">
                    <img src="llcc_logo.png" alt="Logo"> <!-- Update the path to your logo -->
                    <h2>Lapu Lapu City College</h2>
                </div>
            </div>
        </div>
    </header>

    <div class="register-container">
        <h2>Register</h2>
        <form action="" method="post">
            <input type="text" name="fullname" placeholder="Full Name" required>
            <p class="error"><?php echo $fullnameError; ?></p>
            <input type="text" name="username" placeholder="Username" required>
            <p class="error"><?php echo $usernameError; ?></p>
            <input type="password" name="password" placeholder="Password" required>
            <p class="error"><?php echo $passwordError; ?></p>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <p class="error"><?php echo $confirmPasswordError; ?></p>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
