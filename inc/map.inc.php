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
                            $gateways = array();
                            $check = array();
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
                                WHERE gateway_id = $gID");

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
                                            var latitude = "<?= $latitude?>";
                                            var longitude = "<?= $longitude?>";
                                            var gatewayName = "<?= $row['gatewayName']?>";
                                            gateways(latitude, longitude, gatewayName);
                                        </script><?php
                                    }
                                }
                            } else {
                                $checkValues = seperateData($row['rssi'], $row['snr'], $row['latitude'], $row['longitude'], $row['dateFrom'], $row['dateTo'], $row['gatewayName'], $latitude, $longitude);
                                if ($checkValues != ""){
                                    if (!in_array($row['gatewayName'], $gateways)){
                                        if (sizeof($gateways) == 0){
                                            array_push($gateways,
                                                array(
                                                    $row['gatewayName'],
                                                    $row['dataName']
                                                )
                                            );
                                        } else {
                                            for ($i = 0; $i < sizeof($gateways); $i++){
                                                if ($gateways[$i][0] == $row['gatewayName']) {
                                                    if (!in_array($row['dataName'], $gateways[$i])){
                                                        array_push($gateways[$i], $row['dataName']);
                                                    }
                                                } else {
                                                    if (!in_array($row['gatewayName'],$check)){
                                                        array_push($check, $row['gatewayName']);
                                                        array_push($gateways,
                                                        array(
                                                            $row['gatewayName'],
                                                            $row['dataName']
                                                        )
                                                    );
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    ?>
                                <script>
                                    var latitude = "<?= $latitude?>"
                                    var longitude = "<?= $longitude?>";
                                    var gatewayName = "<?= $row['gatewayName']?>";
                                    gateways(latitude, longitude, gatewayName);
                                </script>
                                    <?php
                                    }
                                }

                            }

                            echo "<pre>";
//                            print_r($gateways);
//                            print_r($_POST);
                            echo "</pre>";


                            for ($i = 0; $i <sizeof($gateways); $i++){
                                echo "<h2>" . $gateways[$i][0] . "</h2>";
                                for ($j = 1; $j < sizeof($gateways[$i]); $j++){
                                    ?>
                                    <div class="form-group">
                                        <input type="checkbox" class="form-control-input" id="InputCheck" name="<?= $gateways[$i][$j]?>"
                                        <?php
                                        if (isset($_POST['submitLoad']) || isset($_POST['SubmitButton'])) {
                                                foreach ($_POST as $key => $value) {
                                                    if ($value == "on") {
                                                        if ($key == $gateways[$i][$j]) {
                                                            echo "checked";
                                                        }
                                                    }
                                                }
                                            }
//                                        elseif (isset($_POST['submitSpec'])) {
//                                                echo "elseif1";
//                                                if ($_POST['dataName'] == $row['dataName']) {
//                                                    echo "checked";
//                                                }
//                                            } elseif (isset($_POST['showGateway'])) {
//                                                echo "elseif2";
//                                                if ($_POST['gateway'] == $row['name']) {
//                                                    echo "checked";
//                                                }
//                                            }
                                        ?>
                                        >
                                        <label class="form-check-label" for="InputCheck"><?= $gateways[$i][$j] ?></label>
                                    </div>
                            <?php
                                }
                            }


                            ?>
<!--                            </div>-->
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
                    $center = array();
                    $everything = array();
                    if (isset($_POST['SubmitButton'])) {
                        foreach($_POST as $key => $value){
                            if ($value == 'on'){
                                $dataName = $key;
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

                                array_push($center, $gLat . "," . $gLong);

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

                                        $gpsLong = intval($result[3]['observations'][$i]['value']);
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
                                                echo "<script>RSSImarkers(" . $gpsLatDD . "," . $gpsLongDD . "," . $snr . "," . $rssi . ",'" . $time . "','" . $gName . "'," . $gLat .  "," . $gLong .")</script>";
                                            }
                                        }



                                    }
                                }
                            }
                        }

                        echo "<pre>";
                        print_r($center);
                        echo "</pre>";
                        $setCenter = $conn->prepare("UPDATE map SET centerLat=:centerLat, centerLong=:centerLong WHERE ID=1");
                        if (sizeof($center) == 0){
                            $_SESSION['center'] = 39.568329 . "," . -0.617676;
                            $setCenter->execute(array(
                                ':centerLat' => 39.568329,
                                ':centerLong' => -0.617676
                            ));
                        } elseif (sizeof($center) == 1){
                            $contents = explode(',', $center[0]);
                            $first = $contents[0];
                            $second = end($contents);
                            $_SESSION['center'] = $first . "," . $second;


                            $setCenter->execute(array(
                                ':centerLat' => $first,
                                ':centerLong' => $second
                            ));
                        } else {
                            $fistArray = array();
                            $secondArray = array();
                            for ($i = 0; $i < sizeof($center); $i++){
                                $contents = explode(',', $center[$i]);
                                array_push($fistArray, $contents[0]);
                                array_push($secondArray, end($contents));
                            }
                            $avg1 = array_sum($fistArray)/count($fistArray);
                            $avg2 = array_sum($secondArray)/count($secondArray);

                            $_SESSION['center'] = $avg1 . "," . $avg2;
                            $setCenter->execute(array(
                                ':centerLat' => $avg1,
                                ':centerLong' => $avg2
                            ));
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
                }

//                print_r($center);
                ?>
                <?php

                ?>
            </div>

        </div>
        </div>
        <button id="openColors" class="btn btn-primary">Change Colors/Ranges</button>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <?php
                    require 'php/colorSelection.php';
                ?>
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

