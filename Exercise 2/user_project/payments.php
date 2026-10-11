<?php
include 'connect.php';

$cid = (int)($_GET['customer_serial'] ?? 0);
$sql = "SELECT *
        FROM customer
        WHERE customer_serial='$cid'";
$cust = mysqli_fetch_assoc(q($sql));

$sort = $_GET['sort'] ?? 'payment_date';
if (!in_array($sort, array('payment_serial', 'customer_serial', 'payment_date', 'payment_amount', 'description'))) {
    $sort = 'payment_date';
}
$dir = (($_GET['dir'] ?? '') == 'desc') ? 'desc' : 'asc';

function th($col, $label) {
    global $sort, $dir, $cid;
    $d = ($sort == $col && $dir == 'asc') ? 'desc' : 'asc';
    return "<th><a href='?customer_serial=$cid&sort=$col&dir=$d'>$label</a></th>";
}

$sql = "SELECT *
        FROM payment
        WHERE customer_serial='$cid'
        ORDER BY $sort $dir";
$result = q($sql);
?>
<html>
<head><title>Payments</title></head>
<body>
<h2>Payments for <?= h($cust['first_name']) ?> <?= h($cust['last_name']) ?></h2>
<a href="index.php"><button>Back</button></a>
<a href="payment_form.php?cid=<?= $cid ?>"><button>Add Payment</button></a>
<br><br>
<table border="1" cellpadding="5">
<tr>
    <?= th('payment_serial', 'Payment Serial') ?>
    <?= th('customer_serial', 'Customer Serial') ?>
    <?= th('payment_date', 'Date') ?>
    <?= th('payment_amount', 'Amount') ?>
    <?= th('description', 'Description') ?>
    <th></th>
</tr>
<?php while ($row = mysqli_fetch_assoc($result)) { $id = $row['payment_serial']; ?>
<tr>
    <td><?= $id ?></td>
    <td><?= $row['customer_serial'] ?></td>
    <td><?= $row['payment_date'] ?></td>
    <td><?= $row['payment_amount'] ?></td>
    <td><?= h($row['description']) ?></td>
    <td>
        <a href="payment_form.php?id=<?= $id ?>"><button>Edit</button></a>
        <a href="payment_delete.php?id=<?= $id ?>"><button>Delete</button></a>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
