<?php
// assigns database login details to variables $servername, $username, $password and $dbname
include_once __DIR__ . '/db_details.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>