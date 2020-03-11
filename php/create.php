<?php

$server = "localhost";
$user = "root";
$password = "";

// Create connection
$conn = new mysqli($server, $user, $password);

echo "Name of the gateway: " . $_POST['gateway'] . "<br>";
echo "Location of the gateway: " . $_POST['longitude'] . "<br>";
echo "latitude of the gateway: " . $_POST['latitude'] . "<br>";
echo "Description of the gateway: " . $_POST['description'] . "<br>";
echo "Provider of the gateway: " . $_POST['provider'] . "<br>";

    $gateway = htmlspecialchars($_POST['gateway']);
    $lat = htmlspecialchars($_POST['latitude']);
    $long = htmlspecialchars($_POST['longitude']);
    $desc = htmlspecialchars($_POST['description']);
    $provider = htmlspecialchars($_POST['gateway']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        if ($conn->select_db('swatlora') === true) {
//            $sql = "INSERT INTO 'gateway'('name', 'longitude', 'latitude', 'description') VALUES ('$gateway', '$long', '$lat', '$desc')";

            $sql = "INSERT INTO gateway (name, longitude, latitude, description) VALUES ('$gateway', '$long', '$lat', '$desc')";
            echo "<br>" . $sql . "<br>";
            if ($conn->query($sql) === TRUE) {
                echo "Database filled successfully, table created and items inserted";
            } else {
                echo "Error filling the database: " . $conn->error;
            }
        }
    }