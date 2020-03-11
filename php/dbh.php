<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swatlora";

$conn = NULL;

try {
    $conn = new PDO("mysql:host=$servername;dbname=swatlora", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
