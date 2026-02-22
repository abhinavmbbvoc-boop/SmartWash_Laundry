<?php
$conn = new mysqli("localhost", "root", "", "laundryaa");
$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>

<h1>All Orders (Admin)</h1>
<hr>

<?php while($row = $result->fetch_assoc()): ?>
<div style="border:1px solid #000; padding:10px; margin:10px;">
    <b>User:</b> <?= $row['user_name'] ?><br>
    <b>Items:</b> <?= $row['cart_items'] ?><br>
    <b>Phone:</b> <?= $row['phone'] ?><br>
    <b>Address:</b> <?= $row['address'] ?><br>
    <b>Date:</b> <?= $row['created_at'] ?>
</div>
<?php endwhile; ?>