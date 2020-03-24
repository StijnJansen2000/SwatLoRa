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
            'center': [39.46975,-0.37739],
            'zoom': 14,
            'layers': [tileLayer]
        });

        function markerColor(color){
            var markerColor = L.icon({
                iconUrl: 'images/marker' + color+ '.png',
                iconSize:     [40, 40]
            });

            return markerColor;
        }

        var greenSNR = Array();
        var blueSNR = Array();
        var yellowSNR = Array();
        var orangeSNR = Array();
        var redSNR = Array();

        var greenRSSI = Array();
        var blueRSSI = Array();
        var yellowRSSI = Array();
        var orangeRSSI = Array();
        var redRSSI = Array();

        function SNRmarkers(lat, long, snr, rssi) {
            if (snr <= 3){
                var marker = L.marker([lat, long], {icon: markerColor("Green")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                greenSNR.push(marker.getLatLng());
            } else if(snr > 3 && snr <= 5){
                var marker = L.marker([lat, long], {icon: markerColor("Blue")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                blueSNR.push(marker.getLatLng());
            } else if(snr > 5 && snr <= 7){
                var marker = L.marker([lat, long], {icon: markerColor("Yellow")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                yellowSNR.push(marker.getLatLng());
            } else if (snr > 7 && snr <= 9){
                var marker = L.marker([lat, long], {icon: markerColor("Orange")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                orangeSNR.push(marker.getLatLng());
            } else {
                var marker = L.marker([lat, long], {icon: markerColor("Red")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                redSNR.push(marker.getLatLng());
            }
            var polyline = L.polyline(greenSNR, {color: 'green', fillColor: 'green'}).addTo(map);
            var polyline = L.polyline(blueSNR, {color: 'blue', fillColor: 'blue'}).addTo(map);
            var polyline = L.polyline(yellowSNR, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
            var polyline = L.polyline(orangeSNR, {color: 'orange', fillColor: 'orange'}).addTo(map);
            var polyline = L.polyline(redSNR, {color: 'red', fillColor: 'red'}).addTo(map);
        }

        function RSSImarkers(lat, long, snr, rssi) {
            if (Math.abs(rssi) <= 10){
                var marker = L.marker([lat, long], {icon: markerColor("Green")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                greenRSSI.push(marker.getLatLng());
            } else if(Math.abs(rssi) > 10 && Math.abs(rssi) <= 32){
                var marker = L.marker([lat, long], {icon: markerColor("Blue")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                blueRSSI.push(marker.getLatLng());
            } else if(Math.abs(rssi) > 32 && Math.abs(rssi) <= 60){
                var marker = L.marker([lat, long], {icon: markerColor("Yellow")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                yellowRSSI.push(marker.getLatLng());
            } else if (Math.abs(rssi) > 60 && Math.abs(rssi) <= 80){
                var marker = L.marker([lat, long], {icon: markerColor("Orange")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                orangeRSSI.push(marker.getLatLng());
            } else {
                var marker = L.marker([lat, long], {icon: markerColor("Red")}).addTo(map)
                    .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                    .openPopup();
                redRSSI.push(marker.getLatLng());
            }
            var polyline = L.polyline(greenRSSI, {color: 'green', fillColor: 'green'}).addTo(map);
            var polyline = L.polyline(blueRSSI, {color: 'blue', fillColor: 'blue'}).addTo(map);
            var polyline = L.polyline(yellowRSSI, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
            var polyline = L.polyline(orangeRSSI, {color: 'orange', fillColor: 'orange'}).addTo(map);
            var polyline = L.polyline(redRSSI, {color: 'red', fillColor: 'red'}).addTo(map);
        }

        function gateways(lat,long, name){
            L.marker([lat, long]).addTo(map)
                .bindPopup('Name: ' + name )
                .openPopup();
        }

    </script>



    <!-- Side bar -->
    <div id="sidebar">
        <?php
            include 'php/dbh.php';
            require 'php/library.php';
        ?>

        <form action="" method="post" id="form">
            <div class="form-group">
                <?php
                    $i = 0;
                    foreach ($conn->query('SELECT * FROM gateway') as $row){
                        $getRows = $conn->query('SELECT dataname FROM data WHERE gateway_id=' . $row['gateway_id']);
                        if ($getRows->rowCount() != 0){
                            echo "<h2>" . $row['name'] . "</h2>";
                            ?> <script>
                                    var latitude = "<?php echo $row['latitude']?>"
                                    var longitude = "<?php echo $row['longitude']?>"
                                    var gatewayName = "<?php echo $row['name']?>";
                                    gateways(latitude, longitude, gatewayName);
                                </script>
                                <?php
                        }
                        foreach ($getRows as $data){;
                            ?>
                            <div class="form-group">
                                <input type="checkbox" class="form-control-input" id="InputCheck" name="<?php echo $data['dataname'] ?>"
                                    <?php
                                        if (isset($_POST['submitLoad'])|| isset($_POST['SubmitButton'])) {
                                            foreach ($_POST as $key => $value) {
                                                if ($value == "on") {
                                                    if ($key == $data['dataname']) {
                                                        echo "checked";
                                                    }
                                                }
                                            }
                                        } elseif (isset($_POST['submitSpec'])) {
                                            if ($_POST['dataName'] == $data['dataname']){
                                                echo "checked";
                                            }
                                        } elseif (isset($_POST['showGateway'])){
                                            if ($_POST['gateway'] == $row['name']){
                                                echo "checked";
                                            }
                                        }
                                    ?>

                                >
                                <label class="form-check-label" for="InputCheck"><?php echo $data['dataname'] ?></label>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
            <div class="form-group">
                <label for="choiceRadios">Choose SNR or RSSI:</label>
                <div class="form-check">
                        <input class="form-check-input" type="radio" name="choiceRadios" id="radio1" value="SNR" <?php if ($_POST['choiceRadios'] == "SNR") echo "checked"?>>
                    <label class="form-check-label" for="radio1">
                        SNR
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="choiceRadios" id="radio2" value="RSSI" value="SNR" <?php if ($_POST['choiceRadios'] == "RSSI") echo "checked"?>>
                    <label class="form-check-label" for="radio2">
                        RSSI
                    </label>
                </div>
            </div>
            <input type="submit" name="SubmitButton" value="Load Data" class="btn btn-primary"/>
        </form>
        <?php
            if (isset($_POST['SubmitButton'])) {
//                echo "<pre>";
//                    print_r($_POST);
//                echo "</pre>";

                foreach ($_POST as $key => $value) {
                    $checkRow = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                    if ($checkRow->rowCount() != 0) {
                        if ($checkRow->fetch()['oneValue'] != "") {
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $sensor = ($q->fetch()['oneValue']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $from = ($q->fetch()['dateFrom']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $to = ($q->fetch()['dateTo']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $gateway = $q->fetch()['gateway_id'];
                            $q = $conn->query("SELECT name FROM gateway WHERE gateway_id='" . $gateway . "'");
                            $gateway = $q->fetch()['name'];
                            $result = oneSensorData($sensor, $from, $to, $gateway);

                        } else {
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $snr = ($q->fetch()['snr']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $rssi = ($q->fetch()['rssi']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $lat = ($q->fetch()['latitude']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $long = ($q->fetch()['longitude']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $from = ($q->fetch()['dateFrom']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $to = ($q->fetch()['dateTo']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $gateway = $q->fetch()['gateway_id'];
                            $q = $conn->query("SELECT name FROM gateway WHERE gateway_id='" . $gateway . "'");
                            $gateway = $q->fetch()['name'];
                            $result = (seperateData($rssi, $snr, $lat, $long, $from, $to, $gateway));
//                            echo "<script>markers(" . $result[2] .",". $result[3] .",". $result[0] .",". $result[1] . ")</script>";

                        }
                        if ($_POST['choiceRadios'] == "SNR"){
                            echo "<script>SNRmarkers(" . $result[2] .",". $result[3] .",". $result[0] .",". $result[1] . ")</script>";
                        } else {
                            echo "<script>RSSImarkers(" . $result[2] .",". $result[3] .",". $result[0] .",". $result[1] . ")</script>";
                        }
                    }
                }
            } elseif (isset($_POST['submitLoad'])){
                foreach ($_POST as $key => $value) {
                    if ($value == "on"){
                        $checkRow = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                        if ($checkRow->rowCount() != 0) {
                            if ($checkRow->fetch()['oneValue'] != "") {
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $sensor = ($q->fetch()['oneValue']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $from = ($q->fetch()['dateFrom']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $to = ($q->fetch()['dateTo']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $gateway = $q->fetch()['gateway_id'];
                                $q = $conn->query("SELECT name FROM gateway WHERE gateway_id='" . $gateway . "'");
                                $gateway = $q->fetch()['name'];
                                $result = oneSensorData($sensor, $from, $to, $gateway);
//                                echo "<script>markers(" . $result[2] .",". $result[3] .",". $result[0] .",". $result[1] . ")</script>";
                            } else {
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $snr = ($q->fetch()['snr']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $rssi = ($q->fetch()['rssi']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $lat = ($q->fetch()['latitude']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $long = ($q->fetch()['longitude']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $from = ($q->fetch()['dateFrom']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $to = ($q->fetch()['dateTo']);
                                $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                                $gateway = $q->fetch()['gateway_id'];
                                $q = $conn->query("SELECT name FROM gateway WHERE gateway_id='" . $gateway . "'");
                                $gateway = $q->fetch()['name'];
                                $result = seperateData($rssi, $snr, $lat, $long, $from, $to, $gateway);
//                                echo "<script>markers(" . $result[2] .",". $result[3] .",". $result[0] .",". $result[1] . ")</script>";
                            }
                            if ($_POST['choiceRadios'] == "SNR"){
                                echo "<script>SNRmarkers(" . $result[2] .",". $result[3] .",". $result[0] .",". $result[1] . ")</script>";
                            } else {
                                echo "<script>RSSImarkers(" . $result[2] .",". $result[3] .",". $result[0] .",". $result[1] . ")</script>";
                            }
                        }
                    }
                }
//                echo "<pre>";
//                print_r($_POST);
//                echo "</pre>";

            }

            ?>

    </div>
</div>

