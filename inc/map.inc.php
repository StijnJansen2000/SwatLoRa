<div class="d-flex justify-content-end">
    <div id="wrapper">
        <!-- Map Content  -->
        <div id="mapContainer">
            <div id="map"></div>
        </div>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
                integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
                crossorigin=""></script>
        <script>
            var tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                'attribution': 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
            });

            var map = new L.Map('map', {
                'center': [39.46975, -0.37739],
                'zoom': 14,
                'layers': [tileLayer]
            });

            function markerColor(color) {
                var markerColor = L.icon({
                    iconUrl: 'images/marker' + color + '.png',
                    iconSize: [40, 40]
                });

                return markerColor;
            }

            var greenSNR = Array();
            var blueSNR = Array();
            var yellowSNR = Array();
            var orangeSNR = Array();
            var redSNR = Array();


            function SNRmarkers(lat, long, snr, rssi, gateway, gLat, gLong) {
                if (snr <= 3) {
                    var marker = L.marker([lat, long], {icon: markerColor("Green")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    greenSNR.push(marker.getLatLng());
                    greenSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 3 && snr <= 5) {
                    var marker = L.marker([lat, long], {icon: markerColor("Blue")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    blueSNR.push(marker.getLatLng());
                    blueSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 5 && snr <= 7) {
                    var marker = L.marker([lat, long], {icon: markerColor("Yellow")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    yellowSNR.push(marker.getLatLng());
                    yellowSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 7 && snr <= 9) {
                    var marker = L.marker([lat, long], {icon: markerColor("Orange")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    orangeSNR.push(marker.getLatLng());
                    orangeSNR.push(({lat: gLat, lng: gLong}));
                } else {
                    var marker = L.marker([lat, long], {icon: markerColor("Red")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    redSNR.push(marker.getLatLng());
                    redSNR.push(({lat: gLat, lng: gLong}));
                }
                var polyline = L.polyline(greenSNR, {color: 'green', fillColor: 'green'}).addTo(map);
                var polyline = L.polyline(blueSNR, {color: 'blue', fillColor: 'blue'}).addTo(map);
                var polyline = L.polyline(yellowSNR, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
                var polyline = L.polyline(orangeSNR, {color: 'orange', fillColor: 'orange'}).addTo(map);
                var polyline = L.polyline(redSNR, {color: 'red', fillColor: 'red'}).addTo(map);

                console.log(yellowSNR);
            }

            var greenRSSI = Array();
            var blueRSSI = Array();
            var yellowRSSI = Array();
            var orangeRSSI = Array();
            var redRSSI = Array();

            function RSSImarkers(lat, long, snr, rssi, gateway, gLat, gLong) {
                if (Math.abs(rssi) <= 10) {
                    var marker = L.marker([lat, long], {icon: markerColor("Green")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    greenRSSI.push(marker.getLatLng());
                    greenRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 10 && Math.abs(rssi) <= 32) {
                    var marker = L.marker([lat, long], {icon: markerColor("Blue")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    blueRSSI.push(marker.getLatLng());
                    blueRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 32 && Math.abs(rssi) <= 60) {
                    var marker = L.marker([lat, long], {icon: markerColor("Yellow")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    yellowRSSI.push(marker.getLatLng());
                    yellowRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 60 && Math.abs(rssi) <= 80) {
                    var marker = L.marker([lat, long], {icon: markerColor("Orange")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    orangeRSSI.push(marker.getLatLng());
                    orangeRSSI.push(({lat: gLat, lng: gLong}));
                } else {
                    var marker = L.marker([lat, long], {icon: markerColor("Red")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    redRSSI.push(marker.getLatLng());
                    redRSSI.push(({lat: gLat, lng: gLong}));
                }
                var polyline = L.polyline(greenRSSI, {color: 'green', fillColor: 'green'}).addTo(map);
                var polyline = L.polyline(blueRSSI, {color: 'blue', fillColor: 'blue'}).addTo(map);
                var polyline = L.polyline(yellowRSSI, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
                var polyline = L.polyline(orangeRSSI, {color: 'orange', fillColor: 'orange'}).addTo(map);
                var polyline = L.polyline(redRSSI, {color: 'red', fillColor: 'red'}).addTo(map);
            }

            function gateways(lat, long, name) {
                L.marker([lat, long]).addTo(map)
                    .bindPopup('Name: ' + name)
                    .openPopup();
            }

        </script>


        <!-- Side bar -->
        <div id="sidebar">
            <?php
            include 'php/dbh.php';
            require 'php/library.php';
            if ($_SESSION['config'] == "Config is incorrect"){
                echo '<div class="alert alert-danger" role="alert" style="text-align:center; height:130px">';
                echo $_SESSION['config'] . "<br>";
                echo "Please set a correct config first<br><br>";
                echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
                echo '</div>';
            } else {
                ?>

                <form action="" method="post" id="form">
                    <div class="form-group">
                        <?php
                        $query = $conn->prepare('SELECT * FROM gateway');
                        $query->execute();

                        $i = 0;
                        foreach ($query as $row) {
                            $sql = $conn->prepare('SELECT dataname FROM data WHERE gateway_id=:id');
                            $sql->execute(array(
                                ":id" => $row['gateway_id']
                            ));

                        if ($sql->rowCount() != 0){
                            ?>
                            <h2><?= $row['name'] ?></h2>
                            <script>
                                var latitude = "<?= $row['latitude']?>";
                                var longitude = "<?= $row['longitude']?>";
                                var gatewayName = "<?= $row['name']?>";
                                gateways(latitude, longitude, gatewayName);
                            </script>
                        <?php
                        }
                        foreach ($sql

                        as $data){
                        ?>
                            <div class="form-group">
                                <label class="form-check-label" for="InputCheck"><?= $data['dataname'] ?></label>
                                <input type="checkbox" class="form-control-input" id="InputCheck"
                                       name="<?= $data['dataname'] ?>"
                                    <?php
                                    if (isset($_POST['submitLoad']) || isset($_POST['SubmitButton'])) {
                                        foreach ($_POST as $key => $value) {
                                            if ($value == "on") {
                                                if ($key == $data['dataname']) {
                                                    echo "checked";
                                                }
                                            }
                                        }
                                    } elseif (isset($_POST['submitSpec'])) {
                                        if ($_POST['dataName'] == $data['dataname']) {
                                            echo "checked";
                                        }
                                    } elseif (isset($_POST['showGateway'])) {
                                        if ($_POST['gateway'] == $row['name']) {
                                            echo "checked";
                                        }
                                    }
                                    ?>
                                >
                            </div>
                            <?php
                        }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="choiceRadios">Choose SNR or RSSI:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choiceRadios" id="radio1"
                                   value="SNR" <?php if (isset($_POST['choiceRadios']) && $_POST['choiceRadios'] == "SNR") echo "checked" ?>>
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
            }
            $everything = array();
            if (isset($_POST['SubmitButton'])) {

                foreach ($_POST as $key => $value) {
                    $query1 = $conn->prepare('SELECT * FROM data WHERE dataName=:Dname');
                    $query1->execute(array(
                        ":Dname" => $key
                    ));
                    $check = $query1->fetch(PDO::FETCH_ASSOC);

                    if ($query1->rowCount() != 0) {
                        if ($check['oneValue'] != "") {
                            $query2 = $conn->prepare("
                                SELECT D.oneValue AS oneValue,
                                       D.dateFrom AS dateFrom,
                                       D.dateTo AS dateTo,
                                       G.longitude AS longitude,
                                       G.latitude AS lat,
                                       G.name AS name
                                FROM data AS D
                                INNER JOIN gateway AS G
                                ON D.gateway_id = G.gateway_id
                                WHERE D.dataName = '" . $key . "'");
                            $query2->execute();
                            $r = $query2->fetch(PDO::FETCH_ASSOC);

                            $sensor = $r['oneValue'];
                            $from = $r['dateFrom'];
                            $to = $r['dateTo'];
                            $gateway = $r['name'];
                            $latitude = $r['lat'];
                            $longitude = $r['longitude'];
                            $result = oneSensorData($sensor, $from, $to, $gateway, $latitude, $longitude);
                        } else {
                            $query3 = $conn->prepare("
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

                            $query3->execute();
                            $res = $query3->fetch(PDO::FETCH_ASSOC);
                            $snr = $res['snr'];
                            $rssi = $res['rssi'];
                            $from = $res['dateFrom'];
                            $to = $res['dateTo'];
                            $lat = $res['dataLat'];
                            $long = $res['dataLong'];
                            $latitude = $res['gatewayLat'];
                            $longitude = $res['gatewayLong'];
                            $gateway = $res['name'];

                            $result = (seperateData($rssi, $snr, $lat, $long, $from, $to, $gateway, $latitude, $longitude));
                        }
                        array_push($everything, $result);
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



            //TODO: Check when no values
            $allGateways = array();
            $newArray = array();
            foreach ($everything as $check) {
                if (!in_array($check[4], $newArray)) {
                    if (!empty($newArray)) {
                        $newArray = array_chunk($newArray, 7);
                        for ($i = 0; $i < sizeof($newArray); $i++){
                            if (isset($_POST['choiceRadios'])){
                                if ($_POST['choiceRadios'] == "SNR") {
                                    echo "<script>SNRmarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
                                } else {
                                    echo "<script>RSSImarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
                                }
                            }
                        }
                    }
                    echo "<script>greenSNR = [];blueSNR = [];yellowSNR  = [];orangeSNR = [];redSNR = [];greenRSSI;blueRSSI = [];yellowRSSI = [];orangeRSSI = [];redRSSI  = [];</script>";
                    unset($newArray);
                    $newArray = array();
                }
                if (empty($newArray)) {
                    array_push($newArray, $check[0], $check[1],$check[2], $check[3], $check[4],$check[5], $check[6]);
                } else {
                    array_push($newArray, $check[0], $check[1],$check[2], $check[3], $check[4],$check[5], $check[6]);
                }
                echo "<br>";
            }
            $newArray = array_chunk($newArray, 7);
            for ($i = 0; $i < sizeof($newArray); $i++){
                if (isset($_POST['choiceRadios'])){
                    if ($_POST['choiceRadios'] == "SNR") {
                        echo "<script>SNRmarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
                    } else {
                        echo "<script>RSSImarkers(" . $newArray[$i][2] . "," . $newArray[$i][3] . "," . $newArray[$i][0] . "," . $newArray[$i][1] .  ",'" . $newArray[$i][4] . "'," . $newArray[$i][5] .  "," . $newArray[$i][6] .")</script>";
                    }
                }
            }

            ?>

        </div>
    </div>

