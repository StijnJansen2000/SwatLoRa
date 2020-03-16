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



$GPS = (GetData_Date($_POST['gps'], $from, $to)['observations'][0]['value']);
$time = (GetData_Date($_POST['gps'], $from, $to)['observations'][0]['timestamp']);
$RSSI = (GetData_Date($_POST['rssi'], $from, $to)['observations'][0]['value']);
$SNR = (GetData_Date($_POST['snr'], $from, $to)['observations'][0]['value']);
$long = (GetData_Date($_POST['longitude'], $from, $to)['observations'][0]['value']);
$lat = (GetData_Date($_POST['latitude'], $from, $to)['observations'][0]['value']);


$query1 = $conn->prepare("INSERT INTO data SET data_id=:did, longitude=:long, latitude=:lati, gpsquality=:gps, rssi=:rssi, snr=:snr, dateFrom=:datefrom, dateTo=:dateto, component=:component ");
$query1->execute(array(
    ":did"=> null,
    ":long" => $long,
    ":lati" => $lat,
    ":gps" => $GPS,
    ":rssi" => $RSSI,
    ":snr" => $SNR,
    ":datefrom" => $from,
    ":dateto" => $to,
    ":component" => $component
));

header("Location: ../?page=data");


