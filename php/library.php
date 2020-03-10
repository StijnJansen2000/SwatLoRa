<?php
session_start();

function SetConfig($name, $host, $providerID, $token)
{
    $_SESSION['name'] = $name;
    $_SESSION['host'] = $host;
    $_SESSION['providerID'] = $providerID;
    $_SESSION['token'] = $token;

    $response = 'Config is set';

    return $response;
}