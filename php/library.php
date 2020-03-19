<?php
//session_start();

function SetConfig($name, $host, $providerID, $token)
{
    $_SESSION['name'] = $name;
    $_SESSION['host'] = $host;
    $_SESSION['providerID'] = $providerID;
    $_SESSION['token'] = $token;

    $response = 'Config is set';

    return $response;
}

function GetCatalog(){
//    print_r($_SESSION);
    if (isset($_SESSION['provider_id']) && isset($_SESSION['host']) && isset($_SESSION['token'])) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $_SESSION['host'].'/catalog/'.trim($_SESSION['provider_id']),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "IDENTITY_KEY: ".$_SESSION['token'],
//                "IDENTITY_KEY: 390b22ca1e41eeab8d47ea5a613a2206b649702232b6c4503396e277b6365eef",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $decode = json_decode($response, true);
        curl_close($curl);

    } else {
        $response = "Please set the config first!";
    }

    return $decode;
}

function GetData_Date($sensorName, $from, $to)
{
    if (isset($_SESSION['provider_id']) && isset($_SESSION['host']) && isset($_SESSION['token'])) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://'.$_SESSION['host'].'/data/'.trim($_SESSION['provider_id']).'/'.$sensorName.'?from='.$from.'&to='.$to,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "IDENTITY_KEY:".$_SESSION['token']
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);

    } else {
        $response = "Please set the config first!";
    }

    return $response;
}

function utfToHex($sensor, $from, $to){
    if (isset($_SESSION['provider_id']) && isset($_SESSION['host']) && isset($_SESSION['token'])) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://'.$_SESSION['host'].'/data/'.trim($_SESSION['provider_id']).'/'.$sensor.'?from='.$from.'&to='.$to,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "IDENTITY_KEY:".$_SESSION['token']
            ),
        ));
        $response = curl_exec($curl);
//        echo "<pre>";
//        echo "response eerst: " . $response. "<br>";
//        echo "</pre>";
        $response = json_decode($response, true);
        curl_close($curl);

    } else {
        $response = "Please set the config first!";
    }


    $string = ($response['observations'][0]['value']);
    echo "<br>";
    echo $string;
    $values = array();
    for ($i = 0; $i < strlen($string); $i++) {
        array_push($values, str_pad(dechex(ord($string[$i])), 4, '0x0', STR_PAD_LEFT));
    }

    echo "<pre>";
    print_r($values);
    echo "</pre>";
    $snr = findTwosComplement(decbin(hexdec($values[18])));

    $rssi = hexdec($values[sizeof($values)-2]);
    $batteryLevel = hexdec($values[sizeof($values)-4]) . "MSB (in mV)," . hexdec($values[sizeof($values)-3]) . "LSB (in mV)";
    $DLCounter = hexdec($values[sizeof($values)-5]);
    $ULCounter = hexdec($values[sizeof($values)-6]);
    $gpsQuality = $values[sizeof($values)-7];
    $gpsReception = hexdec(substr($gpsQuality,-2,-1));
    $gpsSatelites = hexdec("0x0" . (substr($gpsQuality,-1)));
    $gpsLat = $values[4] . "°" .  $values[5] . "," . $values[6]. substr($values[7], -1 );
    $gpsLat .= (substr($values[7], 0, -1) == 0)? "N" :  "S";
    $gpsLat = str_replace("0x", "",$gpsLat);
    $gpsLong = $values[8] .  $values[9] . $values[10]. substr($values[11],-2,1);
    $gpsLong = str_replace("0x", "", $gpsLong);
    $gpsLong = substr_replace( $gpsLong, "°", 3, 0);
    $gpsLong = substr_replace( $gpsLong, ",", 7, 0);
    $gpsLong .= (substr($values[11], 0, -1) == 0)? "E" :  "W";
//    $temp = findTwosComplement(decbin(hexdec($values[2])));
//    $status = $values[sizeof($values)-17];



    echo "snr: " .$snr . "<br>";
    echo "rssi: " . $rssi . "<br>";
//    echo "Battery level: " . $batteryLevel . "<br>";
//    echo "DL Counter: " .$DLCounter . "<br>";
//    echo "UL: " .$ULCounter . "<br>";
//    echo "gpsReception: " . $gpsReception . "<br>";
//    echo "gpssatellites: " . $gpsSatelites . "<br>";
    echo "lat: " .$gpsLat . "<br>";
    echo "long: " .$gpsLong . "<br>";
//    echo "temperature: " .$temp . "<br>";
//    echo "status: " .$status . "<br>";






}

function findTwosComplement($str)
{
    $str = sprintf('%08d',$str);
    $n = strlen($str);

    $count = 128;
    $total = 0;
    $state = 0;
    for ($i = 0 ; $i < $n ; $i++) {
        if ($str[0] == 0) {
            if ($i > 0 && $str[$i] == 1) {
                $total += $count;
            }
            $count /= 2;
        } else {
            $state = 1;
            if ($i > 0 && $str[$i] == 1){
                $total += $count;
            }
            $count /=2;
        }
    }
    if ($state == 1){
        $total -=128;
    }

    return $total;
}