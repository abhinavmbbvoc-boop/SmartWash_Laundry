<?php
session_start();

$conn = new mysqli("localhost", "root", "", "laundryaa");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check login
if (!isset($_SESSION["user"])) {
    header("Location: home.html");
    exit();
}

// Safely get form data
$user = $_SESSION["user"];
$cart = $_POST["cartData"] ?? '';
$phone = $_POST["phone"] ?? '';
$address = $_POST["address"] ?? '';

// Validation
if (empty($cart)) {
    echo "<script>alert('Cart is empty!'); window.location='order.php';</script>";
    exit();
}

if (empty($phone) || empty($address)) {
    echo "<script>alert('Please fill all fields!'); window.location='order.php';</script>";
    exit();
}

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (user_name, cart_items, phone, address) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $user, $cart, $phone, $address);

if ($stmt->execute()) {
    echo "<script>
        alert('✅ Order placed successfully!');
        window.location='myorders.php';
    </script>";
    exit();
} else {
    echo "Error saving order: " . $stmt->error;
}
?>