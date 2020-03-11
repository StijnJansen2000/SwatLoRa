<?php
session_start();
include "dbh.php";

if (isset($_POST['submit'])) {

    $name = htmlspecialchars($_POST['name']);

    $query = $conn->prepare('SELECT * FROM `config` WHERE name=:name');
    $query->execute(array(
        ':name' => $name
    ));
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $_SESSION['config'] = "Config is set";
    $_SESSION['name'] = $result['name'];
    $_SESSION['host'] = $result['host'];
    $_SESSION['provider_id'] = $result['provider_id'];
    $_SESSION['token'] = $result['token'];

    header("Location: ../?page=config");

}
