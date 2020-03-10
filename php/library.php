<?php
session_start();

function SetConfig($host, $providerID, $token)
{
    $_SESSION['host'] = $host;
    $_SESSION['providerID'] = $providerID;
    $_SESSION['token'] = $token;

    $response = 'Config is set';

    return $response;
}