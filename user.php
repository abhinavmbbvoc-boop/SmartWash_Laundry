<?php
// Database configuration
$servername = "localhost"; // Change if needed
$username = "root";        // Change to your database username
$password = "";            // Change to your database password
$database = "laundryaa";   // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $mobile = sanitizeInput($_POST["mobile"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Basic Validation
    if (empty($name) || empty($mobile) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
    } elseif (!preg_match("/^[a-zA-Z ]{3,}$/", $name)) {
        echo "Name must contain only letters and be at least 3 characters.";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {
        echo "Mobile number must be exactly 10 digits.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif (strlen($password) < 6) {
        echo "Password must be at least 6 characters.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Check if email or mobile already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR mobile = ?");
        $stmt->bind_param("ss", $email, $mobile);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Email or Mobile already registered.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (name, mobile, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $mobile, $email, $hashedPassword);

            if ($stmt->execute()) {
                echo "Registration successful! <a href='signin.html'>Login here</a>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
