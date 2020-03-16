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