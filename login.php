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
    $password = $_POST['password'];

    // Prepare an SQL statement
    $stmt = $conn->prepare("SELECT password FROM register WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Set session variable and redirect to books page
            $_SESSION['loggedin'] = true;
            header('Location: books.php');
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
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
    <title>Login</title>
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
            margin: 0 auto; /* Center the logo and title horizontally */
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

        .register-link {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            background-color: #3ba03b; /* Background color for the button */
            transition: background-color 0.3s;
            position: absolute; /* Position the button absolutely */
            right: 20px; /* Adjust distance from the right */
            top: 20px; /* Adjust distance from the top */
        }

        .register-link:hover {
            background-color: #2a8a2a; /* Darker green on hover */
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            margin-bottom: 10px;    
        }

        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 100px auto; /* Center the form vertically */
            text-align: center; /* Center text within the container */
        }

        .login-container img {
            width: 100px; /* Adjust the width of the logo as needed */
            margin-bottom: 20px; /* Space below the logo */
        }

        h2 {
            margin-bottom: 20px;
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
            background-color: #3ba03b;
        }

        .error {
            color: red;
            text-align: center;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #214e5e;
            text-decoration: none; 
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
                    <h2>Book Club Haven</h2>
                </div>
            </div>
            <a href="register.php" class="register-link">Register</a> <!-- Register link -->
        </div>
    </header>

    
    <div class="login-container">
        <img src="haven.png" alt="Login Logo"> <!-- Update the path to your login logo -->
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <div class="forgot-password">
            <a href="forgot_password.php">Forgot Password?</a> <!-- Link to forgot password page -->
        </div>
    </div>

    
</body>
</html>
