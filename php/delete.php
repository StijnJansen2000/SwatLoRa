<?php
session_start();
include 'dbh.php';

if (isset($_POST['deleteGateway'])){
    $id = htmlspecialchars($_POST['gateway_id']);


    $query = $conn->prepare('DELETE FROM gateway WHERE gateway_id=:id');
    $query->execute(array(
        ':id' => $id
    ));

    header("Location: ../?page=gateway");
}