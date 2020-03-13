<?php
session_start();
include "dbh.php";

if (isset($_POST['submit'])) {

    $name = htmlspecialchars($_POST['configSettings']);

    $query = $conn->prepare('SELECT * FROM `config` WHERE name=:name');
    $query->execute(array(
        ':name' => $name
    ));
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $_SESSION['config'] = "Config is set";
    $_SESSION['config_id'] = $result['config_id'];
    $_SESSION['name'] = $result['name'];
    $_SESSION['host'] = $result['host'];
    $_SESSION['provider_id'] = $result['provider'];
    $_SESSION['token'] = $result['token'];

    header("Location: ../?page=config");
}
