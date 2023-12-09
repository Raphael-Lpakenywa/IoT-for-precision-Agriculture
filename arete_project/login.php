<?php
// Replace these values with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aretedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get values from the form
$username = $_POST['username'];
$password = $_POST['password'];

// SQL query to check if the provided username exists in the database
$userCheckQuery = "SELECT * FROM login WHERE username = '$username'";
$userCheckResult = $conn->query($userCheckQuery);

if ($userCheckResult->num_rows > 0) {
    
    // The username exists, now check the password
    $passwordCheckQuery = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $passwordCheckResult = $conn->query($passwordCheckQuery);

    if ($passwordCheckResult->num_rows > 0) {
        // Redirect to index.php upon successful login
        header("Location: index.php");
        exit();
    } else {
        // Incorrect password, display message and clear password field
        echo "<p>Password incorrect. Please try again.</p>";
        echo "<script>document.getElementById('password').value = '';</script>";
    }
} else {
    // Username doesn't exist, display message and clear both fields
    echo "<p>Username does not exist. Please try again.</p>";
    echo "<script>document.getElementById('username').value = '';</script>";
    echo "<script>document.getElementById('password').value = '';</script>";
}

// Close the database connection
$conn->close();
?>
