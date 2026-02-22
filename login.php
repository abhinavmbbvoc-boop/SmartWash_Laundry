<?php
session_start();

$conn = new mysqli("localhost", "root", "", "laundryaa");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST["email"];
$password = $_POST["password"];

// Find user by email
$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user["password"])) {
        $_SESSION["user"] = $user["name"];

        echo "<script>alert('Login Successful'); window.location='order.html';</script>";
    } else {
        echo "Wrong password";
    }
} else {
    echo "User not found";
}
?>