<?php?>
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
            <?php
            $query = $conn->prepare("SELECT * FROM color WHERE config_id=:conf");
            $query->execute(array(
                ":conf"=> $_SESSION['config_id']
            ));

            $query = $query->fetch(PDO::FETCH_ASSOC);

            $lowest = $query['lowest'];
            $low = $query['low'];
            $med = $query['medium'];
            $high = $query['high'];
            $highest = $query['highest'];

            ?>


            let lowest = "#" + <?= json_encode($lowest) ?>;
            let low = "#" + <?= json_encode($low) ?>;
            let med = "#" + <?= json_encode($med) ?>;
            let high = "#" + <?= json_encode($high) ?>;
            let highest = "#" + <?= json_encode($highest) ?>;


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


            function SNRmarkers(lat, long, snr, rssi, time, gateway, gLat, gLong) {
                console.log(lat, long, snr, gateway, gLat, gLong);
                if (snr <= 3) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + lowest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // greenSNR.push(marker.getLatLng());
                    // greenSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 3 && snr <= 5) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + low + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // blueSNR.push(marker.getLatLng());
                    // blueSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 5 && snr <= 7) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + med + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // yellowSNR.push(marker.getLatLng());
                    // yellowSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 7 && snr <= 9) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + high + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // orangeSNR.push(marker.getLatLng());
                    // orangeSNR.push(({lat: gLat, lng: gLong}));
                } else {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + highest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // redSNR.push(marker.getLatLng());
                    // redSNR.push(({lat: gLat, lng: gLong}));
                }
                var polyline = L.polyline(greenSNR, {color: 'green', fillColor: 'green'}).addTo(map);
                var polyline = L.polyline(blueSNR, {color: 'blue', fillColor: 'blue'}).addTo(map);
                var polyline = L.polyline(yellowSNR, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
                var polyline = L.polyline(orangeSNR, {color: 'orange', fillColor: 'orange'}).addTo(map);
                var polyline = L.polyline(redSNR, {color: 'red', fillColor: 'red'}).addTo(map);

                // console.log(yellowSNR);
            }

            var greenRSSI = Array();
            var blueRSSI = Array();
            var yellowRSSI = Array();
            var orangeRSSI = Array();
            var redRSSI = Array();

            function RSSImarkers(lat, long, snr, rssi, gateway, gLat, gLong) {
                if (Math.abs(rssi) <= 10) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + lowest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // greenRSSI.push(marker.getLatLng());
                    // greenRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 10 && Math.abs(rssi) <= 32) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + low + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // blueRSSI.push(marker.getLatLng());
                    // blueRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 32 && Math.abs(rssi) <= 60) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + med + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // yellowRSSI.push(marker.getLatLng());
                    // yellowRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 60 && Math.abs(rssi) <= 80) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + high + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // orangeRSSI.push(marker.getLatLng());
                    // orangeRSSI.push(({lat: gLat, lng: gLong}));
                } else {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + highest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    // redRSSI.push(marker.getLatLng());
                    // redRSSI.push(({lat: gLat, lng: gLong}));
                }
                var polyline = L.polyline(greenRSSI, {color: 'green', fillColor: 'green'}).addTo(map);
                var polyline = L.polyline(blueRSSI, {color: 'blue', fillColor: 'blue'}).addTo(map);
                var polyline = L.polyline(yellowRSSI, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
                var polyline = L.polyline(orangeRSSI, {color: 'orange', fillColor: 'orange'}).addTo(map);
                var polyline = L.polyline(redRSSI, {color: 'red', fillColor: 'red'}).addTo(map);
            }

            function gateways(lat, long, name) {
                console.log(lat, long, name);
                L.marker([lat, long]).addTo(map)
                .bindPopup('Name: ' + name)
                .openPopup();
            }

        </script>