<?php
session_start();
include 'dbh.php';
require 'library.php';

$component = $_POST['componentName'];
$gateway = $_POST['gateway'];
$dataName = str_replace(' ', '',$_POST['dataName']);

echo $dataName;
$dateFrom = $_POST['dateFrom'];
$dateFrom = str_replace("/", "-", $dateFrom);
$dateFromPart = date('d/m/Y', strtotime($dateFrom));
$from = $dateFromPart . "T" . $_POST['timeFrom'] . ":00";

$dateTo = $_POST['dateTo'];
$dateTo = str_replace("/", "-", $dateTo);
$dateToPart = date('d/m/Y', strtotime($dateTo));
$to = $dateToPart . "T" . $_POST['timeTo'] . ":00";

if (isset($_POST['oneValue'])){
    $query1 = $conn->prepare("INSERT INTO data SET data_id=:did, dataName=:dataName, oneValue=:oneValue, dateFrom=:datefrom, dateTo=:dateto, component=:component, gateway_id=:gateway");
    $query1->execute(array(
        ":did"=> null,
        ":dataName" => $dataName,
        ":oneValue"=> $_POST['sensor'],
        ":datefrom" => $from,
        ":dateto" => $to,
        ":component" => $component,
        ":gateway" => $gateway
    ));
} else {
    $GPS = $_POST['gps'];
    $RSSI = $_POST['rssi'];
    $SNR = $_POST['snr'];
    $lat = $_POST['latitude'];
    $long = $_POST['longitude'];


    $query1 = $conn->prepare("INSERT INTO data SET data_id=:did, dataName=:dataName, longitude=:long, latitude=:lati, gpsquality=:gps, rssi=:rssi, snr=:snr, oneValue=:oneValue, dateFrom=:datefrom, dateTo=:dateto, component=:component, gateway_id=:gateway");
    $query1->execute(array(
        ":did"=> null,
        ":dataName" => $dataName,
        ":long" => $long,
        ":lati" => $lat,
        ":gps" => $GPS,
        ":rssi" => $RSSI,
        ":snr" => $SNR,
        ":oneValue" => "",
        ":datefrom" => $from,
        ":dateto" => $to,
        ":component" => $component,
        ":gateway" => $gateway
    ));
}

header("Location: ../?page=data");


