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
        $response = json_decode($response, true);
        curl_close($curl);

    } else {
        $response = "Please set the config first!";
    }


    $string = ($response['observations'][0]['value']);
    $values = array();
    for ($i = 0; $i < strlen($string); $i++) {
        array_push($values, str_pad(dechex(ord($string[$i])), 4, '0x0', STR_PAD_LEFT));
    }


    $snr = findTwosComplement(decbin(hexdec($values[18])));
    $rssi = hexdec($values[sizeof($values)-2]);
    $gpsLat = $values[4] . "°" .  $values[5] . "," . $values[6]. substr($values[7], -1 );
    $gpsLat .= (substr($values[7], 0, -1) == 0)? "N" :  "S";
    $gpsLat = str_replace("0x", "",$gpsLat);
    $gpsLong = $values[8] .  $values[9] . $values[10]. substr($values[11],-2,1);
    $gpsLong = str_replace("0x", "", $gpsLong);
    $gpsLong = substr_replace( $gpsLong, "°", 3, 0);
    $gpsLong = substr_replace( $gpsLong, ",", 7, 0);
    $gpsLong .= (substr($values[11], 0, -1) == 0)? "E" :  "W";

    echo "snr: " .$snr . "<br>";
    echo "rssi: " . $rssi . "<br>";
    echo "lat: " .$gpsLat . "<br>";
    echo "long: " .$gpsLong . "<br>";

    DMStoDD(substr($gpsLat, 0,2), substr($gpsLat,4,2), substr($gpsLat,7,3));
    DMStoDD(substr($gpsLong, 0,3), substr($gpsLong,5,2), substr($gpsLong,8,2));
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

function DMStoDD($deg,$min,$sec) {
//    echo "deg: " . $deg . "<br>";
//    echo "min: " . $min . "<br>";
//    echo "sec: " . $sec . "<br>";
    // Converting DMS ( Degrees / minutes / seconds ) to decimal format

    return $deg+((($min*60)+($sec))/3600);

}