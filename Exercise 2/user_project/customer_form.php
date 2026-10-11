<?php
include 'connect.php';

$id = (int)($_REQUEST['id'] ?? 0);
$first = $last = $street = $city = $phone = '';

if ($_POST) {
    $first = clean($_POST['first_name']);
    $last = clean($_POST['last_name']);
    $street = clean($_POST['street_address']);
    $city = clean($_POST['city']);
    $phone = clean($_POST['phone']);
    $set = "first_name='$first', last_name='$last', street_address='$street', city='$city', phone='$phone'";
    if ($id) {
        $sql = "UPDATE customer
                SET $set
                WHERE customer_serial='$id'";
    } else {
        $sql = "INSERT INTO customer
                SET $set";
    }
    q($sql);
    header('Location: index.php');
    exit;
} elseif ($id) {
    $sql = "SELECT *
            FROM customer
            WHERE customer_serial='$id'";
    $row = mysqli_fetch_assoc(q($sql));
    $first = $row['first_name'];
    $last = $row['last_name'];
    $street = $row['street_address'];
    $city = $row['city'];
    $phone = $row['phone'];
}
?>
<html>
<head><title>Customer</title></head>
<body>
<h2><?= $id ? 'Edit' : 'Add' ?> Customer</h2>
<form method="post">
<input type="hidden" name="id" value="<?= $id ?>">
First Name: <input type="text" name="first_name" maxlength="35" value="<?= h($first) ?>"><br><br>
Last Name: <input type="text" name="last_name" maxlength="35" value="<?= h($last) ?>"><br><br>
Street Address: <input type="text" name="street_address" maxlength="60" value="<?= h($street) ?>"><br><br>
City: <input type="text" name="city" maxlength="25" value="<?= h($city) ?>"><br><br>
Phone: <input type="text" name="phone" maxlength="15" value="<?= h($phone) ?>"><br><br>
<input type="submit" value="Save">
<a href="index.php">Cancel</a>
</form>
</body>
</html>
