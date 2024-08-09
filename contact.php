<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
    height: 100%; /* Set full height for the body */
    margin: 0; /* Remove default margin */
}

.wrapper {
    display: flex;
    flex-direction: column; /* Stack header, main, and footer vertically */
    min-height: 100vh; /* Full viewport height */
}

body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
    background-color: #f4f4f4;
}

header {
    background: #007bff;
    color: #fff;
    padding: 20px 0;
    display: flex; /* Use flexbox for alignment */
    justify-content: space-between; /* Space between elements */
    align-items: center; /* Center items vertically */
}

.container {
    width: 50%;
    margin: auto;
    display: flex; /* Make container a flexbox */
    justify-content: space-between; /* Space between content */
    align-items: center; /* Align items vertically */
}

h1 {
    margin: 5px; /* Remove default margin */
}

nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0; /* Remove default margin */
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.logo {
    max-width: 150px; /* Adjust size as needed */
    height: auto; /* Maintain aspect ratio */
}

main {
    padding: 20px;
    background: #fff;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    flex: 1; /* Allow main to grow and push footer down */  
    margin-top: 10%;
}
.gallery {
    display: flex; /* Use flexbox for layout */
    flex-wrap: wrap; /* Wrap images to next line */
    justify-content: space-between; /* Space images evenly */
}

.library-image {
    max-width: 48%; /* Adjust size as needed (e.g., 48% for two images per row) */
    margin: 10px 0; /* Add margin between images */
    border-radius: 8px; /* Add rounded corners */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional shadow effect */
}


h2 {
    color: #007bff;
}

.card {
    background: #e9ecef;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.card h3 {
    color: #333;
}

.card a {
    display: inline-block;
    margin-top: 10px;
    background: #007bff;
    color: #fff;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
}

.card a:hover {
    background: #0056b3;
}

footer {
    background: #007bff;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    margin-top: 9%;
}

    </style>
    <title>Contact Us</title>
</head>
<body>
    <header>
        <h1>Contact Us</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Get in Touch</h2>
        <p>This section can contain a contact form or your contact details.</p>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Website</p>
    </footer>
</body>
</html>
