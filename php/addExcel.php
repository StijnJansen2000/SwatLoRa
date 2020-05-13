<?php
session_start();
include 'dbh.php';
require '../vendor/autoload.php';
require 'library.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);

    if ('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else if ('xlsx' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    } else if ('xls' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    } else {
        echo "else";
    }

    $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    $datefrom = $sheetData[sizeof($sheetData) - 1][5];

    $string = '{"sensors": [{"sensor": "LoraCoverageVIPAC01S01","observations": [';
    for ($i = 1; $i < sizeof($sheetData); $i++) {
        if ($sheetData[$i][0] != "") {
            $string .= '{"value": "' . $sheetData[$i][1] . '", "timestamp":"' . $sheetData[$i][5] . '"},';
        }
    }
    $string = substr($string, 0, -1);

    $string .= ']},{"sensor": "LoraCoverageVIPAC01S02","observations":[';
    for ($i = 1; $i < sizeof($sheetData); $i++) {
        if ($sheetData[$i][0] != "") {
            $string .= '{"value": "' . $sheetData[$i][2] . '", "timestamp":"' . $sheetData[$i][5] . '"},';
        }
    }
    $string = substr($string, 0, -1);

    $string .= ']},{"sensor": "LoraCoverageVIPAC01S03","observations":[';
    for ($i = 1; $i < sizeof($sheetData); $i++) {
        if ($sheetData[$i][0] != "") {
            $string .= '{"value": "' . $sheetData[$i][6] . '", "timestamp":"' . $sheetData[$i][5] . '"},';
        }
    }
    $string = substr($string, 0, -1);

    $string .= ']},{"sensor": "LoraCoverageVIPAC01S04","observations":[';
    for ($i = 1; $i < sizeof($sheetData); $i++) {
        if ($sheetData[$i][0] != "") {
            $string .= '{"value": "' . $sheetData[$i][7] . '", "timestamp":"' . $sheetData[$i][5] . '"},';
        }
    }
    $string = substr($string, 0, -1);

    $string .= ']}]}';

    $checkNames = $conn->prepare("SELECT dataName FROM data");
    $checkNames->execute();
    $result = $checkNames->fetchAll(PDO::FETCH_ASSOC);
    $resArr = [];
    for ($i = 0; $i < sizeof($result); $i++){
        array_push($resArr, $result[$i]['dataName']);
    }

    if (in_array($_POST['dataName'], $resArr)){
        $_SESSION['warning'] = "The dataname " . $_POST['dataName'] . " already exists";
        header("Location: ../?page=data");
    } else {
        if (writeDate($string) == "Component successfully changed"){
            $query = $conn->prepare("INSERT INTO data SET data_id=:did, dataName=:dataName, longitude=:long, latitude=:lati, gpsquality=:gps, rssi=:rssi, snr=:snr, oneValue=:oneValue, dateFrom=:datefrom, dateTo=:dateto, component=:component, gateway_id=:gateway");
            $query->execute(array(
                ":did" => null,
                ":dataName" => $_POST['dataName'],
                ":long" => 'LoraCoverageVIPAC01S04',
                ":lati" => 'LoraCoverageVIPAC01S03',
                ":gps" => 'LoraCoverageVIPAC01S05',
                ":rssi" => 'LoraCoverageVIPAC01S01',
                ":snr" => 'LoraCoverageVIPAC01S02',
                ":oneValue" => "",
                ":datefrom" => $datefrom,
                ":dateto" => $sheetData[1][5],
                ":component" => $_POST['componentName'],
                ":gateway" => $_POST['gateway']
            ));
            header("Location: ../?page=data");
        }
    }

} else {
    echo "not set";
}
