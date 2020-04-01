<?php
session_start();
include 'dbh.php';

$dateFrom = $_POST['dateFrom'];
$dateFromPart = date('d/m/Y', strtotime($dateFrom));
$from = $dateFromPart . "T" . $_POST['timeFrom'] . ":00";

$dateTo = $_POST['dateTo'];
$dateToPart = date('d/m/Y', strtotime($dateTo));
$to = $dateToPart . "T" . $_POST['timeTo'] . ":00";

$id = $_POST['dataId'];


if (isset($_POST['gps'])) {
    $gps = $_POST['gps'];
    $rssi = $_POST['rssi'];
    $snr = $_POST['snr'];
    $long = $_POST['longitude'];
    $lat = $_POST['latitude'];


    $query = $conn->prepare("UPDATE data SET gpsquality=:gps, rssi=:rssi, snr=:snr, longitude=:long,  latitude=:lat, dateFrom=:dateFrom, dateTo=:dateTo WHERE data_id=:id");
    $query->execute(array(
        ':gps'=>$gps,
        ':rssi'=>$rssi,
        ':snr'=>$snr,
        ':long' => $long,
        ':lat' => $lat,
        ':dateFrom'=>$from,
        ':dateTo'=>$to,
        ':id' =>$id
    ));

} else {
    $query = $conn->prepare("UPDATE data SET oneValue=:oneValue, dateFrom=:dateFrom, dateTo=:dateTo WHERE data_id=:id");
    $query->execute(array(
        ':oneValue'=>$_POST['sensor'],
        ':dateFrom'=>$from,
        ':dateTo'=>$to,
        ':id' =>$id
    ));

}

    header("Location: ../?page=data");