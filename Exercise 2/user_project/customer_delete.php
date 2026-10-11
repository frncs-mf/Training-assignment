<?php
include 'connect.php';

$id = (int)($_REQUEST['id'] ?? 0);

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM payment
            WHERE customer_serial='$id'";
    q($sql);
    $sql = "DELETE FROM customer
            WHERE customer_serial='$id'";
    q($sql);
    header('Location: index.php');
    exit;
}

$sql = "SELECT *
        FROM customer
        WHERE customer_serial='$id'";
$row = mysqli_fetch_assoc(q($sql));
?>
<html>
<head><title>Delete Customer</title></head>
<body>
<h2>Delete this customer?</h2>
<p>Name: <?= h($row['first_name']) ?> <?= h($row['last_name']) ?></p>
<p>Address: <?= h($row['street_address']) ?></p>
<p>City: <?= h($row['city']) ?></p>
<p>Phone: <?= h($row['phone']) ?></p>
<form method="post">
<input type="hidden" name="id" value="<?= $id ?>">
<input type="submit" name="confirm" value="Confirm Delete">
<a href="index.php">Cancel</a>
</form>
</body>
</html>
