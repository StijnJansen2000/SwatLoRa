<?php
    session_start();
    require 'dbh.php';

    $query = $conn->prepare("SELECT * FROM color WHERE config_id=:conf");
    $query->execute(array(
        ":conf" => $_SESSION['config_id']
    ));
    $query = $query->fetch(PDO::FETCH_ASSOC);

    if ($_POST['lowest'] == ""){
        $lowest = $query['lowest'];
    } else {
        $lowest = substr($_POST['lowest'],1);
    }

    if ($_POST['low'] == ""){
        $low = $query['low'];
    } else {
        $low = substr($_POST['low'],1);
    }

    if ($_POST['medium'] == ""){
        $med = $query['medium'];
    } else {
        $med = substr($_POST['medium'],1);
    }

    if ($_POST['high'] == ""){
        $high = $query['high'];
    } else {
        $high = substr($_POST['high'],1);
    }

    if ($_POST['highest'] == ""){
        $highest = $query['highest'];
    } else {
        $highest = substr($_POST['highest'],1);
    }


    $query = $conn->prepare("UPDATE color SET lowest=:lowest, low=:low, medium=:med, high=:high, highest=:highest WHERE config_id=:conf");
    $query->execute(array(
        ":lowest"=>  $lowest,
        ":low" => $low,
        ":med" => $med,
        ":high"=> $high,
        ":highest" => $highest,
        ":conf"=> $_SESSION['config_id']
    ));

    header("Location: ../?page=map");