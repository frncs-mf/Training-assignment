<?php
$conn = mysqli_connect('localhost', 'root', '', 'user_project');
if (!$conn) {
    die('Connect failed: ' . mysqli_connect_error());
}

function q($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('SQL error: ' . mysqli_error($conn));
    }
    return $result;
}

function clean($s) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($s));
}

function h($s) {
    return htmlspecialchars($s);
}
