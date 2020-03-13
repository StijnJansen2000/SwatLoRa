<?php
session_start();
include 'dbh.php';

if (isset($_POST['submit'])) {

    $id = $_POST['gateway_id'];
    $long = htmlspecialchars($_POST['longitude']);
    $lat = htmlspecialchars($_POST['latitude']);
    $desc = htmlspecialchars($_POST['description']);

    $query = $conn->prepare("UPDATE gateway SET longitude=:longi, latitude=:lati, description=:description WHERE gateway_id=:id");
    $query->execute(array(
        ':longi' => $long,
        ':lati' => $lat,
        ':description' => $desc,
        ':id' => $id
    ));

    header("Location: ../?page=gateway");

}