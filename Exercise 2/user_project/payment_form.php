<?php
include 'connect.php';

$id = (int)($_REQUEST['id'] ?? 0);
$cid = (int)($_REQUEST['cid'] ?? 0);
$date = date('Y-m-d');
$amount = '';
$desc = '';

if ($_POST) {
    $date = clean($_POST['payment_date']);
    $amount = (float)$_POST['payment_amount'];
    $desc = clean($_POST['description']);
    $set = "payment_date='$date', payment_amount=$amount, description='$desc'";
    if ($id) {
        $sql = "UPDATE payment
                SET $set
                WHERE payment_serial='$id'";
    } else {
        $sql = "INSERT INTO payment
                SET customer_serial='$cid', $set";
    }
    q($sql);
    header("Location: payments.php?customer_serial=$cid");
    exit;
} elseif ($id) {
    $sql = "SELECT *
            FROM payment
            WHERE payment_serial='$id'";
    $row = mysqli_fetch_assoc(q($sql));
    $cid = $row['customer_serial'];
    $date = $row['payment_date'];
    $amount = $row['payment_amount'];
    $desc = $row['description'];
}
?>
<html>
<head><title>Payment</title></head>
<body>
<h2><?= $id ? 'Edit' : 'Add' ?> Payment</h2>
<form method="post">
<input type="hidden" name="id" value="<?= $id ?>">
<input type="hidden" name="cid" value="<?= $cid ?>">
Date: <input type="date" name="payment_date" value="<?= $date ?>"><br><br>
Amount: <input type="number" step="0.01" name="payment_amount" value="<?= $amount ?>"><br><br>
Description: <input type="text" name="description" maxlength="250" size="50" value="<?= h($desc) ?>"><br><br>
<input type="submit" value="Save">
<a href="payments.php?customer_serial=<?= $cid ?>">Cancel</a>
</form>
</body>
</html>
