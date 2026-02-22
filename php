<?php
// Database connection parameters
$servername = "localhost"; // Change to your database host
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "laundryaa_db"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO users (name, mobile, email, password) VALUES ('$name', '$mobile', '$email', '$password')";

    // Check if query was successful
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
