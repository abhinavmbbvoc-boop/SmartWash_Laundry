<?php
session_start();
$conn = new mysqli("localhost", "root", "", "laundryaa");

if (!isset($_SESSION["user"])) {
    header("Location: newlongin.html");
    exit();
}

$user = $_SESSION["user"];
$result = $conn->query("SELECT * FROM orders WHERE user_name='$user' ORDER BY id DESC");
?>

<h2>My Orders</h2>
<a href="order.html">New Order</a> | 
<a href="logout.php">Logout</a>
<hr>

<?php while($row = $result->fetch_assoc()): ?>
<div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
    <b>Order ID:</b> <?= $row['id'] ?><br>
    <b>Items:</b> <?= $row['cart_items'] ?><br>
    <b>Phone:</b> <?= $row['phone'] ?><br>
    <b>Address:</b> <?= $row['address'] ?><br>
    <b>Date:</b> <?= $row['created_at'] ?>
</div>
<?php endwhile; ?>  