<?php
//session_start();
require "library.php";


if(isset($_POST['configSettings'])){
    $values = explode(",", $_POST['configSettings']);
    $_SESSION['config'] = SetConfig($values[0], $values[1], $values[2], $values[3]);
}elseif (isset($_POST['name']) && isset($_POST['url']) && isset($_POST['providerID']) && isset($_POST['token'])){
    echo "deze";
    $_SESSION['config'] = SetConfig($_POST['name'], $_POST['url'], $_POST['providerID'], $_POST['token']);

}

header("Location: ../?page=config");
