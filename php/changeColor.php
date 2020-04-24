<?php
    session_start();
    require 'dbh.php';
    echo "<pre>";
    print_r($_POST);
    echo "<pre>";

    $query = $conn->prepare("SELECT * FROM colors WHERE config_id=:conf");
    $query->execute(array(
        ":conf" => $_SESSION['config_id']
    ));
    $query = $query->fetch(PDO::FETCH_ASSOC);

    if ($_POST['lowest'] == ""){
        $lowest = $query['lowest'];
    } else {
        $lowest = substr($_POST['lowest'],1);
    }

    if ($_POST['low'] == ""){
        $low = $query['low'];
    } else {
        $low = substr($_POST['low'],1);
    }

    if ($_POST['medium'] == ""){
        $med = $query['medium'];
    } else {
        $med = substr($_POST['medium'],1);
    }

    if ($_POST['high'] == ""){
        $high = $query['high'];
    } else {
        $high = substr($_POST['high'],1);
    }

    if ($_POST['highest'] == ""){
        $highest = $query['highest'];
    } else {
        $highest = substr($_POST['highest'],1);
    }



    $query = $conn->prepare("UPDATE colors SET 
                                            lowest=:lowest, llFromSnr=:llFromSnr, llToSnr=:llToSnr, llFromRssi=:llFromRssi, llToRssi=:llToRssi,
                                            low=:low, lFromSnr=:lFromSnr, lToSnr=:lToSnr, lFromRSSI=:lFromRSSI, lToRSSI=:lToRSSI,
                                            medium=:med, mFromSnr=:mFromSnr, mToSnr=:mToSnr, mFromRssi=:mFromRssi, mToRssi=:mToRssi,
                                            high=:high, hFromSnr=:hFromSnr, hToSnr=:hToSnr, hFromRssi=:hFromRssi, hToRssi=:hToRssi,
                                            highest=:highest, hhFromSnr=:hhFromSnr, hhToSnr=:hhToSnr, hhFromRssi=:hhFromRssi, hhToRssi=:hhToRssi,
                                            snrLowest=:snrLowest, snrLow=:snrLow, snrMed=:snrMed, snrHigh=:snrHigh, snrHighest=:snrHighest,
                                            rssiLowest=:rssiLowest, rssiLow=:rssiLow, rssiMed=:rssiMed, rssiHigh=:rssiHigh, rssiHighest=:rssiHighest
                                        WHERE config_id=:conf");
    $query->execute(array(
        ":lowest"=>  $lowest,
        ":llFromSnr" => $_POST['LowestSnrFrom'],
        ":llToSnr" => $_POST['LowestSnrTo'],
        ":llFromRssi" =>$_POST['LowestRSSIFrom'],
        ":llToRssi" => $_POST['LowestRssiTo'],

        ":low" => $low,
        ":lFromSnr" => $_POST['LowSnrFrom'],
        ":lToSnr" => $_POST['LowSnrTo'],
        ":lFromRSSI" => $_POST['LowRSSIFrom'],
        ":lToRSSI" => $_POST['LowRssiTo'],

        ":med" => $med,
        ":mFromSnr" => $_POST['MedSnrFrom'],
        ":mToSnr" => $_POST['MedSnrTo'],
        ":mFromRssi" => $_POST['MedRSSIFrom'],
        ":mToRssi" => $_POST['MedRssiTo'],

        ":high"=> $high,
        ":hFromSnr" => $_POST['HighSnrFrom'],
        ":hToSnr" => $_POST['HighSnrTo'],
        ":hFromRssi" => $_POST['HighRssiFrom'],
        ":hToRssi" => $_POST['HighRssiTo'],

        ":highest" => $highest,
        ":hhFromSnr" => $_POST['HighestSnrFrom'],
        ":hhToSnr" => $_POST['HighestSnrTo'],
        ":hhFromRssi" => $_POST['HighestRSSIFrom'],
        ":hhToRssi" => $_POST['HighestRssiTo'],

        ":snrLowest" => $_POST['LowestSnrRange'],
        ":snrLow" => $_POST['LowSnrRange'],
        ":snrMed" => $_POST['MedSnrRange'],
        ":snrHigh" => $_POST['HighSnrRange'],
        ":snrHighest" => $_POST['HighestSnrRange'],

        ":rssiLowest" => $_POST['LowestRssiRange'],
        ":rssiLow" => $_POST['LowRssiRange'],
        ":rssiMed" => $_POST['MedRssiRange'],
        ":rssiHigh" => $_POST['HighRssiRange'],
        ":rssiHighest" => $_POST['HighestRssiRange'],

        ":conf"=> $_SESSION['config_id']
    ));

    header("Location: ../?page=map");