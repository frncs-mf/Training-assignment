<?php
include 'connect.php';

$sort = $_GET['sort'] ?? 'last_name';
if (!in_array($sort, array('last_name', 'first_name', 'city', 'phone'))) {
    $sort = 'last_name';
}
$dir = (($_GET['dir'] ?? '') == 'desc') ? 'desc' : 'asc';

function th($col, $label) {
    global $sort, $dir;
    $d = ($sort == $col && $dir == 'asc') ? 'desc' : 'asc';
    return "<th><a href='?sort=$col&dir=$d'>$label</a></th>";
}

$sql = "SELECT *
        FROM customer
        ORDER BY $sort $dir";
$result = q($sql);
?>
<html>
<head><title>Customers</title></head>
<body>
<h2>Customers</h2>
<a href="customer_form.php"><button>Add Record</button></a>
<br><br>
<table border="1" cellpadding="5">
<tr>
    <?= th('last_name', 'Last Name') ?>
    <?= th('first_name', 'First Name') ?>
    <?= th('city', 'City') ?>
    <?= th('phone', 'Phone') ?>
    <th></th>
</tr>
<?php while ($row = mysqli_fetch_assoc($result)) { $id = $row['customer_serial']; ?>
<tr>
    <td><?= h($row['last_name']) ?></td>
    <td><?= h($row['first_name']) ?></td>
    <td><?= h($row['city']) ?></td>
    <td><?= h($row['phone']) ?></td>
    <td>
        <a href="customer_form.php?id=<?= $id ?>"><button>Edit</button></a>
        <a href="customer_delete.php?id=<?= $id ?>"><button>Delete</button></a>
        <a href="payments.php?customer_serial=<?= $id ?>"><button>Payments</button></a>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
