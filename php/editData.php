<?php
session_start();
include 'dbh.php';


if (isset($_POST['gps'])) {
    $id = $_POST['dataId'];

    $gps = $_POST['gps'];
    $rssi = $_POST['rssi'];
    $snr = $_POST['snr'];
    $long = $_POST['longitude'];
    $lat = $_POST['latitude'];
    $dateFrom = $_POST['dateFrom'];
    $dateFromPart = date('d/m/Y', strtotime($dateFrom));
    $from = $dateFromPart . "T" . $_POST['timeFrom'] . ":00";

    $dateTo = $_POST['dateTo'];
    $dateToPart = date('d/m/Y', strtotime($dateTo));
    $to = $dateToPart . "T" . $_POST['timeTo'] . ":00";

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

    header("Location: ../?page=data");

}