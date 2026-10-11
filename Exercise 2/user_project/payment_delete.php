<?php
include 'connect.php';

$id = (int)($_REQUEST['id'] ?? 0);
$sql = "SELECT *
        FROM payment
        WHERE payment_serial='$id'";
$row = mysqli_fetch_assoc(q($sql));
$cid = $row['customer_serial'];

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM payment
            WHERE payment_serial='$id'";
    q($sql);
    header("Location: payments.php?customer_serial=$cid");
    exit;
}
?>
<html>
<head><title>Delete Payment</title></head>
<body>
<h2>Delete this payment?</h2>
<p>Date: <?= $row['payment_date'] ?></p>
<p>Amount: <?= $row['payment_amount'] ?></p>
<p>Description: <?= h($row['description']) ?></p>
<form method="post">
<input type="hidden" name="id" value="<?= $id ?>">
<input type="submit" name="confirm" value="Confirm Delete">
<a href="payments.php?customer_serial=<?= $cid ?>">Cancel</a>
</form>
</body>
</html>
