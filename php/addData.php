<?php
session_start();
include 'dbh.php';
require 'library.php';

$component = $_POST['componentName'];
$gateway = $_POST['gateway'];

$dateFrom = $_POST['dateFrom'];
$dateFromPart = date('d/m/Y', strtotime($dateFrom));

$from = $dateFromPart . "T" . $_POST['timeFrom'] . ":00";

$dateTo = $_POST['dateTo'];
$dateToPart = date('d/m/Y', strtotime($dateTo));
$to = $dateToPart . "T" . $_POST['timeTo'] . ":00";

print_r($_POST);

$GPS = $_POST['gps'];
$RSSI = $_POST['rssi'];
$SNR = $_POST['snr'];
$long = $_POST['longitude'];
$lat = $_POST['latitude'];


$query1 = $conn->prepare("INSERT INTO data SET data_id=:did, longitude=:long, latitude=:lati, gpsquality=:gps, rssi=:rssi, snr=:snr, dateFrom=:datefrom, dateTo=:dateto, component=:component, gateway_id=:gateway");
$query1->execute(array(
    ":did"=> null,
    ":long" => $long,
    ":lati" => $lat,
    ":gps" => $GPS,
    ":rssi" => $RSSI,
    ":snr" => $SNR,
    ":datefrom" => $from,
    ":dateto" => $to,
    ":component" => $component,
    ":gateway" => $gateway
));

//header("Location: ../?page=data");


