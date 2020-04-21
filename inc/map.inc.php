<div class="d-flex justify-content-end">
    <div id="wrapper">
        <!-- Map Content  -->
        <div id="mapContainer">
            <div id="map"></div>
        </div>

        <!-- Side bar -->
        <div id="sidebarWrapper">
            <div id="sidebar">
            <?php
            include 'php/dbh.php';
            require 'php/library.php';
            require 'php/map.php';
            if(!isset($_SESSION['config'])){
                echo '<div class="alert alert-danger" role="alert" style="text-align:center; height:130px">';
                echo "Please set the config first<br><br>";
                echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
                echo '</div>';
            }
            else if (isset($_SESSION['config']) && $_SESSION['config'] == "Config is incorrect"){
                    echo '<div class="alert alert-danger" role="alert" style="text-align:center; height:130px">';
                    echo $_SESSION['config'] . "<br>";
                    echo "Please set a correct config first<br><br>";
                    echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
                    echo '</div>';
            } else {
                $id = $_SESSION['config_id'];

                $query = $conn->prepare("
                SELECT  D.data_id AS data_id,
                        D.dataName AS dataName,
                        D.latitude AS latitude,
                        D.longitude AS longitude,
                        D.gpsquality AS gps,
                        D.rssi AS rssi,
                        D.snr AS snr,
                        D.oneValue AS oneValue,
                        D.dateFrom AS dateFrom,
                        D.dateTo AS dateTo,
                        D.component AS component,
                        D.gateway_id AS gateway_id,
                        G.name AS gatewayName
                FROM data AS D
                INNER JOIN gateway as G ON D.gateway_id = G.gateway_id
                INNER JOIN config AS C ON G.config_id = C.config_id
                WHERE C.config_id=:id
            ");
                $query->execute(array(
                    ":id" => $id
                ));

                ?>

                <form action="" method="post" id="form">
                    <div class="form-group">
                        <?php
                        $i = 0;
                        foreach ($query as $row) {
                            $sql2 = $conn->prepare('SELECT dataname FROM data WHERE gateway_id=:id');
                            $sql2->execute(array(
                                ":id" => $row['gateway_id']
                            ));

                        $gID = $row['gateway_id'];

                        $sep = $conn->prepare("
                                SELECT longitude AS gatewayLong,
                                       latitude AS gatewayLat
                                FROM gateway
                                WHERE gateway_id = $gID ");

                        $sep->execute();
                        $res = $sep->fetch(PDO::FETCH_ASSOC);
                        $latitude = $res['gatewayLat'];
                        $longitude = $res['gatewayLong'];


                        if ($row['oneValue'] != ""){
                            $checkValues = oneSensorData($row['oneValue'], $row['dateFrom'], $row['dateTo'], $row['gatewayName'], $latitude, $longitude);
                            if ($checkValues != ""){
                                if ($sql2->rowCount() !=0) {
                                    ?>
                                    <h2><?= $row['gatewayName'] ?></h2>
                                    <script>
                                        var latitude = "--><?= $latitude?>";
                                        var longitude = "<?= $longitude?>";
                                        var gatewayName = "<?= $row['gatewayName']?>";
                                       console.log(longitude, latitude);
                                       gateways(latitude, longitude, gatewayName);
                                    </script><?php
                                }
                            }
                        } else {
                            $checkValues = seperateData($row['rssi'], $row['snr'], $row['latitude'], $row['longitude'], $row['dateFrom'], $row['dateTo'], $row['gatewayName'], $latitude, $longitude);
                            if ($checkValues != ""){?>
                                <h2><?= $row['gatewayName'] ?></h2>
                                <script>-->
                                    var latitude = "<?= $latitude?>"
                                    var longitude = "<?= $longitude?>";
                                    var gatewayName = "<?= $row['gatewayName']?>";
                                   gateways(latitude, longitude, gatewayName);
                                </script>
                                <div class="form-group">
                                    <input type="checkbox" class="form-control-input" id="InputCheck"
                                           name="<?=$row['dataName'] ?>"
                                    <?php
                                        if (isset($_POST['submitLoad']) || isset($_POST['SubmitButton'])) {
                                            foreach ($_POST as $key => $value) {
                                                if ($value == "on") {
                                                    if ($key == $row['dataName']) {
                                                        echo "checked";
                                                    }
                                                }
                                            }
                                        } elseif (isset($_POST['submitSpec'])) {
                                            if ($_POST['dataName'] == $row['dataName']) {
                                                echo "checked";
                                            }
                                        } elseif (isset($_POST['showGateway'])) {
                                            if ($_POST['gateway'] == $row['name']) {
                                                echo "checked";
                                            }
                                        }

                                        ?>

                                    <label class="form-check-label" for="InputCheck"><?= $row['dataName'] ?></label>
                                    <?php
                                    }

                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="choiceRadios">Choose SNR or RSSI:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choiceRadios" id="radio1"
                                   value="SNR" <?php if (isset($_POST['choiceRadios']) && $_POST['choiceRadios'] == "SNR") {echo "checked";} else {echo "checked"; } ?>>
                            <label class="form-check-label" for="radio1">
                                SNR
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choiceRadios" id="radio2" value="RSSI"
                                   value="SNR" <?php if (isset($_POST['choiceRadios']) && $_POST['choiceRadios'] == "RSSI") echo "checked" ?>>
                            <label class="form-check-label" for="radio2">
                                RSSI
                            </label>
                        </div>
                    </div>
                    <input type="submit" name="SubmitButton" value="Load Data" class="btn btn-primary"/>
                </form>
                <?php

            $everything = array();
            if (isset($_POST['SubmitButton'])) {
                $dataName = array_key_first($_POST);
                $query = $conn->prepare("
                SELECT  D.data_id AS data_id,
                        D.dataName AS dataName,
                        D.latitude AS latitude,
                        D.longitude AS longitude,
                        D.gpsquality AS gps,
                        D.rssi AS rssi,
                        D.snr AS snr,
                        D.oneValue AS oneValue,
                        D.dateFrom AS dateFrom,
                        D.dateTo AS dateTo,
                        D.component AS component,
                        D.gateway_id AS gateway_id,
                        G.name AS gatewayName
                FROM data AS D
                INNER JOIN gateway as G ON D.gateway_id = G.gateway_id
                INNER JOIN config AS C ON G.config_id = C.config_id
                WHERE C.config_id=:id AND D.dataName=:dName
            ");

                $query->execute(array(
                    ":id" => $id,
                    ":dName" => $dataName
                ));

                $query = $query->fetch(PDO::FETCH_ASSOC);


                $q2 = $conn->prepare("
                SELECT  name AS name,
                        latitude AS lat,
                        longitude AS longi
                FROM gateway
                WHERE gateway_id=:gID
                ");

                $q2->execute(array(
                    "gID"=>$query['gateway_id']
                ));

                $q2 = $q2->fetch(PDO::FETCH_ASSOC);

                $gName = $q2['name'];
                $gLat = $q2['lat'];
                $gLong = $q2['longi'];


                $result = showData($query['rssi'], $query['snr'], $query['latitude'], $query['longitude'], $query['dateFrom'], $query['dateTo'], 100);
                for ($j=0; $j < sizeof($result[0]); $j++){
                    for ($i=0; $i < sizeof($result[0]['observations']); $i++) {
                        $gpsLat = intval($result[2]['observations'][$i]['value']);
                        $gpsLatHex = dechex($gpsLat);
                        $gpsLatResult = formatEndian($gpsLatHex, 'N');
                        $gpsLatResult = substr_replace($gpsLatResult, "°", 2, 0);
                        $gpsLatResult = substr_replace($gpsLatResult, ",", 6, 0);

                        $latMinus = false;
                        $gpsLatResult = substr_replace($gpsLatResult, (substr($gpsLatResult, -1, 1) == 0) ? "N" : "S", -1);
                        if (substr($gpsLatResult, -1, 1) == "S") {
                            $latMinus = true;
                        }
                        $gpsLatDD = DMStoDD(substr($gpsLatResult, 0, 2), substr($gpsLatResult, 4, 2), substr($gpsLatResult, 7, 3));
                        if ($latMinus) {
                            $gpsLatResult = "-" . $gpsLatResult;
                            $gpsLatDD = "-" . $gpsLatDD;
                        }

                        $gpsLong = intval($result[3]['observations'][$j]['value']);
                        $gpsLongHex = dechex($gpsLong);
                        $gpsLongResult = formatEndian($gpsLongHex, 'N');
                        $gpsLongResult = substr_replace($gpsLongResult, "°", 3, 0);
                        $gpsLongResult = substr_replace($gpsLongResult, ",", 7, 0);
                        $longMinus = false;
                        $gpsLongResult = substr_replace($gpsLongResult, (substr($gpsLongResult, -1, 1) == 0) ? "E" : "W", -1);
                        if (substr($gpsLongResult, -1, 1) == "W") {
                            $longMinus = true;
                        }
                        $gpsLongDD = DMStoDD(substr($gpsLongResult, 0, 3), substr($gpsLongResult, 5, 2), substr($gpsLongResult, 8, 2));
                        if ($longMinus) {
                            $gpsLongResult = "-" . $gpsLongResult;
                            $gpsLongDD = "-" . $gpsLongDD;
                        }

                        $rssi = $result[0]['observations'][$i]['value'];
                        $snr = $result[1]['observations'][$i]['value'];
                        $time = $result[0]['observations'][$i]['timestamp'];

                        if (isset($_POST['choiceRadios'])){
                            if ($_POST['choiceRadios'] == "SNR") {
                                echo "<script>SNRmarkers(" . $gpsLatDD . "," . $gpsLongDD . "," . $snr . "," . $rssi . ",'" . $time . "','" . $gName . "'," . $gLat .  "," . $gLong .")</script>";
                            } else {
                                echo "<script>RSSImarkers(" . $gpsLatDD . "," . $gpsLongDD . "," . $snr . "," . $rssi .  ",'" . $gName . "'," . $gLat .  "," . $gLong .")</script>";
                            }
                        }



                    }
                }

            } elseif (isset($_POST['submitLoad'])) {

                foreach ($_POST as $key => $value) {
                    if ($value == "on") {

                        $query4 = $conn->prepare ("SELECT * FROM data WHERE dataName=:dName");
                        $query4->execute(array(
                            ":dName" => $key
                        ));

                        if ($query4->rowCount() != 0) {
                            if ($query4->fetch()['oneValue'] != "") {
                                $query5 = $conn->prepare("
                                SELECT D.snr AS snr,
                                       D.rssi AS rssi,
                                       D.dateFrom AS dateFrom,
                                       D.dateTo AS dateTo,
                                       G.longitude AS long,
                                       G.latitude AS lat,
                                       G.name AS name
                                FROM data AS D
                                INNER JOIN gateway AS G
                                ON D.gateway_id = G.gateway_id
                                WHERE D.dataName = '" . $key . "'");

                                $query5->execute();
                                $res = $query5->fetch(PDO::FETCH_ASSOC);
                                $sensor = $res['oneValue'];
                                $from = $res['dateFrom'];
                                $to = $res['dateTo'];
                                $latitude = $res['lat'];
                                $longitude = $res['long'];
                                $gateway = $res['name'];

                                $result = oneSensorData($sensor, $from, $to, $gateway, $latitude, $longitude);
                            } else {
                                $query6 = $conn->prepare("
                                SELECT D.snr AS snr,
                                       D.rssi AS rssi,
                                       D.dateFrom AS dateFrom,
                                       D.dateTo AS dateTo,
                                       D.longitude AS dataLong,
                                       D.latitude AS dataLat,
                                       G.longitude AS gatewayLong,
                                       G.latitude AS gatewayLat,
                                       G.name AS name
                                FROM data AS D
                                INNER JOIN gateway AS G
                                ON D.gateway_id = G.gateway_id
                                WHERE D.dataName = '" . $key . "'");
                                $query6->execute();
                                $res = $query6->fetch(PDO::FETCH_ASSOC);

                                $snr = $res['snr'];
                                $rssi = $res['rssi'];
                                $from = $res['dateFrom'];
                                $to = $res['dateTo'];
                                $lat = $res['dataLat'];
                                $long = $res['dataLong'];
                                $latitude = $res['gatewayLat'];
                                $longitude = $res['gatewayLong'];
                                $gateway = $res['name'];

                                $result = seperateData($rssi, $snr, $lat, $long, $from, $to, $gateway, $latitude, $longitude);
                            }
                            array_push($everything, $result);
                        }
                    }
                }
            }



//            TODO: Check when no values
//            $allGateways = array();
//            $newArray = array();
//            foreach ($everything as $check) {
//                if (!in_array($check[4], $newArray)) {
//                    if (!empty($newArray)) {
//                        $newArray = array_chunk($newArray, 7);
//                        for ($i = 0; $i < sizeof($newArray); $i++){
//                            if (isset($_POST['choiceRadios'])){
//                                if ($_POST['choiceRadios'] == "SNR") {
//                                    echo "<script>SNRmarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
//                                } else {
//                                    echo "<script>RSSImarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
//                                }
//                            }
//                        }
//                    }
//                    echo "<script>greenSNR = [];blueSNR = [];yellowSNR  = [];orangeSNR = [];redSNR = [];greenRSSI;blueRSSI = [];yellowRSSI = [];orangeRSSI = [];redRSSI  = [];</script>";
//                    unset($newArray);
//                    $newArray = array();
//                }
//                if (empty($newArray)) {
//                    array_push($newArray, $check[0], $check[1],$check[2], $check[3], $check[4],$check[5], $check[6]);
//                } else {
//                    array_push($newArray, $check[0], $check[1],$check[2], $check[3], $check[4],$check[5], $check[6]);
//                }
//                echo "<br>";
//            }
//            $newArray = array_chunk($newArray, 7);
////            print_r($_POST);
//            for ($i = 0; $i < sizeof($newArray); $i++){
//                if (isset($_POST['choiceRadios'])){
//                    if ($_POST['choiceRadios'] == "SNR") {
//                        echo "<script>SNRmarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
//                    } else {
//                        echo "<script>RSSImarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
//                    }
//                }
//
//            }
            }
            ?>
        </div>

    </div>

        <button id="openColors" class="btn btn-primary">Change Colors</button>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="colorSelection">
                    <form method="post" action="php/changeColor.php">
                        <?php
                        $getColorQ=$conn->prepare('SELECT * FROM colors WHERE config_id=:conf');
                        $getColorQ->execute(array(
                            ':conf'=>$_SESSION['config_id']
                        ));
                        $getColorQ= $getColorQ->fetch(PDO:: FETCH_ASSOC);
                        $lowest = $getColorQ['lowest'];
                        $low = $getColorQ['low'];
                        $medium = $getColorQ['medium'];
                        $high = $getColorQ['high'];
                        $highest = $getColorQ['highest'];


//                        $lowest = $getColorQ['lowest'];
                        $lowestFromSnr = $getColorQ['llFromSnr'];
                        $lowestToSnr = $getColorQ['llToSnr'];
                        $lowestFromRSSI = $getColorQ['llFromRssi'];
                        $lowestToRssi = $getColorQ['llToRssi'];

//                        $low = $getColorQ['low'];
                        $lowFromSnr = $getColorQ['lFromSnr'];
                        $lowToSnr = $getColorQ['lToSnr'];
                        $lowFromRSSI = $getColorQ['lFromRSSI'];
                        $lowToRssi = $getColorQ['lToRSSI'];

//                        $med = $getColorQ['medium'];
                        $medFromSnr = $getColorQ['mFromSnr'];
                        $medToSnr = $getColorQ['mToSnr'];
                        $medFromRSSI = $getColorQ['mFromRssi'];
                        $medToRssi = $getColorQ['mToRssi'];

//                        $high = $getColorQ['high'];
                        $highFromSnr = $getColorQ['hFromSnr'];
                        $highToSnr = $getColorQ['hToSnr'];
                        $highFromRSSI = $getColorQ['hFromRssi'];
                        $highToRssi = $getColorQ['hToRssi'];

//                        $highest = $getColorQ['highest'];
                        $highestFromSnr = $getColorQ['hhFromSnr'];
                        $highestToSnr = $getColorQ['hhToSnr'];
                        $highestFromRSSI = $getColorQ['hhFromRssi'];
                        $highestToRssi = $getColorQ['hhToRssi'];

                        ?>
                        <h2>Color Selection:</h2>
                        Lowest :<div class="color-picker"></div>
                        <script>
                            let lowestColor = '<?= $lowest ?>';

                            const pickr = Pickr.create({
                                el: '.color-picker',
                                theme: 'classic', // or 'monolith', or 'nano'
                                default: '#<?= $lowest ?>',

                                components: {
                                    // Main components
                                    preview: true,
                                    opacity: true,
                                    hue: true,

                                    // Input / output Options
                                    interaction: {
                                        hex: true,
                                        input: true,
                                        clear: true,
                                        save: true
                                    }
                                }
                            });
                            pickr.on('save' , (...args) =>{
                                lowestColor = args[0].toHEXA().toString();
                            });

                        </script>
                        <br>
                        <div class="form-row" style="margin-left: 300px">
                            SNR From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowestSnrFrom" id="LowestSnrFrom" value="<?=$lowestFromSnr?>" maxlength="3">
                            </div>
                            SNR To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowestSnrTo" id="LowestSnrTo" value="<?=$lowestToSnr?>" maxlength="3">
                            </div>
                        </div>
                        <div class="form-row" style="margin-left: 300px">
                            RSSI From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowestRSSIFrom" id="LowestRSSIFrom" value="<?=$lowestFromRSSI?>" maxlength="3">
                            </div>
                            RSSI To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowestRssiTo" id="LowestRssiTo" value="<?=$lowestToRssi?>" maxlength="3">
                            </div>
                        </div>
                        Low :<div class="color-picker2"></div>
                        <script>
                            let lowColor = '<?= $low ?>';

                            const pickr2 = Pickr.create({
                                el: '.color-picker2',
                                theme: 'classic', // or 'monolith', or 'nano'
                                default: '#<?= $low ?>',

                                components: {
                                    // Main components
                                    preview: true,
                                    opacity: true,
                                    hue: true,

                                    // Input / output Options
                                    interaction: {
                                        hex: true,
                                        input: true,
                                        clear: true,
                                        save: true
                                    }
                                }
                            });
                            pickr2.on('save' , (...args) =>{
                                lowColor = args[0].toHEXA().toString();
                            });
                        </script>
                        <br>
                        <div class="form-row" style="margin-left: 300px">
                            SNR From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowSnrFrom" id="LowSnrFrom" value="<?=$lowFromSnr?>" maxlength="3">
                            </div>
                            SNR To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowSnrTo" id="LowSnrTo"value="<?=$lowToSnr?>" maxlength="3">
                            </div>
                        </div>
                        <div class="form-row" style="margin-left: 300px">
                            RSSI From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowRSSIFrom" id="LowRSSIFrom" value="<?=$lowFromRSSI?>" maxlength="3">
                            </div>
                            RSSI To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="LowRssiTo" id="LowRssiTo" value="<?=$lowToRssi?>" maxlength="3">
                            </div>
                        </div>
                        Medium :<div class="color-picker"></div>
                        <script>
                            let mediumColor = '<?= $medium ?>';

                            const pickr3 = Pickr.create({
                                el: '.color-picker',
                                theme: 'classic', // or 'monolith', or 'nano'
                                default: '#<?= $medium ?>',

                                components: {
                                    // Main components
                                    preview: true,
                                    opacity: true,
                                    hue: true,

                                    // Input / output Options
                                    interaction: {
                                        hex: true,
                                        input: true,
                                        clear: true,
                                        save: true
                                    }
                                }
                            });

                            pickr3.on('save' , (...args) =>{
                                mediumColor = args[0].toHEXA().toString();
                            });
                        </script>
                        <br>
                        <div class="form-row" style="margin-left: 300px">
                            SNR From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="MedSnrFrom" id="MedSnrFrom" value="<?=$medFromSnr?>"maxlength="3">
                            </div>
                            SNR To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="MedSnrTo" id="MedSnrTo" value="<?=$medToSnr?>" maxlength="3">
                            </div>
                        </div>
                        <div class="form-row" style="margin-left: 300px">
                            RSSI From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="MedRSSIFrom" id="MedRSSIFrom" value="<?=$medFromRSSI?>" maxlength="3">
                            </div>
                            RSSI To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="MedRssiTo" id="MedRssiTo" value="<?=$medToRssi?>" maxlength="3">
                            </div>
                        </div>

                        High :<div class="color-picker"></div>
                        <script>
                            let highColor = '<?= $high ?>';
                            const pickr4 = Pickr.create({
                                el: '.color-picker',
                                theme: 'classic', // or 'monolith', or 'nano'
                                default: '#<?= $high ?>',

                                components: {
                                    // Main components
                                    preview: true,
                                    opacity: true,
                                    hue: true,

                                    // Input / output Options
                                    interaction: {
                                        hex: true,
                                        input: true,
                                        clear: true,
                                        save: true
                                    }
                                }
                            });
                            pickr4.on('save' , (...args) =>{
                                highColor = args[0].toHEXA().toString();
                            });
                        </script>
                        <br>
                        <div class="form-row" style="margin-left: 300px">
                            SNR From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighSnrFrom" id="HighSnrFrom" value="<?=$highFromSnr?>" maxlength="3">
                            </div>
                            SNR To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighSnrTo" id="HighSnrTo" value="<?=$highToSnr?>" maxlength="3">
                            </div>
                        </div>
                        <div class="form-row" style="margin-left: 300px">
                            RSSI From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighRssiFrom" id="HighRssiFrom" value="<?=$highFromRSSI?>" maxlength="3">
                            </div>
                            RSSI To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighRssiTo" id="HighRssiTo" value="<?=$highToRssi?>" maxlength="3">
                            </div>
                        </div>
                        Highest :<div class="color-picker"></div>
                        <script>
                            let highestColor = '<?= $highest ?>';
                            const pickr5 = Pickr.create({
                                el: '.color-picker',
                                theme: 'classic', // or 'monolith', or 'nano'
                                default: '#<?= $highest ?>',

                                components: {
                                    // Main components
                                    preview: true,
                                    opacity: true,
                                    hue: true,

                                    // Input / output Options
                                    interaction: {
                                        hex: true,
                                        input: true,
                                        clear: true,
                                        save: true
                                    }
                                }
                            });
                            pickr5.on('save' , (...args) =>{
                                highestColor = args[0].toHEXA().toString();
                            });
                        </script>
                        <br>
                        <div class="form-row" style="margin-left: 300px">
                            SNR From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighestSnrFrom" id="HighestSnrFrom" value="<?=$highestFromSnr?>" maxlength="3">
                            </div>
                            SNR To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighestSnrTo" id="HighestSnrTo"value="<?=$highestToSnr?>" maxlength="3">
                            </div>
                        </div>
                        <div class="form-row" style="margin-left: 300px">
                            RSSI From:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighestRSSIFrom" id="HighestRSSIFrom" value="<?=$highestFromRSSI?>" maxlength="3">
                            </div>
                            RSSI To:
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="HighestRssiTo" id="HighestRssiTo" value="<?=$highestToRssi?>" maxlength="3">
                            </div>
                        </div>


                        <input type="hidden" name="lowest" id="lowest">
                        <input type="hidden" name="low" id="low">
                        <input type="hidden" name="medium" id="medium">
                        <input type="hidden" name="high" id="high">
                        <input type="hidden" name="highest" id="highest">

                        <script>
                            pickr.on('save', (...args) => {
                                document.getElementById('lowest').value = lowestColor;
                            });
                            pickr2.on('save', (...args) => {
                                document.getElementById('low').value = lowColor;
                            });
                            pickr3.on('save', (...args) => {
                                document.getElementById('medium').value = mediumColor;
                            });
                            pickr4.on('save', (...args) => {
                                document.getElementById('high').value = highColor;
                            });
                            pickr5.on('save', (...args) => {
                                document.getElementById('highest').value = highestColor;
                            });
                        </script>

                        <br>
                        <input type="submit" name="SubmitButton" value="Set colors" class="btn btn-primary"/>

                    </form>
                </div>
            </div>

        </div>
        <script>
            var modal = document.getElementById("myModal");

            var btn = document.getElementById("openColors");

            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            };

            span.onclick = function() {
                modal.style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        </script>
    </div>

    </div>
</div>

