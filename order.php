<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Order</title>
</head>
<body>

<h2>Welcome <?php echo $_SESSION["user"]; ?></h2>

<form action="order_process.php" method="POST">
    <input type="hidden" name="cartData" value="Test Item x1">
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="text" name="address" placeholder="Address" required>
    <button type="submit">Test Order</button>
</form>

</body>
</html>