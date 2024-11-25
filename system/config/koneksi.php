<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_sampah');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
