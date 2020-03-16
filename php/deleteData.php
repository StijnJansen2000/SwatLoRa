<?php
session_start();
include 'dbh.php';

if (isset($_POST['deleteGateway'])){
    $gateway = htmlspecialchars($_POST['gateway']);

    $query = $conn->prepare('DELETE FROM data WHERE data_id=:id');
    $query->execute(array(
        ':id' => $gateway
    ));

    header("Location: ../?page=gateway");
}
