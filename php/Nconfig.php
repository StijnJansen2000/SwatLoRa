<?php
session_start();
include "dbh.php";
require 'library.php';

if (isset($_POST['submit'])){
//    if ($_POST['name'] != "" && $_POST['host'] != "" && $_POST['provider_id'] != "" && $_POST['token'] != "") {

        $name = htmlspecialchars($_POST['name']);
        $host = htmlspecialchars($_POST['host']);
        $provider_id = htmlspecialchars($_POST['provider_id']);
        $token = htmlspecialchars($_POST['token']);

        $query = $conn->prepare('SELECT * FROM `config` WHERE name=:name');
        $query->execute(array(
            ':name' => $name
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";
        if ($query->rowCount() > 0) {
            $_SESSION['config'] = 'Config is set';
            $_SESSION['config_id'] = $result['config_id'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['host'] = $result['host'];
            $_SESSION['provider_id'] = $result['provider_id'];
            $_SESSION['token'] = $result['token'];

            header("Location: ../?page=config");

        } elseif ($query->rowCount() <= 0) {

            if (existCatalog($host, $provider_id, $token) >= 1) {
                $query1 = $conn->prepare('INSERT INTO config SET name=:name, host=:host, provider=:id, token=:token');
                $query1->execute(array(
                    ':name' => $name,
                    ':host' => $host,
                    ':id' => $provider_id,
                    ':token' => $token
                ));

                $_SESSION['config'] = 'Config is set';
                $_SESSION['config_id'] = MYSQLI_AUTO_INCREMENT_FLAG;
                $_SESSION['name'] = $name;
                $_SESSION['host'] = $host;
                $_SESSION['provider_id'] = $provider_id;
                $_SESSION['token'] = $token;


                $getID = $conn->prepare('SELECT * FROM config ORDER BY config_id DESC LIMIT 1');
                $getID->execute(array(
                   ':conf'=> $_SESSION['config_id']
                ));
                $getID = $getID->fetch();
                $confID = $getID['config_id'];

                $query2 = $conn->prepare('INSERT INTO colors SET config_id=:config_id');
                $query2->execute(array(
                    ':config_id' => $confID
                ));
                header("Location: ../?page=config");
            } else {
                $_SESSION['config'] = "Config is incorrect";
                header("Location: ../?page=config");
            }

        }
}
