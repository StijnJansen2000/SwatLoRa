<?php
session_start();
include 'dbh.php';

$name = htmlspecialchars($_POST['name']);
$lat = htmlspecialchars($_POST['latitude']);
$long = htmlspecialchars($_POST['longitude']);
$desc = htmlspecialchars($_POST['description']);
$config_id = htmlspecialchars($_POST['config_id']);


function convertToBCD($val){
    if (strpos($val, '.') !== false) {
        $vars = explode(".",$val);
    } elseif (strpos($val, ',')!== false){
        $vars = explode(".",$val);
    }

    $deg = $vars[0];
    $tempma = "0.".$vars[1];

    $tempma = $tempma * 3600;
    $min = floor($tempma / 60);
    $sec = $tempma - ($min*60);

    $bcd = $deg . "°" . $min . "," . abs($sec);
    echo $bcd;
    return $bcd;
}

//        echo "<br>";
//        convertToBCD($long);
//        echo "<br>";
//        convertToBCD($lat);


$query = $conn->prepare('SELECT * FROM `gateway` WHERE name=:name');
$query->execute(array(
    ':name' => $name
));
//$result = $query->fetch(PDO::FETCH_ASSOC);

if ($query->rowCount() == 0) {

    $query1 = $conn->prepare("INSERT INTO gateway SET name=:name, longitude=:long, latitude=:lati, description=:description, config_id=:id");
    $query1->execute(array(
        ":name" => $name,
        ":long" => $long,
        ":lati" => $lat,
        ":description" => $desc,
        ":id" => $config_id
    ));

    header("Location: ../?page=gateway");
} else{

    $_SESSION['message'] = "Gateway name already exist.";

    header("Location: ../?page=create");
}