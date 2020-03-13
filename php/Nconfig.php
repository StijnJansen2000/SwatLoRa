<?php
session_start();
include "dbh.php";

if (isset($_POST['submit'])){

    $name = htmlspecialchars($_POST['name']);
    $host = htmlspecialchars($_POST['host']);
    $provider_id = htmlspecialchars($_POST['provider_id']);
    $token = htmlspecialchars($_POST['token']);

    $query = $conn->prepare('SELECT * FROM `config` WHERE name=:name');
    $query->execute(array(
        ':name' => $name
    ));
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($query->rowCount() > 0) {
        $_SESSION['config'] = 'Config is set';
        $_SESSION['config_id'] = $result['config_id'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['host'] = $result['host'];
        $_SESSION['provider_id'] = $result['provider_id'];
        $_SESSION['token'] = $result['token'];

        header("Location: ../?page=config");

    } elseif($query->rowCount() <= 0){
        $query1 = $conn->prepare('INSERT INTO config SET name=:name, host=:host, provider=:id, token=:token');
        $query1->execute(array(
            ':name' => $name,
            ':host' => $host,
            ':id' => $provider_id,
            ':token' => $token
        ));

        $_SESSION['config'] = 'Config is set';
        $_SESSION['config_id'] = $result['config_id'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['host'] = $result['host'];
        $_SESSION['provider_id'] = $result['provider_id'];
        $_SESSION['token'] = $result['token'];

        header("Location: ../?page=config");

    } else {
        $_SESSION['config'] = "Config is incorrect";
        header("Location: ../?page=config");
    }

}
