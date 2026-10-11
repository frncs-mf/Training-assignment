<?php

function clean($text)
{
    return htmlspecialchars(trim($text));
}

function asciiTotal($text)
{
    $total = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        $total += ord($text[$i]);
    }
    return $total;
}

$firstNames = [];
$lastNames = [];
$error = '';
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 0; $i < 10; $i++) {
        $firstNames[] = trim($_POST['first'][$i] ?? '');
        $lastNames[] = trim($_POST['last'][$i] ?? '');
    }

    if (in_array('', $firstNames, true) || in_array('', $lastNames, true)) {
        $error = 'Please enter all 10 first and last names.';
    } else {
        shuffle($firstNames);
        shuffle($lastNames);
        $submitted = true;
    }
}
?>
<html>
<head><title>Name Mixer</title></head>
<body>
<h2>Enter 10 Names</h2>
<?php if ($error !== '') { ?>
    <p style="color: red;"><?= $error ?></p>
<?php } ?>
<form method="post">
    <table>
        <tr><th>First Name</th><th>Last Name</th></tr>
        <?php for ($i = 0; $i < 10; $i++) { ?>
            <tr>
                <td><input type="text" name="first[]" value="<?= clean($_POST['first'][$i] ?? '') ?>"></td>
                <td><input type="text" name="last[]" value="<?= clean($_POST['last'][$i] ?? '') ?>"></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <input type="submit" value="Submit">
</form>

<?php if ($submitted) { ?>
    <h2>Random Names</h2>
    <table border="1" cellpadding="5">
        <?php for ($i = 0; $i < 10; $i++) { ?>
            <tr>
                <td><?= clean($firstNames[$i]) ?></td>
                <td><?= clean($lastNames[$i]) ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Names in Alphabetical Order</h2>
    <table border="1" cellpadding="5">
        <?php for ($i = 0; $i < 10; $i++) { ?>
            <?php if (strcasecmp($firstNames[$i], $lastNames[$i]) <= 0) { ?>
                <tr>
                    <td><?= clean($firstNames[$i]) ?></td>
                    <td><?= clean($lastNames[$i]) ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>

    <h2>Last Names with ASCII Totals</h2>
    <table border="1" cellpadding="5">
        <?php foreach ($lastNames as $last) { ?>
            <tr>
                <td><?= clean($last) ?></td>
                <td><?= asciiTotal($last) ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
</body>
</html>
