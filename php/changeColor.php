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

//    1   id
//	2	lowest
//	3	llFromSnr
//	4	llToSnr
//	5	llFromRssi
//	6	llToRssi
//	7	low
//	8	lFromSnr
//	9	lToSnr
//	10	lFromRSSI
//  11  lToRSSI
//	12	medium
//	13	mFromSnr
//	14	mToSnr
//	15	mFromRssi
//	16	mToRssi
//	17	high
//	18	hFromSnr
//	19	hToSnr
//	20	hFromRssi
//	21	hToRssi
//	22	highest
//	23	hhFromSnr
//  24  hhToSnr
//	25	hhFromRssi
//	26	hhToRssi

    $query = $conn->prepare("UPDATE colors SET 
                                            lowest=:lowest, llFromSnr=:llFromSnr, llToSnr=:llToSnr, llFromRssi=:llFromRssi, llToRssi=:llToRssi,
                                            low=:low, lFromSnr=:lFromSnr, lToSnr=:lToSnr, lFromRSSI=:lFromRSSI, lToRSSI=:lToRSSI,
                                            medium=:med, mFromSnr=:mFromSnr, mToSnr=:mToSnr, mFromRssi=:mFromRssi, mToRssi=:mToRssi,
                                            high=:high, hFromSnr=:hFromSnr, hToSnr=:hToSnr, hFromRssi=:hFromRssi, hToRssi=:hToRssi,
                                            highest=:highest, hhFromSnr=:hhFromSnr, hhToSnr=:hhToSnr, hhFromRssi=:hhFromRssi, hhToRssi=:hhToRssi
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

        ":conf"=> $_SESSION['config_id']
    ));

    header("Location: ../?page=map");