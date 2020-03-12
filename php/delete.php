<?php
session_start();
include 'dbh.php';

if (isset($_POST['deleteGateway'])){
    $gateway = htmlspecialchars($_POST['gateway']);
    $sql = "DELETE FROM MyGuests WHERE name=:name";

    $query = $conn->prepare('DELETE FROM `gateway` WHERE name=:name');
    $query->execute(array(
        ':name' => $gateway
    ));

    header("Location: ../?page=gateway");
}