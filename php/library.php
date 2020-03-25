<?php

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

function oneSensorData($sensor, $from, $to, $gateway, $latitude, $longitude){
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

        if (!empty($response['observations'])) {

            $string = ($response['observations'][0]['value']);
            $values = array();
            for ($i = 0; $i < strlen($string); $i++) {
                array_push($values, str_pad(dechex(ord($string[$i])), 4, '0x0', STR_PAD_LEFT));
            }
//        echo "<pre>";
//            print_r($values);
//        echo "</pre>";
            $snr = findTwosComplement(decbin(hexdec($values[sizeof($values) - 1])));
            $rssi = "-" . hexdec($values[sizeof($values) - 2]);
            $gpsLat = $values[4] . "°" . $values[5] . "," . $values[6] . substr($values[7], -1);
            $latMinus = false;
            $gpsLat .= (substr($values[7], -1, 1) == 0) ? "N" : "S";
            $gpsLat = str_replace("0x", "", $gpsLat);
            if (substr($gpsLat, -1, 1) == "S") {
                $latMinus = true;
            }


            $gpsLong = $values[8] . $values[9] . $values[10] . substr($values[11], -2, 1);
            $gpsLong = str_replace("0x", "", $gpsLong);
            $gpsLong = substr_replace($gpsLong, "°", 3, 0);
            $gpsLong = substr_replace($gpsLong, ",", 7, 0);
            $longMinus = false;
            $gpsLong .= (substr($values[11], -1, 1) == 0) ? "E" : "W";
            if (substr($gpsLong, -1, 1) == "W") {
                $longMinus = true;
            }

//        echo "snr: " .$snr . "<br>";
//        echo "rssi: " . $rssi . "<br>";
//        echo "lat: " .$gpsLat . "<br>";
//        echo "long: " .$gpsLong . "<br>";


            $gpsLat = DMStoDD(substr($gpsLat, 0, 2), substr($gpsLat, 4, 2), substr($gpsLat, 7, 3));
            $gpsLong = DMStoDD(substr($gpsLong, 0, 3), substr($gpsLong, 5, 2), substr($gpsLong, 8, 2));
            if ($longMinus) {
                $gpsLong = "-" . $gpsLong;
            }
            if ($latMinus) {
                $gpsLat = "-" . $gpsLat;
            }
            $response = array($snr, $rssi, $gpsLat, $gpsLong, $gateway, $latitude, $longitude);
        } else {
//            echo "This datapoint has no values";
            $response = "This datapoint has no values";
        }
    } else {
        $response = "Please set the config first!";
    }

    return $response;
}


function seperateData($rssi, $snr, $lat, $long, $from, $to, $gateway, $latitude, $longitude)
{
    if (isset($_SESSION['provider_id']) && isset($_SESSION['host']) && isset($_SESSION['token'])) {
        $sensors = array($rssi, $snr, $lat, $long);
        $result = array();
        for ($i = 0; $i < sizeof($sensors); $i++) {


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://' . $_SESSION['host'] . '/data/' . trim($_SESSION['provider_id']) . '/' . $sensors[$i] . '?from=' . $from . '&to=' . $to,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "IDENTITY_KEY:" . $_SESSION['token']
                ),
            ));
            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);
            array_push($result, $response);
        }
//        echo "<pre>";
//            print_r($result);
//        echo "</pre>";

        $rssi = "-" . intval($result[0]['observations'][0]['value']);

        $snr = findTwosComplement(decbin(hexdec(intval($result[1]['observations'][0]['value']))));

        $gpsLat = intval($result[2]['observations'][0]['value']);
        $gpsLatHex = dechex($gpsLat);
        $gpsLatResult = formatEndian($gpsLatHex, 'N');
        $gpsLatResult = substr_replace( $gpsLatResult, "°", 2, 0);
        $gpsLatResult = substr_replace( $gpsLatResult, ",", 6, 0);
        $latMinus = false;
        $gpsLatResult = substr_replace($gpsLatResult, (substr($gpsLatResult, -1, 1) == 0)? "N" :  "S", -1);
        if (substr($gpsLatResult,-1,1) == "S"){
            $latMinus = true;
        }

        $gpsLong = intval($result[3]['observations'][0]['value']);
        $gpsLongHex = dechex($gpsLong);
        $gpsLongResult = formatEndian($gpsLongHex, 'N');
        $gpsLongResult = substr_replace( $gpsLongResult, "°", 3, 0);
        $gpsLongResult = substr_replace( $gpsLongResult, ",", 7, 0);
        $longMinus = false;
        $gpsLongResult = substr_replace($gpsLongResult, (substr($gpsLongResult, -1, 1) == 0)? "E" :  "W", -1);
        if (substr($gpsLongResult, -1,1) == "W"){
            $longMinus = true;
        }

//        echo "snr: " .$snr . "<br>";
//        echo "rssi: " . $rssi . "<br>";
//        echo "lat: " .$gpsLatResult . "<br>";
//        echo "long: " . $gpsLongResult . "<br>";


        $gpsLatResult = DMStoDD(substr($gpsLatResult, 0,2), substr($gpsLatResult,4,2), substr($gpsLatResult,7,3));
        $gpsLongResult = DMStoDD(substr($gpsLongResult, 0,3), substr($gpsLongResult,5,2), substr($gpsLongResult,8,2));
        if ($longMinus){
            $gpsLongResult = "-" . $gpsLongResult;
        }
        if ($latMinus){
            $gpsLatResult = "-" . $gpsLatResult;
        }
        $response = array($snr, $rssi, $gpsLatResult, $gpsLongResult, $gateway, $latitude, $longitude);
    } else {
        $response = "Please set the config first!";
    }

    return $response;


}

function formatEndian($endian, $format = 'N') {
    $endian = intval($endian, 16);      // convert string to hex
    $endian = pack('L', $endian);       // pack hex to binary sting (unsinged long, machine byte order)
    $endian = unpack($format, $endian); // convert binary sting to specified endian format

    return sprintf("%'.08x", $endian[1]); // return endian as a hex string (with padding zero)
}

function makeMarker($lat, $long, $rssi, $snr){
    ?><script>
        let lat = "<?php echo $lat?>";
        let long = "<?php echo $long?>";
        let rssi = "<?php echo $rssi?>";
        let snr = "<?php echo $snr?>";
        createMarker(lat,long,rssi, snr);
    </script>
<?php
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